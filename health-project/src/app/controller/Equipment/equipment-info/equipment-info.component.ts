import { Component, OnInit } from '@angular/core';
import { TokenStorageService } from '../../../services/Token/token-storage.service';
import { ApiService } from '../../../services/Api/api.service';
import { Toaster } from 'ngx-toast-notifications';
import { PayServiceService } from '../../../services/Payment/pay-service.service'; 
import { ActivatedRoute} from '@angular/router';
import { NgxSpinnerService } from 'ngx-spinner';
import {
  AbstractControl,
  FormBuilder,
  FormGroup,
  Validators,
  FormArray,
} from '@angular/forms';
import { CartService } from '../../../services/Cart/cart.service';
@Component({
  selector: 'app-equipment-info',
  templateUrl: './equipment-info.component.html',
  styleUrls: ['./equipment-info.component.scss']
})
export class EquipmentInfoComponent implements OnInit {

  constructor(
    private tokenStorage: TokenStorageService,
    private ApiService: ApiService,
    private toaster: Toaster, 
    private formBuilder: FormBuilder,
    private _Activatedroute: ActivatedRoute,
    private spinner: NgxSpinnerService,
    private rzp: PayServiceService,
    private cart: CartService
  ) {
    this.isLoggedIn = !!this.tokenStorage.getToken();
    if (this.isLoggedIn) {
      this.myInfo = this.tokenStorage.getUser();
    } else {
    }

    this._Activatedroute.paramMap.subscribe((params) => {
      let s = params.get('id');
      if (s != '' && s != undefined) {
        this.productId = s;
        this.getDealerProductList(s);
      }
    });
  }
  get f(): { [key: string]: AbstractControl } {
    return this.form.controls;
  }
  ngOnInit(): void {
    this.city = this.tokenStorage.getSession('city');

    this.form = this.formBuilder.group({
      address: ['', Validators.required],
      city: ['', Validators.required],
      image: [''],
      pincode: ['', Validators.required]
    });
    this.daysLoop = Array(101).fill(1).map((x,i)=>i);
  }
  ngAfterViewInit(): void { 
    this.cartItem = this.cart.getList();
    if(this.cartItem?.length > 0){
      setTimeout(() => {
        let select:any ;
        this.cartItem.forEach((element:any) => { 
          if(element.type == 'equp' && element.is_equp == 'purchase' && element.id == this.info?.id){
            try {
              select = document.querySelector("#qty_"+element.id); 
              select.value = element.qty;
            } catch (error) {
              console.log(error); 
            }
          } 
         });
      }, 2000); 
    }
  }
  updateToCart(e:any,id:any,type:any, is_equp:any) {  
    this.cart.findItemAndUpdate(id, type, e.target.value, is_equp); 
  }
  addToCart(id: any, type: any, equp:any) {
    let d = document.getElementById('qty_'+id) as HTMLElement |any;
    this.cart.addItem(type, id, d?.value, equp);
  }
  removeFromCart(id: any, type: any, equp:any) {
    this.cart.removeItem(type, id, equp);
  }
  findInCart(id: any, type: any, equp:any): boolean {
    return this.cart.findItem(type, id, equp);
  }
  cartItem :any = [];
  daysLoop :any = [];
  form: FormGroup | any;
  submitted: boolean = false;

  isLoggedIn: boolean = false;
  myInfo: any = '';
  city: any;
  productId: any = '';
  info: any = []; 
  buyCount:any = 1;
  rentCount:any = 1;
  appointmentId:any = '';
  changeImageUrl:any = '';

  changeImage(img:any){
    this.changeImageUrl = img;
  }

  onFileChange(e: any): void {
    const reader = new FileReader();

    if (e.target.files && e.target.files.length) {
      const file = e.target.files[0];
      reader.readAsDataURL(file); 
        reader.onload = () => {  
          this.form.patchValue({
            image: reader.result,
          });   
        }; 
    }
  }
 
  getDealerProductList(id:any): void {
    this.spinner.show();
    this.ApiService.getDealerProductList(id).subscribe(
      (data) => {
        if (data.status) { 
            this.info = data.data;  
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

  submitForm(type:any){ 
    this.submitted = true;
    if (this.form.invalid) {
      this.toaster.open({
        text: 'Select all address fields',
        caption: 'Error',
        duration: 4000,
        type: 'danger',
      });
      return;
    }
    let price = 0;
    let qty = 0;
    if(type == 'rent'){
      qty = this.rentCount;
      price  =  ((this.info?.rent_per_day)*this.rentCount)+this.info?.delivery_charges_for_rent + this.info?.security_for_rent;
    }else{
      qty = this.buyCount;
      price = ((this.info?.mrp-((this.info?.discount / 100) *this.info?.mrp))*this.buyCount)+this.info?.delivery_charges;
    }
    price = Math.ceil(price);
    let data = {
      product_id: this.productId,
      type: type,
      price: price,
      qty:qty,
      image: this.form.value.image,
      address: this.form.value.address,
      city: this.form.value.city,
      pincode: this.form.value.pincode
    } 
      
    this.spinner.show();
    this.ApiService.bookDealerProduct(data).subscribe(
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
          this.rzp.createRzpayOrder(price,this.appointmentId,'dealer-product'); 
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
