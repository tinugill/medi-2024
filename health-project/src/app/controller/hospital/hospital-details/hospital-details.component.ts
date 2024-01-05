import { Component, OnInit } from '@angular/core';
import { ActivatedRoute, Router, Params } from '@angular/router';
import { TokenStorageService } from '../../../services/Token/token-storage.service';
import { PayServiceService } from '../../../services/Payment/pay-service.service';
import { ApiService } from '../../../services/Api/api.service';
import { Toaster } from 'ngx-toast-notifications';
import { NgbModal } from '@ng-bootstrap/ng-bootstrap';
import { NgxSpinnerService } from 'ngx-spinner';

import { CartService } from '../../../services/Cart/cart.service';
@Component({
  selector: 'app-hospital-details',
  templateUrl: './hospital-details.component.html',
  styleUrls: ['./hospital-details.component.scss']
})
export class HospitalDetailsComponent implements OnInit {

  constructor(
    private tokenStorage: TokenStorageService,
    private modalService: NgbModal,
    private ApiService: ApiService,
    private _Activatedroute: ActivatedRoute,
    private rzp: PayServiceService, 
    private cart: CartService,
    private toaster: Toaster,
    private spinner: NgxSpinnerService
  ) {
    this.isLoggedIn = !!this.tokenStorage.getToken();
  }
  stars: any = 0;
  ngOnInit(): void {
    this._Activatedroute.paramMap.subscribe((params) => {
      this.slug = params.get('slug');
      if (this.slug != '') {
        this.getHospitalInfo(this.slug);
      }
    });

 
  } 
  addToCart(id: any, type: any) {
    this.cart.addItem(type, id, 1);
  }
  removeFromCart(id: any, type: any) {
    this.cart.removeItem(type, id);
  }
  findInCart(id: any, type: any): boolean {
    return this.cart.findItem(type, id);
  }
  isLoggedIn: boolean = false;
  slug: any = '';
  dInfo: any = '';
  docList: any = [];
  testInfo: any = [];  
  treatmentList: any = [];  
  tab: any = 'doctors';
  
  getHospitalInfo(slug: any): void {
    this.spinner.show();
    this.ApiService.getHospitalInfo(slug).subscribe(
      (data) => {
        if (data.status) {
          this.dInfo = data.data;  
          if(this.dInfo.reviews?.user_id){
            this.stars = parseFloat(this.dInfo.reviews.avg_stars); 
          }
          this.getHospitalDoc(this.dInfo?.id);
          this.getHospitalTreatment(this.dInfo?.id);
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
      (err) => {
        this.toaster.open({
          text: err.error.message,
          caption: 'Message',
          duration: 4000,
          type: 'danger',
        });
        this.spinner.hide();
      }
    );
  }
  getHospitalDoc(hospital_id: any): void {
    this.spinner.show();
    this.ApiService.getHospitalDoc(hospital_id).subscribe(
      (data) => {
        if (data.status) {
          this.docList = data.data; 
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
      (err) => {
        this.toaster.open({
          text: err.error.message,
          caption: 'Message',
          duration: 4000,
          type: 'danger',
        });
        this.spinner.hide();
      }
    );
  }
  getHospitalTreatment(hospital_id: any): void {
    this.spinner.show();
    this.ApiService.getHospitalTreatment(hospital_id).subscribe(
      (data) => {
        if (data.status) {
          this.treatmentList = data.data; 
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
      (err) => {
        this.toaster.open({
          text: err.error.message,
          caption: 'Message',
          duration: 4000,
          type: 'danger',
        });
        this.spinner.hide();
      }
    );
  }
 

}
