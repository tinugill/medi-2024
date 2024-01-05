import { Component, OnInit } from '@angular/core';
import { TokenStorageService } from '../../../services/Token/token-storage.service';
import { ApiService } from '../../../services/Api/api.service';
import { Toaster } from 'ngx-toast-notifications';
import { ActivatedRoute, Router, Params } from '@angular/router';
import { NgxSpinnerService } from 'ngx-spinner';
import { CartService } from '../../../services/Cart/cart.service';
@Component({
  selector: 'app-category',
  templateUrl: './category.component.html',
  styleUrls: ['./category.component.scss'],
})
export class CategoryComponent implements OnInit {
  constructor(
    private tokenStorage: TokenStorageService,
    private ApiService: ApiService,
    private toaster: Toaster,
    private _Activatedroute: ActivatedRoute,
    private spinner: NgxSpinnerService,
    private cart: CartService
  ) {
    this.isLoggedIn = !!this.tokenStorage.getToken();
    if (this.isLoggedIn) {
      this.myInfo = this.tokenStorage.getUser();
    } else {
    }

    this._Activatedroute.paramMap.subscribe((params) => {
      let catId = params.get('category');
      if (catId != '' && catId != undefined) {
        this.category_id = catId;
      }
      let search = this._Activatedroute.snapshot.queryParams['q'];
      if (search != '' && search != undefined) {
        this.searchString = search;
      }
      let listCart = this.cart.getList(); 
      this.only_id = listCart[0]?.store_id || '';
      console.log('this.only_id',this.only_id);
      this.getProductList();
      this.getSubCatList();
    });
  }

  ngOnInit(): void {
    this.city = this.tokenStorage.getSession('city');
   
  }
  only_id:any = '';
  searchString:any = '';
  isLoggedIn: boolean = false;
  myInfo: any = '';
  city: any;
  category_id: any = '';
  productList: any = [];
  subCatList: any = [];
  selectedSubCatList: any = [];
  addRemoveSubCat(event: any) {
    let val = event.target.value;
    if (event.currentTarget.checked) {
      this.selectedSubCatList.push(val);
    } else {
      let index = this.selectedSubCatList.indexOf(val);
      if (index > -1) {
        this.selectedSubCatList.splice(index, 1); // 2nd parameter means remove one item only
      }
    }
    this.getProductList();
  }
  getProductList(): void {
    this.spinner.show();
    this.ApiService.getPharmacyProductList(
      this.city,
      this.category_id,
      this.selectedSubCatList,
      this.searchString,
      '',
      this.only_id
    ).subscribe(
      (data) => {
        if (data.status) {
          this.productList = data.data;
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
  getSubCatList(): void {
    this.spinner.show();
    this.ApiService.getPharmacySubCategory(
      this.city,
      this.category_id
    ).subscribe(
      (data) => {
        if (data.status) {
          this.subCatList = data.data;
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
}
