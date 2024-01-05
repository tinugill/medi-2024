import { Component, OnInit } from '@angular/core';
import { ActivatedRoute, Router, Params } from '@angular/router';
import { TokenStorageService } from '../../../services/Token/token-storage.service';
import { PayServiceService } from '../../../services/Payment/pay-service.service';
import { ApiService } from '../../../services/Api/api.service';
import { Toaster } from 'ngx-toast-notifications';
import { NgbModal } from '@ng-bootstrap/ng-bootstrap';
import { NgxSpinnerService } from 'ngx-spinner';
import {
  AbstractControl,
  FormBuilder,
  FormGroup,
  Validators,
  FormArray,
} from '@angular/forms';
@Component({
  selector: 'app-lab-details',
  templateUrl: './lab-details.component.html',
  styleUrls: ['./lab-details.component.scss'],
})
export class LabDetailsComponent implements OnInit {
  constructor(
    private tokenStorage: TokenStorageService,
    private modalService: NgbModal,
    private ApiService: ApiService,
    private _Activatedroute: ActivatedRoute,
    private rzp: PayServiceService,
    private formBuilder: FormBuilder,
    private toaster: Toaster,
    private spinner: NgxSpinnerService
  ) {}
  tab = 'test';
  ngOnInit(): void {
    this._Activatedroute.paramMap.subscribe((params) => {
      this.slug = params.get('slug');
      if (this.slug != '') {
        this.getLabInfo(this.slug);
      }
    });

    this.form = this.formBuilder.group({
      lab_id: ['', Validators.required],
      cart: [''],
      is_home_collection: [''],
      is_home_delivery: [''],
      is_ambulance: [''],
      price: [''],
      h_c_price: [''],
      h_d_price: [''],
      ambulance_price: [''],
      address: [''], 
    });
  }
  form: FormGroup | any;
  submitted: boolean = false;

  appointmentId: any = '';
  slug: any = '';
  dInfo: any = '';
  tList: any = [];
  pList: any = [];
  testInfo: any = [];
  buyType:any = '';
  totalAmount :any = 0;
  cartArray:any = [];
  bkInfo : any = {
    prerequisite : '',
    price : '',
    home_sample_collection : '',
    report_home_delivery : '',
    ambulance_available : '',
    ambulance_fee : ''
  };
  stars:any = 0;
  get f(): { [key: string]: AbstractControl } {
    return this.form.controls;
  }
  openBuyModel(modalName: any) {
    let prerequisite = '';
    let price = 0;
    let hc = '';
    let rc = '';
    let ab = '';
    let highestAmbFee = 0;
    this.cartArray.forEach((element:any) => {
      console.log('element',element);
      
      if(element?.type == "labpackage"){
        element.raw?.tList.forEach((e:any) => {
          if(e.prerequisite){ 
            prerequisite += (e.test_name + ' => ' +e.prerequisite) + '</br><hr/>';
          }
        });

      }else{
        if(element.raw?.prerequisite){ 
          prerequisite += (element.raw?.test_name + ' => ' +element.raw?.prerequisite) + '</br><hr/>';
        }
      }
      
      if(element.raw?.home_sample_collection == 'Yes'){
        hc += element.title + ' - INR ' +this.dInfo?.h_c_fee + '</br>';
      }
      if(element.raw?.report_home_delivery == 'Yes'){
        rc += element.title + ' - INR ' +this.dInfo?.r_d_fee + '</br>';
      }
      if(element.raw?.ambulance_available == 'Yes'){
        if(highestAmbFee < element.raw?.ambulance_fee){
          highestAmbFee = element.raw?.ambulance_fee;
        }
        
        ab += element.title + ' - INR ' +highestAmbFee + '</br>';
      }
      price += element.price;
    });
    this.bkInfo.prerequisite = prerequisite;
    this.bkInfo.price = price; 
    this.bkInfo.home_sample_collection = hc;
    this.bkInfo.report_home_delivery = rc;
    this.bkInfo.ambulance_available = ab;
    this.bkInfo.ambulance_fee = highestAmbFee;

    this.amountChange();
    
    this.modalService.open(modalName, {
      centered: true,
      size: 'md',
      backdropClass: 'light-blue-backdrop',
    });
  }
  viewTestDetails(info:any ,type:any = 'buy', modalName:any = '') {
    let p = (info?.price - (info?.discount*info?.price/100));
    let title = '';
    if(type == 'buy'){
      this.buyType = 'test';
      title = info.test_name;
    }else if(type == 'labpackage'){
      this.buyType = 'labpackage';
      title = info.package_name;
    }else{
      this.buyType = '';
    } 
    if(type != 'view'){
      let arr = {id: info.id, type: this.buyType, price: p, title : title, raw: info};
      this.cartArray.push(arr);
    }else{
      console.log('====',info);
      
      this.bkInfo = {...info};
      this.modalService.open(modalName, {
        centered: true,
        size: 'md',
        backdropClass: 'light-blue-backdrop',
      });
    } 
    
  }
  removeOrder(id:any, type: any){  
    const index = this.cartArray.findIndex((obj:any) => obj.id == id && obj.type == type);
    console.log('index',index);
    
    if (index > -1) {
      this.cartArray.splice(index, 1);
    }
  }
  isNotExist(id:any, type: any){
    let isNotExist = this.cartArray.find((f:any) => f.id == id && f.type == type);
    if(isNotExist){
      return false;
    }else{
      return true;
    }
  }
  getLabInfo(slug: any): void {
    this.spinner.show();
    this.ApiService.getLabInfo(slug).subscribe(
      (data) => {
        if (data.status) {
          this.dInfo = data.data;
          if(this.dInfo.reviews?.user_id){
            this.stars = parseFloat(this.dInfo.reviews.avg_stars); 
          }
          this.tList = data.data.tesList;
          this.pList = data.data.packageList;
        } else {
          this.toaster.open({
            text: data.message,
            caption: 'Error',
            duration: 4000,
            type: 'danger',
          });
        }
        this.spinner.hide();
      },
      (err) => {
        this.toaster.open({
          text: err.error.message,
          caption: 'Message',
          duration: 4000,
          type: 'danger',
        });
        this.spinner.hide();
      }
    );
  }
  amountChange(){
    let hcp = 0;
    let hdp = 0;
    let ambp = 0;
    let price = 0;
    let highestAmbFee = 0;
    this.cartArray.forEach((element:any) => { 
      price += element.price;
      if(highestAmbFee < element.raw?.ambulance_fee){
        highestAmbFee = element.raw?.ambulance_fee;
      }
    });


    if(this.form.value.is_home_collection == 'Yes' && price <= this.dInfo?.h_c_fee_apply_before){
      this.form.controls['h_c_price'].setValue(this.dInfo?.h_c_fee);
      hcp = this.dInfo?.h_c_fee;
    }else{
      this.form.controls['h_c_price'].setValue(0);
    }
    if(this.form.value.is_home_delivery == 'Yes' && price <= this.dInfo?.r_d_fee_apply_before){
      this.form.controls['h_d_price'].setValue(this.dInfo?.r_d_fee);
      hdp = this.dInfo?.r_d_fee;
    }else{
      this.form.controls['h_d_price'].setValue(0);
    }
    if(this.form.value.is_ambulance == 'Yes'){
      this.form.controls['ambulance_price'].setValue(highestAmbFee);
      // highestAmbFee = this.dInfo?.ambulance_fee;
    }else{
      this.form.controls['h_d_price'].setValue(0);
      highestAmbFee = 0;
    }
    this.totalAmount = +price + +hcp + +hdp + +highestAmbFee; 
    this.form.controls['price'].setValue(this.totalAmount);
  }
  submitForm(){
    this.amountChange();
    this.form.controls['lab_id'].setValue(this.dInfo?.id);
    this.form.controls['cart'].setValue(this.cartArray); 
    
    if (this.form.invalid) {
      this.toaster.open({
        text: 'Select all fields',
        caption: 'Error',
        duration: 4000,
        type: 'danger',
      });
      return;
    }
    this.spinner.show();
    this.ApiService.bookAppointmentLabtest(this.form.value).subscribe(
      (data) => {
        if (data.status) {
          this.toaster.open({
            text: 'Loading please wait....',
            caption: 'Success',
            duration: 4000,
            type: 'success',
          });
          this.appointmentId = data.data.id;
          this.spinner.hide();
          this.rzp.createRzpayOrder(this.totalAmount,this.appointmentId,'labtest');
          this.submitted = false;
        } else { 
          this.toaster.open({
            text: data.message,
            caption: 'Error',
            duration: 4000,
            type: 'danger',
          });
          this.spinner.hide();
        }
      },
      (err) => {
        this.toaster.open({
          text: err.error.message,
          caption: 'Message',
          duration: 4000,
          type: 'danger',
        });
        this.spinner.hide();
      }
    );
  }
}
