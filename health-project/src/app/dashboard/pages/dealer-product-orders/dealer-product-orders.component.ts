import { Component, OnInit, Input } from '@angular/core';
import { ApiService } from '../../../services/Api/api.service';
import { Toaster } from 'ngx-toast-notifications';
import { NgxSpinnerService } from 'ngx-spinner';
@Component({
  selector: 'app-dealer-product-orders',
  templateUrl: './dealer-product-orders.component.html',
  styleUrls: ['./dealer-product-orders.component.scss']
})
export class DealerProductOrdersComponent implements OnInit {
  orderList: any = [];
  @Input() pageFor:any = 'user'; 
  constructor(private ApiService: ApiService,
    private toaster: Toaster, private spinner: NgxSpinnerService) { }

  ngOnInit(): void {
    this.getDealerOrder();
  }
  onReviewData(e:any){
    let index = this.orderList.findIndex((a:any) => a.id == e.service_id);
    this.orderList[index].stars = e.star;
    this.orderList[index].review = e.review;  
  }
  getDealerOrder(): void {
    this.spinner.show();
    this.ApiService.getDealerOrder().subscribe(
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
        
        this.spinner.hide();
      }
    );
  }
  changeStatus(e:any, id:any){ 
    this.updateData(id,e.value)
  }
  updateData(id:any,status:any = ''){
    this.spinner.show();
    this.ApiService.getDealerProductOrderUpdate(id, {status :status}).subscribe(
      (data) => {
        if (data.status) {
          this.toaster.open({
            text: data.message,
            caption: 'Success',
            duration: 4000,
            type: 'success',
          });
          this.spinner.hide();
          this.getDealerOrder();
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
