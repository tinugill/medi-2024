import { Component, OnInit } from '@angular/core';
import { TokenStorageService } from '../../../services/Token/token-storage.service';
import { ApiService } from '../../../services/Api/api.service';
import { Toaster } from 'ngx-toast-notifications';
import { ActivatedRoute } from '@angular/router';
import { NgxSpinnerService } from 'ngx-spinner';
@Component({
  selector: 'app-nursing-list',
  templateUrl: './nursing-list.component.html',
  styleUrls: ['./nursing-list.component.scss']
})
export class NursingListComponent implements OnInit {

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
      if (search != '' && search != undefined) {
        this.searchString = search;
      }
      let search_subcat = this._Activatedroute.snapshot.queryParams['sub'];
      if (search_subcat != '' && search_subcat != undefined) {
        this.searchStringSub = search_subcat;
      }
      this.getNursingList();
    });
   
    
  }

  ngOnInit(): void {
    this.city = this.tokenStorage.getSession('city');
  }
  searchString:any = '';
  searchStringSub:any = '';
  isLoggedIn: boolean = false;
  myInfo: any = '';
  city: any;
  price_order : any = '';
  nursing_count: any = 0;
  nursingList: any = [];

  getNursingList(): void {
    this.spinner.show();
    this.ApiService.getNursingList(
      this.city, 
      '',
      this.price_order,
      this.searchString,
      this.searchStringSub
    ).subscribe(
      (data) => {
        if (data.status) {
          this.nursingList = data.data;
          this.nursing_count = this.nursingList?.length;
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
