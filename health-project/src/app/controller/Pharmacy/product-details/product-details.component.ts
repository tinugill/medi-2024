import { Component, OnInit, AfterViewInit } from '@angular/core';
import { TokenStorageService } from '../../../services/Token/token-storage.service';
import { ApiService } from '../../../services/Api/api.service';
import { Toaster } from 'ngx-toast-notifications';
import { CartService } from '../../../services/Cart/cart.service';
import { ActivatedRoute} from '@angular/router';
import { NgxSpinnerService } from 'ngx-spinner';
@Component({
  selector: 'app-product-details',
  templateUrl: './product-details.component.html',
  styleUrls: ['./product-details.component.scss'],
})
export class ProductDetailsComponent implements OnInit,AfterViewInit {
  constructor(
    private tokenStorage: TokenStorageService,
    private ApiService: ApiService,
    private toaster: Toaster,
    private cart: CartService,
    private _Activatedroute: ActivatedRoute,
    private spinner: NgxSpinnerService
  ) {
    this.isLoggedIn = !!this.tokenStorage.getToken();
    if (this.isLoggedIn) {
      this.myInfo = this.tokenStorage.getUser();
    } else {
    }

    this._Activatedroute.paramMap.subscribe((params) => {
      let s = params.get('slug');
      if (s != '' && s != undefined) {
        this.slug = s;
        this.getProductInfo();
      }
    });
    this.qtyLoop = Array(100).fill(1).map((x,i)=>i+1);
  }
  qtyLoop:any = [];  
  changeImageUrl:any = '';

  changeImage(img:any){
    this.changeImageUrl = img;
  }

  ngOnInit(): void {
    this.city = this.tokenStorage.getSession('city');
  }
  ngAfterViewInit(): void { 
    this.cartItem = this.cart.getList();
    if(this.cartItem?.length > 0){
      setTimeout(() => {
        let select:any ;
        this.cartItem.forEach((element:any) => { 
          if(element.type == 'product'){
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
  isLoggedIn: boolean = false;
  myInfo: any = '';
  city: any;
  slug: any = '';
  info: any = [];
  cartItem: any = [];
  similar: any = [];
  addToCart(id: any, type: any, store_id:any) {
    let d = document.getElementById('qty_'+id) as HTMLElement |any;
    this.cart.addItem(type, id, d?.value, '', store_id);
  }
  updateToCart(e:any,id:any,type:any) {  
    this.cart.findItemAndUpdate(id, type, e.target.value); 
  }
  removeFromCart(id: any, type: any) {
    this.cart.removeItem(type, id);
  }
  findInCart(id: any, type: any): boolean {
    return this.cart.findItem(type, id);
  }
  getProductInfo(): void {
    this.spinner.show();
    this.ApiService.getPharmacyProductInfo(this.slug).subscribe(
      (data) => {
        if (data.status) {
          this.info = data.data; 
          
          this.getSimiliar(this.info.salt_name);
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
        this.spinner.hide();}
    );
  }
  getSimiliar(salt_name:any): void {
    this.spinner.show();
    this.ApiService.getPharmacyProductList('','','','', 10,'',salt_name).subscribe(
      (data) => {
        if (data.status) {
          this.similar = data.data; 
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
        this.spinner.hide();}
    );
  }
}
