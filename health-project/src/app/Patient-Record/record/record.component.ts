import { Component, OnInit } from '@angular/core';
import { ActivatedRoute, Router, Params } from '@angular/router';
import { TokenStorageService } from '../../services/Token/token-storage.service';
import { ApiService } from '../../services/Api/api.service';
import { Toaster } from 'ngx-toast-notifications';
import { NgbModal } from '@ng-bootstrap/ng-bootstrap';
@Component({
  selector: 'app-record',
  templateUrl: './record.component.html',
  styleUrls: ['./record.component.scss'],
})
export class RecordComponent implements OnInit {
  constructor(
    private tokenStorage: TokenStorageService,
    private ApiService: ApiService,
    private _Activatedroute: ActivatedRoute,
    private toaster: Toaster,
    private router: Router,
    private modalService: NgbModal
  ) {
    this.isLoggedIn = !!this.tokenStorage.getToken();
    if (this.isLoggedIn) {
      this.myInfo = this.tokenStorage.getUser();
      if (this.myInfo.type == 'Doctor') {
        this.router.navigate(['/dashboard/doctor']);
        return;
      } else if (this.myInfo.type == 'Hospital') {
        this.router.navigate(['/dashboard/hospital']);
        return;
      } else if (this.myInfo.type == 'Hospitalstaff') {
        this.router.navigate(['/dashboard/staff']);
        return;
      } else if (this.myInfo.type == 'Pharmacy') {
        this.router.navigate(['/dashboard/pharmacy']);
        return;
      } else if (this.myInfo.type == 'Bloodbank') {
        this.router.navigate(['/dashboard/bloodbank']);
        return;
      } else if (this.myInfo.type == 'Lab') {
        this.router.navigate(['/dashboard/lab']);
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
    } else {
      this.router.navigate(['/home']);
      return;
    }
  }

  ngOnInit(): void {}
  isLoggedIn: boolean = false;
  myInfo: any = '';
  apnList: any = [];
  page: any = 'appointment-list';

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
