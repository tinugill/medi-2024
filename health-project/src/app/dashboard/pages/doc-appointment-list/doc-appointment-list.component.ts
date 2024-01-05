import { Component, OnInit, Input } from '@angular/core';
import { ApiService } from '../../../services/Api/api.service';
import { Toaster } from 'ngx-toast-notifications';
import { Location } from '@angular/common';
import { NgxSpinnerService } from 'ngx-spinner';
@Component({
  selector: 'app-doc-appointment-list',
  templateUrl: './doc-appointment-list.component.html',
  styleUrls: ['./doc-appointment-list.component.scss'],
})
export class DocAppointmentListComponent implements OnInit {
  constructor(
    private ApiService: ApiService,
    private toaster: Toaster,
    private spinner: NgxSpinnerService,
    private _location: Location
  ) {}
  apnList: any = [];
  @Input() doc_id: any = '';
  @Input() apnType: any = 'Offline';
  ngOnInit(): void {
    this.getDocAppointment();
  }
  backClicked() {
    this._location.back();
  }
  markComplete(id:any){
    const date = '';
    // const dateInput = document.getElementById('dtt_'+id) as HTMLInputElement;
    // const date = dateInput.value;
    // if(date == ''){
    //   this.toaster.open({
    //     text: 'Select date first',
    //     caption: 'Error',
    //     duration: 4000,
    //     type: 'danger',
    //   });
    //   return;
    // }
    this.spinner.show();
    this.ApiService.takeActionOnCompAppointment(id, date).subscribe(
      (data) => {
        if (data.status) {
          this.toaster.open({
            text: data.message,
            caption: 'Success',
            duration: 4000,
            type: 'success',
          });
          this.spinner.hide();
          this.getDocAppointment();
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
  getDocAppointment(): void {
    
    this.spinner.show();
    this.ApiService.getDocAppointment(this.doc_id,this.apnType).subscribe(
      (data) => {
        if (data.status) {
          this.apnList = data.data;
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
  takeAction(apid: any, type: any) {
    this.spinner.show();
    this.ApiService.takeActionOnAppointment(apid, type).subscribe(
      (data) => {
        if (data.status) {
          this.toaster.open({
            text: data.message,
            caption: 'Success',
            duration: 4000,
            type: 'success',
          });
          this.spinner.hide();
          this.getDocAppointment();
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
