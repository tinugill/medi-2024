import { Component, Input, OnInit, ChangeDetectorRef, AfterContentChecked } from '@angular/core';

import { PayServiceService } from '../../services/Payment/pay-service.service';
import { ApiService } from '../../services/Api/api.service';
import { Toaster } from 'ngx-toast-notifications';
import { TokenStorageService } from '../../services/Token/token-storage.service';
@Component({
  selector: 'app-listingstatus',
  templateUrl: './listingstatus.component.html',
  styleUrls: ['./listingstatus.component.scss']
})
export class ListingstatusComponent implements OnInit {

  constructor(private cdref: ChangeDetectorRef, private tokenStorage: TokenStorageService,private ApiService: ApiService, private toaster: Toaster,private rzp: PayServiceService) { }
  @Input() service_id : any = '';
  ngOnInit(): void {
    this.myInfo = this.tokenStorage.getUser();
    console.log(this.myInfo);
    
    this.getServiceInfo(this.service_id);
    this.getListingChargesInfo(this.service_id);
  }
  ngAfterContentChecked() {
    this.cdref.detectChanges();
  }
  selectPage:boolean = false;
  myInfo: any = '';
  info:any;
  myStatus:any = '';
  for_count:any = '1';
  couponCode:any = '';
  codeInfo:any = {};
  finalAmount:any = 0;

  calculateDiff(currentDate:any){
    let  dateSent = new Date();
    currentDate = new Date(currentDate);

    return Math.floor((Date.UTC(currentDate.getFullYear(), currentDate.getMonth(), currentDate.getDate()) - Date.UTC(dateSent.getFullYear(), dateSent.getMonth(), dateSent.getDate()) ) /(1000 * 60 * 60 * 24));
}
  getServiceInfo(id:any): void {
    this.ApiService.getServiceInfo(id).subscribe(
      (data) => {
        if (data.status) {
          this.myStatus = data.data;
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
  getListingChargesInfo(id:any): void {
    this.ApiService.getListingChargesInfo(id).subscribe(
      (data) => {
        if (data.status) {
          this.info = data.data;
          this.changePeriod();
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
  nextNow(){
    this.selectPage = !this.selectPage;
  }
  applyNow(){
    if(this.couponCode == ''){
      return;
    }
    this.ApiService.validateCode(this.couponCode).subscribe(
      (data) => {
        if (data.status) {
          if(data.data?.discount){ 
            this.codeInfo = data.data;
            this.toaster.open({
              text: 'Coupon applied '+ this.codeInfo?.discount+'% applied',
              caption: 'Success',
              duration: 4000,
              type: 'success',
            });
            
          }else{
            this.codeInfo = {};
          } 
        } else {
          this.toaster.open({
            text: data.message,
            caption: 'Error',
            duration: 4000,
            type: 'danger',
          });
        }
        this.changePeriod();
      },
      (err) => {
        this.changePeriod();
        this.codeInfo = {};
        this.toaster.open({
          text: err.error.message,
          caption: 'Message',
          duration: 4000,
          type: 'danger',
        });
      }
    );
  }
  changePeriod(){
    let amount = 0;
    let day = 30;
    if(this.for_count == 1){
      amount = this.info?.price - this.info?.discount;
      day = 30;
    }else if(this.for_count == 4){
      amount = this.info?.price_4 - this.info?.discount_4;
      day = 120;
    }else if(this.for_count == 6){
      amount = this.info?.price_6 - this.info?.discount_6;
      day = 180;
    }else if(this.for_count == 12){
      amount = this.info?.price_12 - this.info?.discount_12;
      day = 360;
    }
    console.log('this.for_count',this.for_count, amount);
    
    this.finalAmount = amount;
    if(this.codeInfo?.discount && this.codeInfo?.discount != 0 && this.codeInfo?.discount != ''){
      const percentage = parseFloat(this.codeInfo?.discount);
      const discount = (this.finalAmount / 100) * percentage;
      this.finalAmount = this.finalAmount - discount;
    }
    this.finalAmount = parseFloat(this.finalAmount).toFixed(2);
  }
  payNow(){
    let amount:any = 0;
    let day = 30;
    if(this.for_count == 1){
      amount = this.info?.price - this.info?.discount;
      day = 30;
    }else if(this.for_count == 4){
      amount = this.info?.price_4 - this.info?.discount_4;
      day = 120;
    }else if(this.for_count == 6){
      amount = this.info?.price_6 - this.info?.discount_6;
      day = 180;
    }else if(this.for_count == 12){
      amount = this.info?.price_12 - this.info?.discount_12;
      day = 360;
    }
    if(this.codeInfo?.discount && this.codeInfo?.discount != 0 && this.codeInfo?.discount != ''){
      const percentage = parseFloat(this.codeInfo?.discount);
      const discount = (amount / 100) * percentage;
      amount = amount - discount;
    }
    amount = parseFloat(amount).toFixed(2);
    let sendData = JSON.stringify({service_id: this.service_id, amount:amount, for_count: day, user_id: this.myInfo.id, coupon: this.couponCode});
    this.rzp.createRzpayOrder(amount,sendData,'listing'); 
  }
}
