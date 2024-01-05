import { Component, OnInit } from '@angular/core';
import { TokenStorageService } from '../../../services/Token/token-storage.service';
import { ApiService } from '../../../services/Api/api.service';
import { Toaster } from 'ngx-toast-notifications';
import { environment } from '../../../../environments/environment';
import { NgxSpinnerService } from 'ngx-spinner';
@Component({
  selector: 'app-pharmacy',
  templateUrl: './pharmacy.component.html',
  styleUrls: ['./pharmacy.component.scss'],
})
export class PharmacyComponent implements OnInit {
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
    this.getCategory();
    this.getPharmacyCategoryWithProduct();
  }
  isLoggedIn: boolean = false;
  myInfo: any = '';
  city: any;
  catList: any = [];
  cpList: any = [];

  slideConfig = {
    slidesToShow: 5,
    slidesToScroll: 1,
    dots: false,
    autoplay: false,
    infinite: false,
    arrows: true,
    responsive: [
      {
        breakpoint: 1024,
        settings: {
          slidesToShow: 3,
          slidesToScroll: 1,
          infinite: true,
          dots: false,
        },
      },
      {
        breakpoint: 600,
        settings: {
          slidesToShow: 2,
          slidesToScroll: 1,
        },
      },
      {
        breakpoint: 480,
        settings: {
          slidesToShow: 2,
          slidesToScroll: 1,
          dots: false,
          autoplay: false,
          arrows: false,
        },
      },
    ],
  };
  getCategory(): void {
    this.spinner.show();
    this.ApiService.getPharmacyCategory(this.city).subscribe(
      (data) => {
        if (data.status) {
          this.catList = data.data;
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
  getPharmacyCategoryWithProduct(): void {
    this.spinner.show();
    this.ApiService.getPharmacyCategoryWithProduct(this.city).subscribe(
      (data) => {
        if (data.status) {
          this.cpList = data.data;
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
