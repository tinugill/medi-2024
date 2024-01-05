import { Component, OnInit } from '@angular/core';
import { ActivatedRoute, Router, Params } from '@angular/router';
import { TokenStorageService } from '../../services/Token/token-storage.service';
import { ApiService } from '../../services/Api/api.service';
import { Toaster } from 'ngx-toast-notifications';
import { NgbModal } from '@ng-bootstrap/ng-bootstrap';
import { NgxSpinnerService } from 'ngx-spinner';
@Component({
  selector: 'app-dashboard-hospital',
  templateUrl: './dashboard-hospital.component.html',
  styleUrls: ['./dashboard-hospital.component.scss'],
})
export class DashboardHospitalComponent implements OnInit {
  constructor(
    private tokenStorage: TokenStorageService,
    private ApiService: ApiService,
    private _Activatedroute: ActivatedRoute,
    private toaster: Toaster,
    private router: Router,
    private modalService: NgbModal,
    private spinner: NgxSpinnerService
  ) {
    this.isLoggedIn = !!this.tokenStorage.getToken();
    if (this.isLoggedIn) {
      this.myInfo = this.tokenStorage.getUser();

      if (this.myInfo.type == 'User') {
        this.router.navigate(['/Patient-Record/record']);
        return;
      } else if (this.myInfo.type == 'Doctor') {
        this.router.navigate(['/dashboard/doctor']);
        return;
      } else if (this.myInfo.type == 'Hospitalstaff') {
        this.router.navigate(['/dashboard/staff']);
        return;
      } else if (this.myInfo.type == 'Pharmacy') {
        this.router.navigate(['/dashboard/pharmacy']);
        return;
      } else if (this.myInfo.type == 'Lab') {
        this.router.navigate(['/dashboard/lab']);
        return;
      } else if (this.myInfo.type == 'Bloodbank') {
        this.router.navigate(['/dashboard/bloodbank']);
        return;
      }else if (this.myInfo.type == 'Nursing') {
        this.router.navigate(['/dashboard/Nursing']);
        return;
      }else if (this.myInfo.type == 'Dealer') {
        this.router.navigate(['/dashboard/dealer']);
        return;
      }else if (this.myInfo.type == 'Ambulance') {
        this.router.navigate(['/dashboard/ambulance']);
        return;
      }
      this.getHospitalInfo();
    } else {
      this.router.navigate(['/home']);
      return;
    }
  }
  serviceId:any = 2;
  hInfo: any = [];
  getHospitalInfo(): void {
    this.spinner.show();
    this.ApiService.getHospInfo().subscribe(
      (data) => {
        if (data.status) {
          this.hInfo = data.data.data;
          if(this.hInfo?.type == 'Hospital'){
            this.serviceId = 2;
          }else{
            this.serviceId = 12;
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
  ngOnInit(): void {}
  isLoggedIn: boolean = false;
  myInfo: any = '';
  page: any = 'doctor-list';

  changePage(page: any) {
    this.page = page;
  }
  logout(): void {
    this.tokenStorage.signOut();
    this.router.navigate(['/home']);
    window.location.reload();
  }
  openVerticallyCentered(modalName: any) {
    this.modalService.open(modalName, {
      centered: true,
      size: 'sm',
      backdropClass: 'light-blue-backdrop',
    });
  }
}
