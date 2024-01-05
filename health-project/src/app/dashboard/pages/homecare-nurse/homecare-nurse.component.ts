import { Component, OnInit } from '@angular/core';
import { ActivatedRoute, Router, Params } from '@angular/router';
import { TokenStorageService } from '../../../services/Token/token-storage.service';
import { ApiService } from '../../../services/Api/api.service';
import { Toaster } from 'ngx-toast-notifications';
import { NgbModal } from '@ng-bootstrap/ng-bootstrap';
import { NgxSpinnerService } from 'ngx-spinner';
@Component({
  selector: 'app-homecare-nurse',
  templateUrl: './homecare-nurse.component.html',
  styleUrls: ['./homecare-nurse.component.scss']
})
export class HomecareNurseComponent implements OnInit {

  constructor(private tokenStorage: TokenStorageService,
    private ApiService: ApiService,
    private _Activatedroute: ActivatedRoute,
    private toaster: Toaster,
    private router: Router,
    private spinner: NgxSpinnerService) { }

  nurseList:any = [];
  isEdit:boolean = false;
  editId:any = '';
  ngOnInit(): void {
    this.getBueroNurseList();
  }
  isClosedFn(){
    this.isEdit = false;
    this.getBueroNurseList();
  }
  editInfo(id:any = ''){
    this.editId = id;
    this.isEdit  = !this.isEdit;
    this.getBueroNurseList();
  }
  getBueroNurseList(): void {
    
    this.spinner.show();
    this.ApiService.getBueroNurseList('').subscribe(
      (data) => {
        if (data.status) {
          this.nurseList = data.data;
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

}
