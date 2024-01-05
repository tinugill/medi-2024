import { Component, OnInit, QueryList, ViewChild } from '@angular/core';
import { ApiService } from '../../../services/Api/api.service';
import { Toaster } from 'ngx-toast-notifications';
import { NgbModal } from '@ng-bootstrap/ng-bootstrap';
import { EmitService } from '../../../services/Emit/emit.service';
import {
  AbstractControl,
  FormBuilder,
  FormGroup,
  Validators,
} from '@angular/forms';
import { NgxSpinnerService } from 'ngx-spinner';
@Component({
  selector: 'app-pharmacy-setup-profile',
  templateUrl: './pharmacy-setup-profile.component.html',
  styleUrls: ['./pharmacy-setup-profile.component.scss'],
})
export class PharmacySetupProfileComponent implements OnInit {
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
      owner_id: [''],
      partner_name: [''],
      partner_id: [''],
      pharmacist_name: ['', Validators.required],
      pharmacist_regis_no: ['', Validators.required],
      pharmacist_regis_upload: [''],
      gstin: ['', Validators.required],
      gstin_certificate: [''], 
      image: [''], 
      drug_liscence_number: [''],
      drug_liscence_file: [''],
      drug_liscence_valid_upto: [''],
      delivery_charges: [0],
      delivery_charges_if_less: [0],
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
    this.getPharmasyInfo();
    this.emitService.hideAddressDalog.subscribe((flag:any)=>{
      if(flag != ''){
        this.addressChanged = true;
        this.modalService.dismissAll();
        this.getPharmasyInfo();
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
        } else if (name == 'owner_id') {
          this.setupForm.patchValue({
            owner_id: reader.result,
          });
        } else if (name == 'partner_id') {
          this.setupForm.patchValue({
            partner_id: reader.result,
          });
        } else if (name == 'pharmacist_regis_upload') {
          this.setupForm.patchValue({
            pharmacist_regis_upload: reader.result,
          });
        } else if (name == 'gstin_certificate') {
          this.setupForm.patchValue({
            gstin_certificate: reader.result,
          });
        } else if (name == 'drug_liscence_file') {
          this.setupForm.patchValue({
            drug_liscence_file: reader.result,
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
  getPharmasyInfo(): void {
    this.spinner.show();
    this.ApiService.getMyPharmasyInfo().subscribe(
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
          this.setupForm.controls['partner_name'].setValue(this.Linfo.partner_name);
          this.setupForm.controls['pharmacist_name'].setValue(this.Linfo.pharmacist_name);
          this.setupForm.controls['pharmacist_regis_no'].setValue(this.Linfo.pharmacist_regis_no);
          this.setupForm.controls['gstin'].setValue(this.Linfo.gstin); 
          this.setupForm.controls['drug_liscence_number'].setValue(
            this.Linfo.drug_liscence_number
          );
          this.setupForm.controls['drug_liscence_valid_upto'].setValue(
            this.Linfo.drug_liscence_valid_upto
          );
          this.setupForm.controls['delivery_charges'].setValue(
            this.Linfo.delivery_charges
          );
          this.setupForm.controls['delivery_charges_if_less'].setValue(
            this.Linfo.delivery_charges_if_less
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
    this.ApiService.updatePharmacySetupInfoBank(this.bForm.value).subscribe(
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
          this.getPharmasyInfo();
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
    this.ApiService.updatePharmacySetupInfo(this.setupForm.value).subscribe(
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
          this.getPharmasyInfo();
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
    this.ApiService.updatePharmacySetupInfoCp(this.lForm.value).subscribe(
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
          this.getPharmasyInfo();
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
