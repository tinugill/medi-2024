import { Component, OnInit } from '@angular/core';
import { ActivatedRoute, Router, Params } from '@angular/router';
import { TokenStorageService } from '../../../services/Token/token-storage.service';
import { ApiService } from '../../../services/Api/api.service';
import { Toaster } from 'ngx-toast-notifications';
import { NgxSpinnerService } from 'ngx-spinner';
import { NgbModal } from '@ng-bootstrap/ng-bootstrap';
import {
  AbstractControl,
  FormBuilder,
  FormGroup,
  Validators,
} from '@angular/forms';
@Component({
  selector: 'app-blood-bank-details',
  templateUrl: './blood-bank-details.component.html',
  styleUrls: ['./blood-bank-details.component.scss'],
})
export class BloodBankDetailsComponent implements OnInit {
  constructor(
    private tokenStorage: TokenStorageService,
    private ApiService: ApiService,
    private _Activatedroute: ActivatedRoute,
    private formBuilder: FormBuilder,
    private toaster: Toaster,
    private spinner: NgxSpinnerService,
    private modalService: NgbModal
  ) {}

  ngOnInit(): void {
    this._Activatedroute.paramMap.subscribe((params) => {
      this.slug = params.get('slug');
      if (this.slug != '') {
        this.getBloodbankInfo(this.slug);
      }
    });
    this.lForm = this.formBuilder.group({
      name: ['', Validators.required],
      blood_group: ['', Validators.required],
      email: ['', Validators.required],
      mobile: ['', Validators.required],
      date: ['', Validators.required],
      available_in_emergency: ['', Validators.required],
    });
    this.getBBComponent();
  }
  lForm: FormGroup | any;
  b2: boolean = false;
  slug: any = '';
  dInfo: any = '';
  cList:any = [];
  stars: any = 0;
  get f2(): { [key: string]: AbstractControl } {
    return this.lForm.controls;
  }

  getBBComponent(): void {
    this.spinner.show();
    this.ApiService.getBBComponent('').subscribe(
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
  getBloodbankInfo(slug: any): void {
    this.spinner.show();
    this.ApiService.getBloodbankInfo(slug).subscribe(
      (data) => {
        if (data.status) {
          this.dInfo = data.data;
          if(this.dInfo.reviews?.user_id){
            this.stars = parseFloat(this.dInfo.reviews.avg_stars); 
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
  donateBlood(modalName: any) {
    this.modalService.open(modalName, {
      centered: true,
      size: 'sm',
      backdropClass: 'light-blue-backdrop',
    });
  }
  onSubmitBr() {
    this.b2 = true;
    if (this.lForm.invalid) {
      this.toaster.open({
        text: 'Fill all required fields',
        caption: 'Message',
        duration: 4000,
        type: 'danger',
      });
      return;
    }
    this.spinner.show();
    this.ApiService.bloodDonationForm(
      this.lForm.value,
      this.dInfo?.id
    ).subscribe(
      (data) => {
        if (data.status) {
          this.toaster.open({
            text: data.message,
            caption: 'Success',
            duration: 4000,
            type: 'success',
          });
          this.b2 = false;
          this.modalService.dismissAll();
          this.spinner.hide();
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
}
