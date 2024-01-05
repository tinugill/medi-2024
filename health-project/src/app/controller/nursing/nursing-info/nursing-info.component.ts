import { Component, OnInit } from '@angular/core';
import { ActivatedRoute, Router, Params } from '@angular/router';
import { TokenStorageService } from '../../../services/Token/token-storage.service';
import { PayServiceService } from '../../../services/Payment/pay-service.service'; 
import { ApiService } from '../../../services/Api/api.service';
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
  selector: 'app-nursing-info',
  templateUrl: './nursing-info.component.html',
  styleUrls: ['./nursing-info.component.scss']
})
export class NursingInfoComponent implements OnInit {

  constructor(
    private tokenStorage: TokenStorageService,
    private rzp: PayServiceService,
    private modalService: NgbModal,
    private ApiService: ApiService,
    private _Activatedroute: ActivatedRoute,
    private formBuilder: FormBuilder,
    private toaster: Toaster,
    private spinner: NgxSpinnerService
  ) {
    this.isLoggedIn = !!this.tokenStorage.getToken();
    if (this.isLoggedIn) {
      this.myInfo = this.tokenStorage.getUser();
    } else {
    }
  }
  ngOnInit(): void {
    this._Activatedroute.paramMap.subscribe((params) => {
      this.id = params.get('id');
      if (this.id != '') {
        this.getNursingList(this.id);
      }
    }); 
    this.form = this.formBuilder.group({
      care_id: ['', Validators.required],
      procedure_id: [''],
      id_proof: ['', Validators.required],
      book_for: ['', Validators.required],
      date: ['', Validators.required],
      qty: ['', Validators.required],
      price: ['', Validators.required],
      type: ['', Validators.required],
      address: ['', Validators.required],
      city: ['', Validators.required],
      pincode: ['', Validators.required]
    });
     
  }
  get f(): { [key: string]: AbstractControl } {
    return this.form.controls;
  }
  get f2(): { [key: string]: AbstractControl } {
    return this.pform.controls;
  } 
  stars:any = 0;
  isLoggedIn: boolean = false;
  myInfo: any = '';
  pform: FormGroup | any;
  form: FormGroup | any;
  submitted: boolean = false;
  submitted2: boolean = false;
  id: any = '';
  dInfo: any = '';
  hoursCount: any = 1;
  dayCount: any = 1;
  monthCount: any = 1;
  bookingType : any = '';
  appointmentId: any = '';
  book_for: any = '';
  pList:any = [];

  getNursingProcedureAll(id:any=''): void {
    this.spinner.show();
    this.ApiService.getNursingProcedureAll(id, this.dInfo?.id).subscribe(
      (data) => {
        if (data.status) {
          this.pList = data.data; 
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
      (err) => {}
    );
  }
  getNursingList(id:any): void {
    this.spinner.show();
    this.ApiService.getNursingList(
      '', 
      id,
      ''
    ).subscribe(
      (data) => {
        if (data.status) {
          this.dInfo = data.data; 
          if(this.dInfo.reviews?.user_id){
            this.stars = parseFloat(this.dInfo.reviews.avg_stars); 
          }
          this.getNursingProcedureAll();
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
        
    this.spinner.hide();
      }
    );
  }
  bookProcedure(id:any,price:any,modalName: any){ 
    price = price + this.dInfo?.visit_charges
    this.form.controls['qty'].setValue(1);
    this.form.controls['procedure_id'].setValue(id);
    this.form.controls['care_id'].setValue(this.dInfo.id);
    this.form.controls['type'].setValue(this.bookingType);
    this.form.controls['price'].setValue(price);
    this.form.controls['book_for'].setValue('procedure');
    this.bookingType = 'Procedure';
    this.modalService.open(modalName, {
      centered: true,
      size: 'md',
      backdropClass: 'light-blue-backdrop',
    }); 
  }
  bookNow(type:any,modalName: any) {
    this.bookingType = type;
    let qty = 0;
    let price = 0; 
    if(this.bookingType == 'hour'){ 
      qty  = this.hoursCount; 
      price  = this.dInfo?.per_hour_charges*qty;
    }else if(this.bookingType == 'day'){ 
      qty  = this.dayCount;
      price  = this.dInfo?.per_days_charges*qty;
    } else if(this.bookingType == 'month'){ 
      qty  = this.monthCount;
      price  = this.dInfo?.per_month_charges*qty;
    } 

    this.form.controls['procedure_id'].setValue(0);
    this.form.controls['qty'].setValue(qty);
    this.form.controls['price'].setValue(price);
    this.form.controls['book_for'].setValue('home_care');
    this.modalService.open(modalName, {
      centered: true,
      size: 'md',
      backdropClass: 'light-blue-backdrop',
    }); 
  }
  submitForm(){    
    this.form.controls['care_id'].setValue(this.dInfo.id);
    this.form.controls['type'].setValue(this.bookingType); 

    this.submitted = true;
    if (this.form.invalid) {
      this.toaster.open({
        text: 'All fields are mandatory',
        caption: 'Error',
        duration: 4000,
        type: 'danger',
      });
      return;
    }
    this.spinner.show();
    this.ApiService.bookHomeCare(this.form.value).subscribe(
      (data) => {
        if (data.status) {
          this.toaster.open({
            text: 'Loading please wait....',
            caption: 'Success',
            duration: 4000,
            type: 'success',
          });
          this.appointmentId = data.data.id;
          let price = this.form.value.price;
          // if(this.bookingType == 'Procedure'){
          //   price = price + this.dInfo?.visit_charges
          // }
          
    this.spinner.hide();
          this.rzp.createRzpayOrder(price,this.appointmentId,'nursing'); 
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
  onFileChange(e: any): void {
    const reader = new FileReader();

    if (e.target.files && e.target.files.length) {
      const file = e.target.files[0];
      reader.readAsDataURL(file);

      reader.onload = () => { 
        this.form.patchValue({
          id_proof: reader.result,
        }); 
      };
    }
  }
}
