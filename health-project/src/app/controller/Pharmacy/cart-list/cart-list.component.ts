import { Component, OnInit } from '@angular/core';

import { PayServiceService } from '../../../services/Payment/pay-service.service';
import { Toaster } from 'ngx-toast-notifications';
import { TokenStorageService } from '../../../services/Token/token-storage.service';
import { ApiService } from '../../../services/Api/api.service';
import { CartService } from '../../../services/Cart/cart.service';
import { NgxSpinnerService } from 'ngx-spinner';
import {
  AbstractControl,
  FormBuilder,
  FormGroup,
  Validators,
} from '@angular/forms';
@Component({
  selector: 'app-cart-list',
  templateUrl: './cart-list.component.html',
  styleUrls: ['./cart-list.component.scss']
})
export class CartListComponent implements OnInit {

  constructor( private tokenStorage: TokenStorageService, private formBuilder: FormBuilder,
    private ApiService: ApiService,
    private toaster: Toaster,
    private cart: CartService,private spinner: NgxSpinnerService,private rzp: PayServiceService) { }
   
  cartItem: any = [];
  infoList: any = [];
  cartId: any = '';
  pForm: FormGroup | any;
  sb:boolean = false;
  mndate:any = new Date();
  ReqDate:any;
  userInfo:any;
  ngOnInit(): void {
    this.userInfo = this.tokenStorage.getUser();
     
    this.pForm = this.formBuilder.group({
      image: [''],
      address: ['', Validators.required],
      locality: [''],
      pincode: ['', Validators.required],
      city: ['', Validators.required],
      req_date: [''],
      record_image: [''],
    });
    this.cartItem = this.cart.getList();
    this.getCartInfo();
  }
  get f(): { [key: string]: AbstractControl } {
    return this.pForm.controls;
  }
  addToCart(id: any, type: any) {
    let d = document.getElementById('qty_'+id) as HTMLElement |any;
    this.cart.addItem(type, id, d?.value);
  }
  updateToCart(e:any,id:any,type:any) {  
    this.cart.findItemAndUpdate(id, type, e.target.value); 
  }
  removeFromCart(id: any, type: any) {
    this.cart.removeItem(type, id);
  }
  convertToDate(str:any) {
    var date = new Date(str),
      mnth = ("0" + (date.getMonth() + 1)).slice(-2),
      day = ("0" + date.getDate()).slice(-2);
    return [date.getFullYear(), mnth, day].join("-");
  }
  buyNow(){
    if(this.cartItem?.length == 0){
      this.toaster.open({
        text: 'Enter something in cart',
        caption: 'Error',
        duration: 4000,
        type: 'danger',
      });
      return;
    }
    this.sb = true;
    if (this.pForm.invalid && this.infoList?.isAddressRequired) { 
      this.toaster.open({
        text: 'Enter address fields',
        caption: 'Error',
        duration: 4000,
        type: 'danger',
      });
      return;
    }
     
    if (this.infoList?.isPackageAdded && !this.ReqDate) { 
      this.toaster.open({
        text: 'Enter date for tratment',
        caption: 'Error',
        duration: 4000,
        type: 'danger',
      });
      return;
    }
    this.pForm.value.req_date = this.convertToDate(this.ReqDate);
    
    if(this.infoList?.prescription_required){
      let img = this.pForm.value.image;  
      if(img == ''){
        this.toaster.open({
          text: 'Upload Prescription',
          caption: 'Error',
          duration: 4000,
          type: 'danger',
        });
        return;
      }
    }
    this.spinner.show();
    this.ApiService.buyCartInfo(this.cartItem).subscribe(
      (data) => {
        if (data.status) {
          this.spinner.hide();
          this.toaster.open({
            text: 'Loading please wait....',
            caption: 'Success',
            duration: 4000,
            type: 'success',
          }); 
          let amount = data.data?.total - data.data?.discount; 
          if(amount > 0){ 
            let sendData = JSON.stringify({cart_ids: data.data.itemIds, data:this.pForm.value, total:this.infoList?.total, discount: this.infoList?.discount});
            this.rzp.createRzpayOrder(amount,sendData,'cart'); 
            // this.cart.clearList();
          }else{
            this.toaster.open({
              text: 'Invalid cart amount',
              caption: 'Error',
              duration: 4000,
              type: 'danger',
            });
          }
          
        } else { 
          this.spinner.hide();
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
        this.spinner.hide();
      }
    );
  }
  changeFromCart(index:any, action:any){
    this.cart.plusminus(index, action).subscribe(
      (data) => {
        this.cartItem = data;
        this.getCartInfo();
      },
      (err) => {}); 
  }
  removeFromCartByIndex(index:any){
    this.cart.removeItemByIndex(index).subscribe(
      (data) => {
        this.cartItem = data;
        this.getCartInfo();
      },
      (err) => {}); ;  
  }
  onFileChange(e: any, type:any = ''): void {
    const reader = new FileReader();

    if (e.target.files && e.target.files.length) {
      const file = e.target.files[0];
      reader.readAsDataURL(file);
      if(type == ''){
        reader.onload = () => {  
          this.pForm.patchValue({
            image: reader.result,
          });   
        };
      }else if(type == 'record'){ //workpending
        let fl:any = [];
        for(let i = 0 ; i <  e.target.files.length; i++){
          let f =  e.target.files[i];
          let reader2 = new FileReader();
          reader2.readAsDataURL(f);
          reader2.onload = () => {  
            fl.push(reader2.result);
          };
        }
        this.pForm.patchValue({
          record_image: fl,
        }); 
      }
    }
  }
  getCartInfo(): void {
    this.spinner.show();
    this.ApiService.getCartInfo(this.cartItem).subscribe(
      (data) => {
        if (data.status) {
          this.infoList = data.data;
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

}
