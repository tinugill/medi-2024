import { Component, OnInit } from '@angular/core';
import { TokenStorageService } from '../../../services/Token/token-storage.service';
import { ApiService } from '../../../services/Api/api.service';
import { Toaster } from 'ngx-toast-notifications';
import { ActivatedRoute, Router, Params } from '@angular/router';
import { NgxSpinnerService } from 'ngx-spinner';
@Component({
  selector: 'app-lab-list',
  templateUrl: './lab-list.component.html',
  styleUrls: ['./lab-list.component.scss'],
})
export class LabListComponent implements OnInit {
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
      let sb = this._Activatedroute.snapshot.queryParams['searchby'];
      if (sb != '' && sb != undefined) {
        this.searchBy = sb;
      }
      this.getLabList();
    });
  }

  ngOnInit(): void {
    this.city = this.tokenStorage.getSession('city');
  }
  searchString:any = '';
  searchStringSub:any = '';
  searchBy:any = '';
  hospital_id: any = '';
  price_order: any = '';
  isLoggedIn: boolean = false;
  myInfo: any = '';
  city: any;
  lab_count: any = 0;
  labList: any = [];

  getLabList(): void {
    this.spinner.show();
    this.ApiService.getLabList(this.city, this.searchString, this.searchBy, this.searchStringSub).subscribe(
      (data) => {
        if (data.status) {
          this.labList = data.data;
          this.lab_count = this.labList?.length;
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
