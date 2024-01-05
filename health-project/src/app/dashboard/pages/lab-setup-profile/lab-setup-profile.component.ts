import { Component, OnInit, QueryList, ViewChild } from '@angular/core';
import { ApiService } from '../../../services/Api/api.service';
import { Toaster } from 'ngx-toast-notifications';
import { NgbModal } from '@ng-bootstrap/ng-bootstrap';
import { EmitService } from '../../../services/Emit/emit.service';
import {
  AbstractControl,
  FormArray,
  FormBuilder,
  FormGroup,
  Validators,
} from '@angular/forms';
import { NgxSpinnerService } from 'ngx-spinner';
@Component({
  selector: 'app-lab-setup-profile',
  templateUrl: './lab-setup-profile.component.html',
  styleUrls: ['./lab-setup-profile.component.scss'],
})
export class LabSetupProfileComponent implements OnInit {
  constructor(
    private ApiService: ApiService,
    private toaster: Toaster,
    private formBuilder: FormBuilder,
    private modalService: NgbModal,
    private emitService:EmitService,
    private spinner: NgxSpinnerService
  ) {}
  addressChanged: boolean = false;
  ngOnInit(): void {
    this.setupForm = this.formBuilder.group({
      name: ['', Validators.required],
      owner_name: ['', Validators.required],
      owner_id: [''],
      phone_no: [''],
      h_c_fee: [''],
      h_c_fee_apply_before: [''],
      r_d_fee: [''],
      r_d_fee_apply_before: [''],
      ambulance_fee: [''], 
      days: [''],
      image: [''], 
      registration_detail: [''],
      about: [''],
      registration_file: [''],
      accredition_details: ['', Validators.required],
      accredition_certificate: this.formBuilder.array([]),
    });
    this.lForm = this.formBuilder.group({
      cp_name: ['', Validators.required],
      email: ['', Validators.required],
      mobile: ['', Validators.required],
      password: [''],
    });
    this.bForm = this.formBuilder.group({
      name: ['', Validators.required],
      bank_name: ['', Validators.required],
      branch_name: ['', Validators.required],
      ifsc: ['', Validators.required],
      ac_no: ['', Validators.required],
      ac_type: ['', Validators.required],
      micr_code: [''],
      cancel_cheque: [''],
      pan_no: ['', Validators.required],
      pan_image: [''],
    });
    this.getLabInfo();
    
    this.emitService.hideAddressDalog.subscribe((flag:any)=>{
      if(flag != ''){
        this.addressChanged = true;
        this.modalService.dismissAll();
        this.getLabInfo();
      }
    });
  }
  openAddressPopup(modalName: any) { 
    this.modalService.open(modalName, {
      centered: true,
      size: 'lg',
      backdropClass: 'light-blue-backdrop',
    });
  }
  matStep(step: any) {
    this.stepExpn = step;
  }
  stepExpn: any = 1;
  bForm: FormGroup | any;
  setupForm: FormGroup | any;
  lForm: FormGroup | any;
  Linfo: any = [];
  b1: boolean = false;
  b2: boolean = false;
  b4: boolean = false;
  get f4(): { [key: string]: AbstractControl } {
    return this.bForm.controls;
  }
  get f1(): { [key: string]: AbstractControl } {
    return this.setupForm.controls;
  }
  get f2(): { [key: string]: AbstractControl } {
    return this.lForm.controls;
  }
  onFileChange(e: any, name: any, key:any = ''): void {
    const reader = new FileReader();

    if (e.target.files && e.target.files.length) {
      const file = e.target.files[0];
      reader.readAsDataURL(file);

      reader.onload = () => {
        if (name == 'image') {
          this.setupForm.patchValue({
            image: reader.result,
          });
        } else if (name == 'owner_id') {
          this.setupForm.patchValue({
            owner_id: reader.result,
          });
        } else if (name == 'registration_file') {
          this.setupForm.patchValue({
            registration_file: reader.result,
          });
        } else if (name == 'cancel_cheque') {
          this.bForm.patchValue({
            cancel_cheque: reader.result,
          });
        } else if (name == 'pan_image') {
          this.bForm.patchValue({
            pan_image: reader.result,
          });
        } else if (name == 'accredition_certificate') {
          const itm = {key: key, value: reader.result}; 
          this.setupForm.get('accredition_certificate').push(this.formBuilder.group(itm));
        }
      }
    }
  }
  getLabInfo(): void {
    this.spinner.show();
    this.ApiService.getMyLabInfo().subscribe(
      (data) => {
        if (data.status) {
          this.Linfo = data.data.data;
          if(this.addressChanged){ 
            this.addressChanged = false;
            this.spinner.hide();
            return;
          }
          this.setupForm.controls['name'].setValue(this.Linfo.name);
          this.setupForm.controls['owner_name'].setValue(this.Linfo.owner_name); 
          this.setupForm.controls['phone_no'].setValue(this.Linfo.phone_no);
          this.setupForm.controls['h_c_fee'].setValue(this.Linfo.h_c_fee);
          this.setupForm.controls['h_c_fee_apply_before'].setValue(this.Linfo.h_c_fee_apply_before);
          this.setupForm.controls['r_d_fee'].setValue(this.Linfo.r_d_fee);
          this.setupForm.controls['r_d_fee_apply_before'].setValue(this.Linfo.r_d_fee_apply_before);
          this.setupForm.controls['ambulance_fee'].setValue(this.Linfo.ambulance_fee); 
          if (this.Linfo.days != '') {
            this.setupForm.controls['days'].setValue(
              JSON.parse(this.Linfo.days)
            );
          }
          this.setupForm.controls['accredition_details'].setValue(
            this.Linfo.accredition_details?.split(",")
          ); 
          this.setupForm.controls['registration_detail'].setValue(
            this.Linfo.registration_detail
          );
          this.setupForm.controls['about'].setValue(
            this.Linfo.about
          );

          this.lForm.controls['cp_name'].setValue(this.Linfo.cp_name);
          this.lForm.controls['email'].setValue(this.Linfo.c_email);
          this.lForm.controls['mobile'].setValue(this.Linfo.c_mobile);

          this.bForm.controls['name'].setValue(this.Linfo.name_on_bank);
          this.bForm.controls['bank_name'].setValue(this.Linfo.bank_name);
          this.bForm.controls['branch_name'].setValue(this.Linfo.branch_name);
          this.bForm.controls['ifsc'].setValue(this.Linfo.ifsc);
          this.bForm.controls['ac_no'].setValue(this.Linfo.ac_no);
          this.bForm.controls['ac_type'].setValue(this.Linfo.ac_type);
          this.bForm.controls['micr_code'].setValue(this.Linfo.micr_code);
          this.bForm.controls['pan_no'].setValue(this.Linfo.pan_no);
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

  onSubmit(): void {
    this.b1 = true;
    if (this.setupForm.invalid) {
      this.toaster.open({
        text: 'Fill all required fields',
        caption: 'Message',
        duration: 4000,
        type: 'danger',
      });
      return;
    }
    
    this.spinner.show();
    this.ApiService.updateLabSetupInfo(this.setupForm.value).subscribe(
      (data) => {
        if (data.status) {
          this.toaster.open({
            text: data.message,
            caption: 'Success',
            duration: 4000,
            type: 'success',
          });
          this.b1 = false;
          this.matStep(2);
          this.spinner.hide();
          this.getLabInfo();
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
  onSubmitCp(): void {
    this.b2 = true;
    if (this.lForm.invalid) {
      this.toaster.open({
        text: 'Fill all required fields',
        caption: 'Message',
        duration: 4000,
        type: 'danger',
      });
      return;
    }
    this.spinner.show();
    this.ApiService.updateLabSetupInfoCp(this.lForm.value).subscribe(
      (data) => {
        if (data.status) {
          this.toaster.open({
            text: data.message,
            caption: 'Success',
            duration: 4000,
            type: 'success',
          });
          this.b2 = false;
          this.matStep(3);
          this.spinner.hide();
          this.getLabInfo();
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
  onSubmitBank(): void {
    this.b4 = true;

    if (this.bForm.invalid) {
      this.toaster.open({
        text: 'Fill all required fields',
        caption: 'Message',
        duration: 4000,
        type: 'danger',
      });
      return;
    }
    this.spinner.show();
    this.ApiService.updateLabSetupInfoBank(this.bForm.value).subscribe(
      (data) => {
        if (data.status) {
          this.toaster.open({
            text: data.message,
            caption: 'Success',
            duration: 4000,
            type: 'success',
          });
          this.b4 = false;
          this.spinner.hide();
          this.getLabInfo();
          window.scrollTo(0, 0);
          this.matStep(4);
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
