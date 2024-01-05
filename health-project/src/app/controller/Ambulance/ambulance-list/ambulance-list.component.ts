import { Component, OnInit } from '@angular/core';
import { TokenStorageService } from '../../../services/Token/token-storage.service';
import { ApiService } from '../../../services/Api/api.service';
import { Toaster } from 'ngx-toast-notifications';
import { ActivatedRoute, Router, Params } from '@angular/router';
import { NgxSpinnerService } from 'ngx-spinner';
@Component({
  selector: 'app-ambulance-list',
  templateUrl: './ambulance-list.component.html',
  styleUrls: ['./ambulance-list.component.scss']
})
export class AmbulanceListComponent implements OnInit {

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
      let searchby = this._Activatedroute.snapshot.queryParams['searchby'];
      this.type = this._Activatedroute.snapshot.queryParams['type'];
      if (search != '' && search != undefined) {
        this.searchString = search;
      }
      if (searchby != '' && searchby != undefined) {
        this.searchBy = searchby;
      }
      let search_subcat = this._Activatedroute.snapshot.queryParams['sub'];
      if (search_subcat != '' && search_subcat != undefined) {
        this.searchStringSub = search_subcat;
      }
      this.getAmbulanceAllList();
    });
  }

  ngOnInit(): void {
    this.city = this.tokenStorage.getSession('city');
  }
  searchString: any = ''; 
  searchStringSub:any = '';
  searchBy: any = ''; 
  isLoggedIn: boolean = false;
  myInfo: any = '';
  type: any = '';
  city: any;
  amb_count: any = 0;
  ambList: any = [];

  getAmbulanceAllList(): void {
    this.spinner.show();
    this.ApiService.getAmbulanceAllList(
      this.city, 
      this.searchString,
      this.type,
      this.searchBy,
      this.searchStringSub
    ).subscribe(
      (data) => {
        if (data.status) {
          this.ambList = data.data;
          this.amb_count = this.ambList?.length;
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
