import { Injectable } from '@angular/core';
import { Toaster } from 'ngx-toast-notifications';
import { WindowRefService } from './../window-ref-universal.service';
import { ApiService } from './../Api/api.service';
import { TokenStorageService } from './../Token/token-storage.service';
import { Router } from '@angular/router';
import { CartService } from '../../services/Cart/cart.service';
@Injectable({
  providedIn: 'root'
})
export class PayServiceService {

  constructor(private cart: CartService,private winRef: WindowRefService,private toaster: Toaster,private ApiService: ApiService,private tokenStorage: TokenStorageService,private router: Router) {
    this.isLoggedIn = !!this.tokenStorage.getToken();
    if (this.isLoggedIn) {
      this.myInfo = this.tokenStorage.getUser();   
    }
   } 
   appointmentId:any = '';
   orderType : String = '';
  myInfo:any = [];
  isLoggedIn: boolean = false;
  createRzpayOrder(amount:any,appointmentId:any, orderType:any) { 
    this.appointmentId = appointmentId;
    this.orderType = orderType;
    
    this.ApiService.createOrder(amount).subscribe(
      (data) => {
        if (data.status) {
          console.log(data); 
          // call api to create order_id
          this.payWithRazor(data.data);
           
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
  payWithRazor(data: any) {
    const options: any = {
      key: 'rzp_test_nD3visCDqsPFPX',
      amount: data.amount_due, // amount should be in paise format to display Rs 1255 without decimal point
      currency: data.currency,
      name: 'CompanyName', // company name or product name
      description: '', // product description
      image: './assets/img/file/logo.png', // company logo or product image
      order_id: data.order_id, // order_id created by you in backend
      modal: {
        // We should prevent closing of the form when esc key is pressed.
        escape: false,
      },
      prefill: {
        name: this.myInfo.name,
        email: this.myInfo.email,
        contact: this.myInfo.mobile,
      },
      notes: {
        // include notes if any
      },
      theme: {
        color: '#0c238a',
      },
    };
    options.handler = (response: any, error: any) => {  
      options.response = response;
      this.orderResponse(options);
      // call your backend api to verify payment signature & capture transaction
    };
    options.modal.ondismiss = () => {
      // handle the case when user closes the form while transaction is in progress
      alert('Transaction cancelled.');
    };
    const rzp = new this.winRef.nativeWindow.Razorpay(options);
    rzp.open();
  }
  
  orderResponse(response: any) {
    this.ApiService.orderResponse(response, this.appointmentId, this.orderType).subscribe(
      (data) => {
        if (data.status) {  
          this.toaster.open({
            text: data.message,
            caption: 'Success',
            duration: 4000,
            type: 'success',
          });
          this.router.navigate(['/Patient-Record/record'], { queryParams: {type: this.orderType}})
          .then(() => {
            this.cart.clearList();
            window.location.reload();
          });
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
