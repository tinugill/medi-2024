import { Component, OnInit } from '@angular/core';
import { TokenStorageService } from '../../../services/Token/token-storage.service';
import { ApiService } from '../../../services/Api/api.service';
import { Toaster } from 'ngx-toast-notifications';
import { ActivatedRoute, Router, Params } from '@angular/router';
import { NgxSpinnerService } from 'ngx-spinner';
@Component({
  selector: 'app-blood-bank-list',
  templateUrl: './blood-bank-list.component.html',
  styleUrls: ['./blood-bank-list.component.scss'],
})
export class BloodBankListComponent implements OnInit {
  constructor(
    private tokenStorage: TokenStorageService,
    private ApiService: ApiService,
    private toaster: Toaster,
    private _Activatedroute: ActivatedRoute,
    private spinner: NgxSpinnerService
  ) {
    this.isLoggedIn = !!this.tokenStorage.getToken();
    if (this.isLoggedIn) {
      this.myInfo = this.tokenStorage.getUser();
    } else {
    }

    this._Activatedroute.paramMap.subscribe((params) => {
      let hp_id = this._Activatedroute.snapshot.queryParams['hid'];
      if (hp_id != '' && hp_id != undefined) {
        this.hospital_id = hp_id;
      }
      let search = this._Activatedroute.snapshot.queryParams['q'];
      if (search != '' && search != undefined) {
        this.searchString = search;
      }
      let search_subcat = this._Activatedroute.snapshot.queryParams['sub'];
      if (search_subcat != '' && search_subcat != undefined) {
        this.searchStringSub = search_subcat;
      }
      this.getBloodbankList();
    });
  }

  ngOnInit(): void {
    this.city = this.tokenStorage.getSession('city');
  }
  searchString: any = '';
  searchStringSub:any = '';
  hospital_id: any = '';
  price_order: any = '';
  isLoggedIn: boolean = false;
  myInfo: any = '';
  city: any;
  bb_count: any = 0;
  bbList: any = [];

  getBloodbankList(): void {
    this.spinner.show();
    this.ApiService.getBloodbankList(
      this.city,
      this.hospital_id,
      this.price_order,
      this.searchString,
      this.searchStringSub
    ).subscribe(
      (data) => {
        if (data.status) {
          this.bbList = data.data;
          this.bb_count = this.bbList?.length;
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
