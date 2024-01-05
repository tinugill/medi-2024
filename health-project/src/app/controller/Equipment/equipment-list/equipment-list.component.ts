import { Component, OnInit } from '@angular/core';
import { ApiService } from '../../../services/Api/api.service';
import { TokenStorageService } from '../../../services/Token/token-storage.service';
import { Toaster } from 'ngx-toast-notifications';
import { ActivatedRoute} from '@angular/router';
import { NgxSpinnerService } from 'ngx-spinner';
@Component({
  selector: 'app-equipment-list',
  templateUrl: './equipment-list.component.html',
  styleUrls: ['./equipment-list.component.scss']
})
export class EquipmentListComponent implements OnInit {
  pList:any = [];
  isLoggedIn: boolean = false;
  myInfo: any = '';
  searchString:any = '';
  constructor( private ApiService: ApiService, 
    private toaster: Toaster,
    private tokenStorage: TokenStorageService,
    private _Activatedroute: ActivatedRoute,
    private spinner: NgxSpinnerService
  ){ 
      this.isLoggedIn = !!this.tokenStorage.getToken();
      if (this.isLoggedIn) {
        this.myInfo = this.tokenStorage.getUser();
      }
  }

  ngOnInit(): void {
    this._Activatedroute.paramMap.subscribe((params) => {
      let search = this._Activatedroute.snapshot.queryParams['q'];
      if (search != '' && search != undefined) {
        this.searchString = search;
      }
    });
    this.getDealerProductList();
  }
  getDealerProductList(): void {
    this.ApiService.getDealerProductList('',this.searchString).subscribe(
      (data) => {
        if (data.status) { 
            this.pList = data.data;  
        } else {
          this.toaster.open({
            text: data.message,
            caption: 'Error',
            duration: 4000,
            type: 'danger',
          });
        }
      },
      (err) => {}
    );
  }

}
