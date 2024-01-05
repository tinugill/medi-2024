import { Component, OnInit } from '@angular/core';
import { TokenStorageService } from '../../../services/Token/token-storage.service';
import { ApiService } from '../../../services/Api/api.service';
import { Toaster } from 'ngx-toast-notifications';
import { ActivatedRoute } from '@angular/router';
import { NgxSpinnerService } from 'ngx-spinner';
@Component({
  selector: 'app-doctor-list',
  templateUrl: './doctor-list.component.html',
  styleUrls: ['./doctor-list.component.scss'],
})
export class DoctorListComponent implements OnInit {
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
      let sp_id = this._Activatedroute.snapshot.queryParams['sid'];
      if (sp_id != '' && sp_id != undefined) {
        this.speciality_id = sp_id;
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
      this.getDoctorList();
    });
    this.getSpecialities();
  }

  ngOnInit(): void {
    this.city = this.tokenStorage.getSession('city');
  }
  searchString:any = '';
  searchStringSub:any = '';
  searchBy:any = '';
  speciality_id: any = '';
  selected_gender: any = '';
  price_order: any = '';
  isLoggedIn: boolean = false;
  myInfo: any = '';
  city: any;
  doctor_count: any = 0;
  doctorList: any = [];
  spacialityList: any = [];

  getDoctorList(): void {
    this.spinner.show();
    this.ApiService.getDoctorList(
      this.city,
      this.speciality_id,
      this.selected_gender,
      this.price_order,
      this.searchString,
      this.searchBy,
      this.searchStringSub,
    ).subscribe(
      (data) => {
        if (data.status) {
          this.doctorList = data.data;
          this.doctor_count = this.doctorList?.length;
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

  getSpecialities(): void {
    this.ApiService.getSpecialities(this.city).subscribe(
      (data) => {
        if (data.status) {
          this.spacialityList = data.data;
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
