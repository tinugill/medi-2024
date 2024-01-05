import { Component, OnInit } from '@angular/core';
import { TokenStorageService } from '../../../services/Token/token-storage.service';
import { ApiService } from '../../../services/Api/api.service';
import { Toaster } from 'ngx-toast-notifications';
@Component({
  selector: 'app-lab-index',
  templateUrl: './lab-index.component.html',
  styleUrls: ['./lab-index.component.scss'],
})
export class LabIndexComponent implements OnInit {
  constructor(
    private tokenStorage: TokenStorageService,
    private ApiService: ApiService,
    private toaster: Toaster
  ) {
    this.isLoggedIn = !!this.tokenStorage.getToken();
    if (this.isLoggedIn) {
      this.myInfo = this.tokenStorage.getUser();
    } else {
    }
  }

  ngOnInit(): void {
    this.city = this.tokenStorage.getSession('city');
    this.getLabTestCategory();
    this.getLabTestTop();
  }
  isLoggedIn: boolean = false;
  myInfo: any = '';
  city: any;
  cList: any = [];
  tList: any = [];

  getLabTestCategory(): void {
    this.ApiService.getLabTestCategory(this.city).subscribe(
      (data) => {
        if (data.status) {
          this.cList = data.data;
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

  getLabTestTop(): void {
    this.ApiService.getLabTestTop(this.city).subscribe(
      (data) => {
        if (data.status) {
          this.tList = data.data;
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
