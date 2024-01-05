import { Component, OnInit, Input, Output, EventEmitter } from '@angular/core';
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
  selector: 'app-setup-nursing',
  templateUrl: './setup-nursing.component.html',
  styleUrls: ['./setup-nursing.component.scss']
})
export class SetupNursingComponent implements OnInit {

  constructor(
    private ApiService: ApiService,
    private toaster: Toaster,
    private formBuilder: FormBuilder,
    private modalService: NgbModal,
    private emitService:EmitService,
    private spinner: NgxSpinnerService
  ) {}

  @Input() editId:any = '';
  @Input() page:any = '';
  @Output() isClosed:any = new EventEmitter;

  ngOnInit(): void {
    this.setupForm = this.formBuilder.group({
      id: [''],
      name: ['', Validators.required],
      regis_type: [''],
      part_fill_time: [''],
      work_hours: [''], 
      is_weekof_replacement: [''],
      custom_remarks: [''],
      visit_charges: [''],
      per_hour_charges: [''],
      per_days_charges: [''],
      per_month_charges: [''],
      image: [''],
      banner: [''],
      about: [''], 
      type: [''],
      gender: [''],
      registration_certificate: [''],
      experience: [''],
      mobile: [''],
      email: [''],
      id_proof: [''],
      qualification: [''],
      degree: [''],
      is_deleted: [''],
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
    this.getNursingInfo(this.editId);
    this.emitService.hideAddressDalog.subscribe((flag:any)=>{
      if(flag != ''){
        this.addressChanged = true;
        this.modalService.dismissAll();
        this.getNursingInfo(this.editId);
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
        } else if (name == 'id_proof') {
          this.setupForm.patchValue({
            id_proof: reader.result,
          });
        } else if (name == 'degree') {
          this.setupForm.patchValue({
            degree: reader.result,
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
  getNursingInfo(editId:any = ''): void {
    if(editId == ''){ return;}
    this.spinner.show();
    this.ApiService.getMyNursingInfo(editId).subscribe(
      (data) => {
        if (data.status) {
          this.Linfo = data.data.data;
          if(this.addressChanged){ 
            this.addressChanged = false;
            this.spinner.hide();
            return;
          }
          this.editId = this.Linfo.id;
          this.setupForm.controls['id'].setValue(this.Linfo.id); 
          this.setupForm.controls['name'].setValue(this.Linfo.name); 
          this.setupForm.controls['about'].setValue(this.Linfo.about);
          this.setupForm.controls['mobile'].setValue(this.Linfo.mobile);
          this.setupForm.controls['regis_type'].setValue(this.Linfo.regis_type); 

          this.emitService.setChangeIndOrBue(this.Linfo.regis_type);

          this.setupForm.controls['experience'].setValue(this.Linfo.experience);
          this.setupForm.controls['qualification'].setValue(this.Linfo.qualification);
          this.setupForm.controls['part_fill_time'].setValue(this.Linfo.part_fill_time);
          this.setupForm.controls['work_hours'].setValue(this.Linfo.work_hours);
          this.setupForm.controls['is_weekof_replacement'].setValue(this.Linfo.is_weekof_replacement);
          this.setupForm.controls['custom_remarks'].setValue(this.Linfo.custom_remarks);
          this.setupForm.controls['visit_charges'].setValue(this.Linfo.visit_charges);
          this.setupForm.controls['per_hour_charges'].setValue(this.Linfo.per_hour_charges);
          this.setupForm.controls['per_days_charges'].setValue(this.Linfo.per_days_charges);
          this.setupForm.controls['per_month_charges'].setValue(this.Linfo.per_month_charges);

          this.setupForm.controls['type'].setValue(
            this.Linfo.type
          );
          this.setupForm.controls['gender'].setValue(
            this.Linfo.gender
          );
          this.setupForm.controls['is_deleted'].setValue(
            this.Linfo.is_deleted
          );

          this.lForm.controls['cp_name'].setValue(this.Linfo.cp_name); 
          this.setupForm.controls['email'].setValue(this.Linfo.c_email);
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
    this.ApiService.updateNursingSetupInfoBank(this.editId,this.bForm.value).subscribe(
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
          this.getNursingInfo();
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
    this.ApiService.updateNursingSetupInfo(this.setupForm.value).subscribe(
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
          if(this.setupForm.value.is_deleted != '1'){
            this.getNursingInfo(data.data);
            this.matStep(2);
          }else{
            this.isClosed.emit();
          }
         
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
    this.ApiService.updateNursingSetupInfoCp(this.editId,this.lForm.value).subscribe(
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
          this.getNursingInfo();
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
