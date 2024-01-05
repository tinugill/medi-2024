import { Component, OnInit } from '@angular/core';
import { ActivatedRoute, Router, Params } from '@angular/router';
import { TokenStorageService } from '../../../services/Token/token-storage.service';
import { ApiService } from '../../../services/Api/api.service';
import { PayServiceService } from '../../../services/Payment/pay-service.service';
import { Toaster } from 'ngx-toast-notifications';
import { NgxSpinnerService } from 'ngx-spinner';
import { NgbModal } from '@ng-bootstrap/ng-bootstrap';
import {
  AbstractControl,
  FormBuilder,
  FormGroup,
  Validators,
} from '@angular/forms';
@Component({
  selector: 'app-ambulance-info',
  templateUrl: './ambulance-info.component.html',
  styleUrls: ['./ambulance-info.component.scss']
})
export class AmbulanceInfoComponent implements OnInit {

  constructor(
    private tokenStorage: TokenStorageService,
    private ApiService: ApiService,
    private _Activatedroute: ActivatedRoute,
    private formBuilder: FormBuilder,
    private toaster: Toaster,
    private spinner: NgxSpinnerService,
    private rzp: PayServiceService,
    private modalService: NgbModal
  ) {}

  ngOnInit(): void {
    this._Activatedroute.paramMap.subscribe((params) => {
      this.slug = params.get('slug');
      if (this.slug != '') {
        this.getAmbulanceServiceProvider(this.slug);
      }
    });
    this.lForm = this.formBuilder.group({
      name: ['', Validators.required],  
      mobile: ['', Validators.required],
      date: ['', Validators.required],
      ambulance_id: ['', Validators.required],
      address: ['', Validators.required],
      drop_address: ['', Validators.required],
      booking_type: ['', Validators.required],
      booking_for: [1, Validators.required],
      service_ambulance_id: ['', Validators.required],
    }); 
  }
  stars:any = 0;
  lForm: FormGroup | any;
  b2: boolean = false;
  slug: any = '';
  dInfo: any = ''; 
  activeData:any = {};
  activeDataImg:any = {};
  activeDataImgName:any = '';
  appointmentId: any = '';
  get f2(): { [key: string]: AbstractControl } {
    return this.lForm.controls;
  }
 
  getAmbulanceServiceProvider(slug: any): void {
    this.spinner.show();
    this.ApiService.getAmbulanceServiceProvider(slug).subscribe(
      (data) => {
        if (data.status) {
          this.dInfo = data.data;
          if(this.dInfo.reviews?.user_id){
            this.stars = parseFloat(this.dInfo.reviews.avg_stars); 
          }
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
  changeImg(img:any){
    this.activeDataImgName = img;
  }
  viewImg(modalName: any, info:any) {
    this.activeDataImg = info;
    this.activeDataImgName = this.activeDataImg?.img_1;
    this.modalService.open(modalName, {
      centered: true,
      size: 'lg',
      backdropClass: 'light-blue-backdrop',
    });
  }
  bookAmb(modalName: any, info:any, type:any) {
    this.activeData = info;
    this.lForm.controls['ambulance_id'].setValue(this.dInfo.id);
    this.lForm.controls['booking_type'].setValue(type);
    this.lForm.controls['service_ambulance_id'].setValue(info.id);
    this.modalService.open(modalName, {
      centered: true,
      size: 'sm',
      backdropClass: 'light-blue-backdrop',
    });
  }
  onSubmitBr() {
    this.b2 = true;
    if (this.lForm.invalid) {
      this.toaster.open({
        text: 'Fill all required fields',
        caption: 'Message',
        duration: 4000,
        type: 'danger',
      });
      return;
    }
    this.ApiService.ambulanceBookingForm(
      this.lForm.value,
      this.dInfo?.id
    ).subscribe(
      (data) => {
        if (data.status) {
          this.modalService.dismissAll();
          this.toaster.open({
            text: 'Loading please wait....',
            caption: 'Success',
            duration: 4000,
            type: 'success',
          });
          this.b2 = false;
          this.appointmentId = data.data.id;
          let price:any = 0;
          if(this.lForm.value.booking_type == 'day'){
            price = this.lForm.value.booking_for*(this.activeData?.charges_per_day - (this.activeData?.charges_per_day * this.activeData?.discount_per_day /100));
          }else{
            price = this.lForm.value.booking_for*(this.activeData?.charges_per_km - (this.activeData?.charges_per_km * this.activeData?.discount_per_km /100));
          }
          price = price.toFixed(2);
          this.rzp.createRzpayOrder(price,this.appointmentId,'ambulance');
          
        } else {
          this.toaster.open({
            text: data.message,
            caption: 'Error',
            duration: 4000,
            type: 'danger',
          });
        }
      },
      (err) => {
        this.toaster.open({
          text: err.error.message,
          caption: 'Message',
          duration: 4000,
          type: 'danger',
        });
      }
    );
  }

}
