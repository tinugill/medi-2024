import { Component, OnInit, Input } from '@angular/core';
import { ApiService } from '../../../services/Api/api.service';
import { Toaster } from 'ngx-toast-notifications';
import { Location } from '@angular/common';
import { NgxSpinnerService } from 'ngx-spinner';
@Component({
  selector: 'app-user-treatment',
  templateUrl: './user-treatment.component.html',
  styleUrls: ['./user-treatment.component.scss']
})
export class UserTreatmentComponent implements OnInit {

  constructor(private ApiService: ApiService,
    private toaster: Toaster, private spinner: NgxSpinnerService,
    private _location: Location) { }

    ngOnInit(): void {
      this.getTreatmentOrder();
    }
    getAray(data:any){
      return JSON.parse(data);
    }
    tList:any = [];
    doc_id:any = '';
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
    onReviewData(e:any){
      let index = this.tList.findIndex((a:any) => a.order_id == e.service_id);
      this.tList[index].stars = e.star;
      this.tList[index].review = e.review;  
    }

}
