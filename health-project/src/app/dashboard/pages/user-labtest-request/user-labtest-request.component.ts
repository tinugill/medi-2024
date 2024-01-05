import { Component, OnInit, Input } from '@angular/core';
import { ApiService } from '../../../services/Api/api.service';
import { Toaster } from 'ngx-toast-notifications';
import { Location } from '@angular/common';
import { NgxSpinnerService } from 'ngx-spinner';
@Component({
  selector: 'app-user-labtest-request',
  templateUrl: './user-labtest-request.component.html',
  styleUrls: ['./user-labtest-request.component.scss']
})
export class UserLabtestRequestComponent implements OnInit {

  constructor(private ApiService: ApiService,
    private toaster: Toaster, private spinner: NgxSpinnerService,
    private _location: Location) { }

    ngOnInit(): void {
      this.getLabtestOrder(); 
    }
    listDb:any = [];
    tList:any = [];
    doc_id:any = '';
    backClicked() {
      this._location.back();
    }
    onReviewData(e:any){
      let index = this.tList.findIndex((a:any) => a.id == e.service_id);
      this.tList[index].stars = e.star;
      this.tList[index].review = e.review;  
    }
    
    getLabtestOrder(): void {
      this.spinner.show();
      this.ApiService.getLabtestOrder().subscribe(
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

}
