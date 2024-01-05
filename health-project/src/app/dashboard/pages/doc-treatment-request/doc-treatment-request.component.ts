import { Component, OnInit, Input } from '@angular/core';
import { ApiService } from '../../../services/Api/api.service';
import { Toaster } from 'ngx-toast-notifications';
import { Location } from '@angular/common';
import { NgxSpinnerService } from 'ngx-spinner';
@Component({
  selector: 'app-doc-treatment-request',
  templateUrl: './doc-treatment-request.component.html',
  styleUrls: ['./doc-treatment-request.component.scss']
})
export class DocTreatmentRequestComponent implements OnInit {

  constructor(private ApiService: ApiService,
    private toaster: Toaster, private spinner: NgxSpinnerService,
    private _location: Location) { }

    ngOnInit(): void {
      this.getTreatmentOrder();
    }
    tList:any = [];
    doc_id:any = '';
    backClicked() {
      this._location.back();
    }
    getAray(data:any){
      return JSON.parse(data);
    }
    getTreatmentOrder(): void {
      this.spinner.show();
      this.ApiService.getTreatmentOrder().subscribe(
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
            this.getTreatmentOrder();
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
    changeStatus(e:any, id:any){ 
      this.updateData(id,e.value)
    }
    updateData(id:any,status:any = ''){
      this.spinner.show();
      this.ApiService.getProductOrderUpdate(id, {status :status, type:'item'}).subscribe(
        (data) => {
          if (data.status) {
            this.toaster.open({
              text: data.message,
              caption: 'Success',
              duration: 4000,
              type: 'success',
            });
            this.spinner.hide();
            this.getTreatmentOrder();
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
