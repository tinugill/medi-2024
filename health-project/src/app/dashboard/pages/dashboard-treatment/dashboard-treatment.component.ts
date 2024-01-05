import { Component, OnInit, Input } from '@angular/core';
import { ApiService } from '../../../services/Api/api.service';
import { TokenStorageService } from '../../../services/Token/token-storage.service';
import { PayServiceService } from '../../../services/Payment/pay-service.service';
import { Toaster } from 'ngx-toast-notifications';
import {
  AbstractControl,
  FormBuilder,
  FormGroup,
  Validators,
} from '@angular/forms';
import InlineEditor from '@ckeditor/ckeditor5-build-inline';
import { environment } from '../../../../environments/environment';
import { NgxSpinnerService } from 'ngx-spinner';
import { Observable, map, startWith } from 'rxjs';
@Component({
  selector: 'app-dashboard-treatment',
  templateUrl: './dashboard-treatment.component.html',
  styleUrls: ['./dashboard-treatment.component.scss'],
})
export class DashboardTreatmentComponent implements OnInit {
  constructor(
    private ApiService: ApiService,
    private formBuilder: FormBuilder,
    private toaster: Toaster,
    private spinner: NgxSpinnerService,
    private tokenStorage: TokenStorageService,private rzp: PayServiceService
  ) {
    
  }
  getListingChargesInfo(id:any): void {
    this.spinner.show();
    this.ApiService.getListingChargesInfo(id).subscribe(
      (data) => {
        if (data.status) {
          this.listinginfo = data.data;
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
  listinginfo:any;
  isLoggedIn: boolean = false;
  myInfo: any = '';
  @Input() pageFrom: any = '';
  ngOnInit(): void {
    this.isLoggedIn = !!this.tokenStorage.getToken();
    if (this.isLoggedIn) {
      this.myInfo = this.tokenStorage.getUser();  
    }
    this.getTreatmentList();
    this.getSpecialities();
    this.getIllnessList();
    this.getListingChargesInfo(10);
    let hospitalName = '';
    let pkLoc = ''; 
    if(this.myInfo?.type == "Hospital"){
      hospitalName = this.myInfo?.name;
      pkLoc = "Hospital"; 
    }
    this.sForm = this.formBuilder.group({
      id: [''],
      doctor_id: ['', Validators.required],
      hospital_id: [],
      speciality_id: ['', Validators.required],
      illness: ['', Validators.required],
      package_name: ['', Validators.required],
      package_location: [pkLoc, Validators.required],
      hospital_name: [hospitalName],
      hospital_address: [''],
      stay_type: ['', Validators.required],
      charges_in_rs: ['', Validators.required],
      discount_in_rs: ['', Validators.required],
      charges_in_doller: [''],
      discount_in_doller: [''],
      details: ['', Validators.required],
    });
    this.getDocListForHospital();

    this.filteredIll = this.sForm.get('illness').valueChanges.pipe(
      startWith(''),
      map((value:any) => value ? this._filterIll(value || '') : this.illnessList.slice(0,10)),
    );
    this.filteredSp = this.sForm.get('speciality_id').valueChanges.pipe(
      startWith(''),
      map((value:any) => value ? this._filterSp(value || '') : this.spacialityList.slice(0,10)),
    );
  }
  filteredIll: Observable<string[]>|any;
  filteredSp: Observable<string[]>|any;
  private _filterIll(value: string): string[] { 
    if(value == ''){ return [];}
    const filterValue = value.toLowerCase(); 
    return this.illnessList.filter((option:any) => option.title?.toLowerCase().includes(filterValue.toLowerCase()));
  }
  private _filterSp(value: string): string[] { 
    if(value == ''){ return [];}
    const filterValue = value.toLowerCase(); 
    return this.spacialityList.filter((option:any) => option.speciality_name?.toLowerCase().includes(filterValue.toLowerCase()));
  }
  editor: any = InlineEditor;
  ckconfig: any;
  BACK_END_MAPPING_URL_FOR_SAVE_IMG: string =
    environment.base_url + 'temp-image';
  tList: any = [];
  docList: any = [];
  tInfo: any = [];
  spacialityList: any = [];
  illnessList: any = [];
  sForm: FormGroup | any;
  b1: boolean = false;
  editPage: boolean = false;
  get f1(): { [key: string]: AbstractControl } {
    return this.sForm.controls;
  }
  editInfo(id: any = '') {
    this.editPage = !this.editPage;
    if (id != '') {
      this.getTreatmentList(id);
    } else {
      this.sForm.reset();
      let hospitalName = '';
      let pkLoc = ''; 
      if(this.myInfo?.type == "Hospital"){
        hospitalName = this.myInfo?.name;
        pkLoc = "Hospital"; 
      }

      this.sForm.controls['id'].setValue('');
      this.sForm.controls['package_location'].setValue(pkLoc);
      this.sForm.controls['hospital_name'].setValue(hospitalName);
      this.sForm.controls['details'].setValue(
        '<p><strong>Package Includes :</strong></p><p>&nbsp;</p><p>&nbsp;</p><p>&nbsp;</p><p>&nbsp;</p><p><strong>Package Excludes :</strong></p><p>&nbsp;</p><p>&nbsp;</p>'
      );
    }
  }
  getSpecialities(): void {
    this.ApiService.getSpecialities('').subscribe(
      (data) => {
        if (data.status) {
          this.spacialityList = data.data;
        } else {
          this.toaster.open({
            text: data.message,
            caption: 'Error',
            duration: 4000,
            type: 'danger',
          });
        }
      },
      (err) => {}
    );
  }
  getDocListForHospital(id: any = ''): void {
    this.ApiService.getDocListForHospital(id).subscribe(
      (data) => {
        if (data.status) { 
            this.docList = data.data; 
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
  getIllnessList(): void {
    this.ApiService.getIllnessList().subscribe(
      (data) => {
        if (data.status) {
          this.illnessList = data.data;
        } else {
          this.toaster.open({
            text: data.message,
            caption: 'Error',
            duration: 4000,
            type: 'danger',
          });
        }
      },
      (err) => {}
    );
  }

  getTreatmentList(id: any = ''): void {
    this.spinner.show();
    this.ApiService.getTreatmentList(id).subscribe(
      (data) => {
        if (data.status) {
          if (id == '') {
            this.tList = data.data;
          } else {
            this.tInfo = data.data;

            this.sForm.controls['id'].setValue(this.tInfo.id);
            this.sForm.controls['doctor_id'].setValue(this.tInfo.doctor_id);
            this.sForm.controls['hospital_id'].setValue(this.tInfo.hospital_id);
            this.sForm.controls['speciality_id'].setValue(
              parseInt(this.tInfo.speciality_id)
            );
            this.sForm.controls['illness'].setValue(
              parseInt(this.tInfo.illness)
            );
            this.sForm.controls['package_name'].setValue(
              this.tInfo.package_name
            );
            this.sForm.controls['package_location'].setValue(
              this.tInfo.package_location
            );
            this.sForm.controls['hospital_name'].setValue(
              this.tInfo.hospital_name
            );
            this.sForm.controls['hospital_address'].setValue(
              this.tInfo.hospital_address
            );
            this.sForm.controls['stay_type'].setValue(this.tInfo.stay_type);
            this.sForm.controls['charges_in_rs'].setValue(
              this.tInfo.charges_in_rs
            );
            this.sForm.controls['discount_in_rs'].setValue(
              this.tInfo.discount_in_rs
            );
            this.sForm.controls['charges_in_doller'].setValue(
              this.tInfo.charges_in_doller
            );
            this.sForm.controls['discount_in_doller'].setValue(
              this.tInfo.discount_in_doller
            );
            this.sForm.controls['details'].setValue(this.tInfo.details);
          }
          this.spinner.hide();
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

  onSubmit(isNew: boolean = false): void {
    this.b1 = true;
     
      
    if (this.pageFrom == 'doctor') {
      this.sForm.controls['doctor_id'].setValue(this.myInfo.user_id);
      this.sForm.controls['hospital_id'].setValue(0);
    } else {
      this.sForm.controls['hospital_id'].setValue(this.myInfo.user_id);
    }
    console.log(this.sForm);
    
    if (this.sForm.invalid) {
      this.toaster.open({
        text: 'Fill all required fields',
        caption: 'Message',
        duration: 4000,
        type: 'danger',
      });
      return;
    }
    this.spinner.show();
    this.ApiService.updateTreatmentInfo(this.sForm.value).subscribe(
      (data) => {
        if (data.status) {
          this.toaster.open({
            text: data.message,
            caption: 'Success',
            duration: 4000,
            type: 'success',
          });
          this.b1 = false;
          this.getTreatmentList();
          this.spinner.hide();
          this.editPage = !this.editPage;
          if(this.sForm.value.id == ''){
            let amount = this.listinginfo.price - this.listinginfo.discount;
            let sendData = JSON.stringify({treatment_id: data.data.id, amount:amount, user_id: this.myInfo.id});
            this.rzp.createRzpayOrder(amount,sendData,'listing_treatment'); 
          }
          
          this.sForm.reset();
          this.sForm.controls['id'].setValue('');
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
