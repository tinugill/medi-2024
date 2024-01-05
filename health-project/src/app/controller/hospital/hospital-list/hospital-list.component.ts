import { Component, OnInit } from '@angular/core';
import { TokenStorageService } from '../../../services/Token/token-storage.service';
import { ApiService } from '../../../services/Api/api.service';
import { Toaster } from 'ngx-toast-notifications';
import { ActivatedRoute, Router, Params } from '@angular/router';
import { NgxSpinnerService } from 'ngx-spinner';
@Component({
  selector: 'app-hospital-list',
  templateUrl: './hospital-list.component.html',
  styleUrls: ['./hospital-list.component.scss']
})
export class HospitalListComponent implements OnInit {

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
      let search = this._Activatedroute.snapshot.queryParams['q'];
      let search_subcat = this._Activatedroute.snapshot.queryParams['sub'];
      if (search != '' && search != undefined) {
        this.searchString = search;
      }
      if (search_subcat != '' && search_subcat != undefined) {
        this.searchStringSub = search_subcat;
      }
      this.getHospitalList();
    });
  }

  ngOnInit(): void {
    this.city = this.tokenStorage.getSession('city');
  }
  searchString: any = '';
  searchStringSub: any = '';
  price_order: any = '';
  isLoggedIn: boolean = false;
  myInfo: any = '';
  city: any;
  hospital_count: any = 0;
  hospitalList: any = [];

  getHospitalList(): void {
    this.spinner.show();
    this.ApiService.getHospitalList(this.city, this.searchString, this.searchStringSub).subscribe(
      (data) => {
        if (data.status) {
          this.hospitalList = data.data;
          this.hospital_count = this.hospitalList?.length;
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
