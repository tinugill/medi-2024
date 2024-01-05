import { Component, Input, OnInit } from '@angular/core';
import { ApiService } from '../../services/Api/api.service';
import { Toaster } from 'ngx-toast-notifications';
import { NgxSpinnerService } from 'ngx-spinner';
@Component({
  selector: 'app-dr-profile-share',
  templateUrl: './dr-profile-share.component.html',
  styleUrls: ['./dr-profile-share.component.scss']
})
export class DrProfileShareComponent implements OnInit {

  constructor(private toaster: Toaster,
    private spinner: NgxSpinnerService,private ApiService: ApiService) { }
  @Input() id: any;
  dInfo:any = {};

  ngOnInit(): void {
    this.getDoctorInfo(this.id);
  }
  getDoctorInfo(id:any): void {
    this.spinner.show();
    this.ApiService.getDoctorInfo('', id).subscribe(
      (data) => {
        if (data.status) {
          this.dInfo = data.data;
            console.log(' this.dInfo ', this.dInfo );
            
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
