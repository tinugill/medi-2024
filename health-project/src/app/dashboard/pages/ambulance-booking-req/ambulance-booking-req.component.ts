import { Component, OnInit, Input } from '@angular/core';
import { ApiService } from '../../../services/Api/api.service';
import { Toaster } from 'ngx-toast-notifications';
import { Location } from '@angular/common';
import { TokenStorageService } from '../../../services/Token/token-storage.service';
import { NgxSpinnerService } from 'ngx-spinner';
@Component({
  selector: 'app-ambulance-booking-req',
  templateUrl: './ambulance-booking-req.component.html',
  styleUrls: ['./ambulance-booking-req.component.scss']
})
export class AmbulanceBookingReqComponent implements OnInit {

  constructor(private ApiService: ApiService,private tokenStorage: TokenStorageService,
    private toaster: Toaster,
    private spinner: NgxSpinnerService,
    private _location: Location) {
      this.myInfo = this.tokenStorage.getUser();
     }

  ngOnInit(): void {
    this.getAmbulanceReqOrder();
    this.getDeliveryBoy();
  }
  myInfo: any = [];
  tList:any = [];
  doc_id:any = '';
  listDb:any = [];
  getDeliveryBoy(): void {
    this.ApiService.getExecutive('').subscribe(
      (data) => {
        if (data.status) { 
            this.listDb = data.data; 
        } else {
          this.toaster.open({
            text: data.message,
            caption: 'Error',
            duration: 4000,
            type: 'danger',
          });
        }
      },
      (err) => {
        this.toaster.open({
          text: err.error.message,
          caption: 'Message',
          duration: 4000,
          type: 'danger',
        });
      }
    );
  }
  backClicked() {
    this._location.back();
  }
  changeStatus(e:any, id:any){ 
    this.updateData(id,e.value,'')
  }
  updateEC(e:any, id:any, type:any){ 
    
    this.spinner.show();
    this.ApiService.updateLabEc(id, e.value, type).subscribe(
      (data) => {
        if (data.status) {
          this.toaster.open({
            text: data.message,
            caption: 'Success',
            duration: 4000,
            type: 'success',
          });
          this.getAmbulanceReqOrder();
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
  onFileChange(e: any, id:any): void {
    const reader = new FileReader();

    if (e.target.files && e.target.files.length) {
      const file = e.target.files[0];
      reader.readAsDataURL(file);

      reader.onload = () => { 
        this.updateData(id,'',reader.result);
      };
    }
  }
  updateData(id:any,status:any = '',r_rile:any = ''){
    this.ApiService.getAmbulanceReqOrderUpdate(id, {status :status, report_file:r_rile}).subscribe(
      (data) => {
        if (data.status) {
          this.toaster.open({
            text: data.message,
            caption: 'Success',
            duration: 4000,
            type: 'success',
          });
          this.getAmbulanceReqOrder();
        } else {
          this.toaster.open({
            text: data.message,
            caption: 'Error',
            duration: 4000,
            type: 'danger',
          });
        }
      },
      (err) => {
        this.toaster.open({
          text: err.error.message,
          caption: 'Message',
          duration: 4000,
          type: 'danger',
        });
      }
    );
  }
  getAmbulanceReqOrder(): void {
    
    this.spinner.show();
    this.ApiService.getAmbulanceReqOrder().subscribe(
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
  onReviewData(e:any){
    let index = this.tList.findIndex((a:any) => a.id == e.service_id);
    this.tList[index].stars = e.star;
    this.tList[index].review = e.review;  
  }

}
