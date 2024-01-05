import { Component, OnInit } from '@angular/core';
import { ActivatedRoute, Router, Params } from '@angular/router';
import { TokenStorageService } from '../../../services/Token/token-storage.service';
import { CartService } from '../../../services/Cart/cart.service';
import { ApiService } from '../../../services/Api/api.service';
import { Toaster } from 'ngx-toast-notifications';
import { NgxSpinnerService } from 'ngx-spinner';

import { Pipe, PipeTransform } from '@angular/core';
@Pipe({name: 'replaceLineBreaks'})
export class ReplaceLineBreaks implements PipeTransform {
transform(value: string): string {
      return value.replace(/\n/g, '<br/>');
   }
}

@Component({
  selector: 'app-doctor-profile',
  templateUrl: './doctor-profile.component.html',
  styleUrls: ['./doctor-profile.component.scss'],
})
export class DoctorProfileComponent implements OnInit {
  constructor(
    private tokenStorage: TokenStorageService,
    private cart: CartService,
    private ApiService: ApiService,
    private _Activatedroute: ActivatedRoute,
    private router: Router,
    private toaster: Toaster,
    private spinner: NgxSpinnerService
  ) {
    this.isLoggedIn = !!this.tokenStorage.getToken();
  }

  ngOnInit(): void {
    this._Activatedroute.paramMap.subscribe((params) => {
      this.slug = params.get('slug');
      if (this.slug != '') {
        this.getDoctorInfo(this.slug);
      }
    });
    this.cartItem = this.cart.getList();
  }
  isLoggedIn: boolean = false;
  slug: any = '';
  dInfo: any = '';
  cartItem: any = [];
  stars: any = 0;

  addToCart(id: any, type: any) {
    this.cart.addItem(type, id, 1);
  }
  removeFromCart(id: any, type: any) {
    this.cart.removeItem(type, id);
  }
  findInCart(id: any, type: any): boolean {
    return this.cart.findItem(type, id);
  }
  getDoctorInfo(slug: any): void {
    this.spinner.show();
    this.ApiService.getDoctorInfo(slug).subscribe(
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
}
