import { Component, OnInit } from '@angular/core';
import { TokenStorageService } from '../../../services/Token/token-storage.service';
import { ApiService } from '../../../services/Api/api.service';
import { Toaster } from 'ngx-toast-notifications';
import { environment } from '../../../../environments/environment';
import { NgxSpinnerService } from 'ngx-spinner';
const SITE_URL = environment.site_url;
import { Pipe, PipeTransform } from '@angular/core';
@Pipe({ name: 'concatBase' })
export class ConcatBaseString implements PipeTransform {
  transform(value: string, separator: string): string {
    return SITE_URL + separator + value;
  }
}

@Component({
  selector: 'app-hospital-index',
  templateUrl: './hospital-index.component.html',
  styleUrls: ['./hospital-index.component.scss'],
})
export class HospitalIndexComponent implements OnInit {
  constructor(
    private tokenStorage: TokenStorageService,
    private ApiService: ApiService,
    private toaster: Toaster,
    private spinner: NgxSpinnerService
  ) {
    this.isLoggedIn = !!this.tokenStorage.getToken();
    if (this.isLoggedIn) {
      this.myInfo = this.tokenStorage.getUser();
    } else {
    }
  }

  ngOnInit(): void {
    this.city = this.tokenStorage.getSession('city');
    this.getSpecialities();
    this.getBlogList();
  }
  isLoggedIn: boolean = false;
  myInfo: any = '';
  city: any;
  speciality_count: any = 0;
  blogList: any = [];
  spacialityList: any = [];
  topDoc: any = [];
  getSpecialities(): void {
    this.spinner.show();
    this.ApiService.getSpecialities(this.city).subscribe(
      (data) => {
        if (data.status) {
          this.spacialityList = data.data;
          if (this.spacialityList?.length > 0) {
            let sid = this.spacialityList[0].id;
            this.getSpecialitiesTopDoc(sid);
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
      (err) => {}
    );
  }
  getSpecialitiesTopDoc(id: any): void {
    this.spinner.show();
    this.ApiService.getSpecialitiesTopDoc(this.city, id).subscribe(
      (data) => {
        if (data.status) {
          this.topDoc = data.data;
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
  getBlogList(id: any = ''): void {
    this.spinner.show();
    this.ApiService.getBlogList(id, 'Hospital').subscribe(
      (data) => {
        if (data.status) {
          this.blogList = data.data;
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
