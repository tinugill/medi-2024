import { Component, OnInit } from '@angular/core';
import { TokenStorageService } from '../../services/Token/token-storage.service';
import { ApiService } from '../../services/Api/api.service';
import { Toaster } from 'ngx-toast-notifications';
@Component({
  selector: 'app-appointment',
  templateUrl: './appointment.component.html',
  styleUrls: ['./appointment.component.scss'],
})
export class AppointmentComponent implements OnInit {
  constructor(
    private tokenStorage: TokenStorageService,
    private ApiService: ApiService,
    private toaster: Toaster
  ) {}
  apnList: any = [];
  ngOnInit(): void {
    this.getAppointment();
  }
  onReviewData(e:any){
    let index = this.apnList.findIndex((a:any) => a.id == e.service_id);
    this.apnList[index].stars = e.star;
    this.apnList[index].review = e.review;  
  }
  getAppointment(): void {
    this.ApiService.getAppointment().subscribe(
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
}
