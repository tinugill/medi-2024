import { Component, OnInit, QueryList, ViewChild } from '@angular/core';
import { ApiService } from '../../../services/Api/api.service';
import { Toaster } from 'ngx-toast-notifications';
import { TokenStorageService } from '../../../services/Token/token-storage.service';
import {
  AbstractControl,
  FormBuilder,
  FormGroup,
  Validators,
} from '@angular/forms';
import { NgxSpinnerService } from 'ngx-spinner';
@Component({
  selector: 'app-bloodbank-donation',
  templateUrl: './bloodbank-donation.component.html',
  styleUrls: ['./bloodbank-donation.component.scss'],
})
export class BloodbankDonationComponent implements OnInit {
  constructor(
    private tokenStorage: TokenStorageService,
    private ApiService: ApiService,
    private toaster: Toaster,
    private spinner: NgxSpinnerService,
    private formBuilder: FormBuilder
  ) {
    this.myInfo = this.tokenStorage.getUser(); 
  }

  ngOnInit(): void {
    this.getMyBBDonation();
  }
  onReviewData(e:any){
    let index = this.info.findIndex((a:any) => a.id == e.service_id);
    this.info[index].stars = e.star;
    this.info[index].review = e.review;  
  }
  info: any = [];
  myInfo: any = [];
  donationComplete(id: any) {
    
    this.spinner.show();
    this.ApiService.donationComplete(id).subscribe(
      (data) => {
        if (data.status) {
          this.toaster.open({
            text: data.message,
            caption: 'Success',
            duration: 4000,
            type: 'success',
          });
          this.spinner.hide();
          this.getMyBBDonation();
        } else {
          this.toaster.open({
            text: data.message,
            caption: 'Error',
            duration: 4000,
            type: 'danger',
          });
          this.spinner.hide();
        }
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
  getMyBBDonation(): void {
    this.spinner.show();
    this.ApiService.getMyBBDonation().subscribe(
      (data) => {
        if (data.status) {
          this.info = data.data;
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
