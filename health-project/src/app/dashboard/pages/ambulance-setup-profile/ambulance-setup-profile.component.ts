import { Component, OnInit, QueryList, ViewChild } from '@angular/core';
import { ApiService } from '../../../services/Api/api.service';
import { Toaster } from 'ngx-toast-notifications';
import {
  AbstractControl,
  FormBuilder,
  FormGroup,
  Validators,
} from '@angular/forms';
import { NgbModal } from '@ng-bootstrap/ng-bootstrap';
import { EmitService } from '../../../services/Emit/emit.service';
import { NgxSpinnerService } from 'ngx-spinner';
@Component({
  selector: 'app-ambulance-setup-profile',
  templateUrl: './ambulance-setup-profile.component.html',
  styleUrls: ['./ambulance-setup-profile.component.scss']
})
export class AmbulanceSetupProfileComponent implements OnInit {

  
  constructor(
    private ApiService: ApiService,
    private toaster: Toaster,
    private formBuilder: FormBuilder,
    private modalService: NgbModal,
    private emitService:EmitService,
    private spinner: NgxSpinnerService
  ) {}

  ngOnInit(): void {
    this.setupForm = this.formBuilder.group({
      name: ['', Validators.required],  
      owner_name: ['', Validators.required],  
      public_number: ['', Validators.required],  
      type_of_user: ['', Validators.required],
      image: [''],
      banner: [''],
      about: [''], 
      gstin: ['', Validators.required],
      aadhar: ['', Validators.required],
      registration_certificate: [''],
      gstin_proof: [''],
      aadhar_proof: [''], 
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
    this.getMyAmbInfo();
    this.emitService.hideAddressDalog.subscribe((flag:any)=>{
      if(flag != ''){
        this.addressChanged = true;
        this.modalService.dismissAll();
        this.getMyAmbInfo();
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
  addressChanged: boolean = false;
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
  onFileChange(e: any, name: any): void {
    const reader = new FileReader();

    if (e.target.files && e.target.files.length) {
      const file = e.target.files[0];
      reader.readAsDataURL(file);

      reader.onload = () => {
        if (name == 'image') {
          this.setupForm.patchValue({
            image: reader.result,
          });
        } else if (name == 'banner') {
          this.setupForm.patchValue({
            banner: reader.result,
          });
        } else if (name == 'registration_certificate') {
          this.setupForm.patchValue({
            registration_certificate: reader.result,
          });
        } else if (name == 'gstin_proof') {
          this.setupForm.patchValue({
            gstin_proof: reader.result,
          });
        } else if (name == 'aadhar_proof') {
          this.setupForm.patchValue({
            aadhar_proof: reader.result,
          });
        } else if (name == 'cancel_cheque') {
          this.bForm.patchValue({
            cancel_cheque: reader.result,
          });
        } else if (name == 'pan_image') {
          this.bForm.patchValue({
            pan_image: reader.result,
          });
        }
      };
    }
  }
  getMyAmbInfo(): void {
    this.spinner.show();
    this.ApiService.getMyAmbInfo().subscribe(
      (data) => {
        if (data.status) {
          this.Linfo = data.data.data;
          if(this.addressChanged){ 
            this.addressChanged = false;
            this.spinner.hide();
            return;
          }
          this.setupForm.controls['name'].setValue(this.Linfo.name); 
          this.setupForm.controls['public_number'].setValue(this.Linfo.public_number); 
          this.setupForm.controls['owner_name'].setValue(this.Linfo.owner_name); 
          this.setupForm.controls['type_of_user'].setValue(this.Linfo.type_of_user); 
          this.setupForm.controls['about'].setValue(this.Linfo.about);
          this.setupForm.controls['gstin'].setValue(this.Linfo.gstin);
          this.setupForm.controls['aadhar'].setValue(this.Linfo.aadhar); 

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
    this.ApiService.updateAmbSetupInfoBank(this.bForm.value).subscribe(
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
          this.getMyAmbInfo();
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
    this.ApiService.updateAmbSetupInfo(this.setupForm.value).subscribe(
      (data) => {
        if (data.status) {
          this.toaster.open({
            text: data.message,
            caption: 'Success',
            duration: 4000,
            type: 'success',
          });
          this.b1 = false;
          this.spinner.hide();
          this.getMyAmbInfo();
          this.matStep(2);
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
    this.ApiService.updateAmbSetupInfoCp(this.lForm.value).subscribe(
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
          this.getMyAmbInfo();
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
