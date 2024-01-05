import { Component, OnInit, Input } from '@angular/core';
import { ApiService } from '../../../services/Api/api.service';
import { Toaster } from 'ngx-toast-notifications';
import { Location } from '@angular/common';
import { NgxSpinnerService } from 'ngx-spinner';
@Component({
  selector: 'app-user-orders',
  templateUrl: './user-orders.component.html',
  styleUrls: ['./user-orders.component.scss']
})
export class UserOrdersComponent implements OnInit {

  constructor(private ApiService: ApiService,
    private toaster: Toaster, private spinner: NgxSpinnerService,
    private _location: Location) { }

    ngOnInit(): void {
      this.getPharmacyOrder();
    }
    orderList:any = [];
    doc_id:any = '';
    backClicked() {
      this._location.back();
    }
    onReviewData(e:any){
      let index = this.orderList.findIndex((a:any) => a.info.id == e.service_id);
      this.orderList[index].info.stars = e.star;
      this.orderList[index].info.review = e.review;  
    }
    getPharmacyOrder(): void {
      this.spinner.show();
      this.ApiService.getPharmacyOrder().subscribe(
        (data) => {
          if (data.status) {
            this.orderList = data.data;
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
