import { Component, ElementRef, OnInit, QueryList, ViewChild } from '@angular/core';
import { ApiService } from '../../../services/Api/api.service';
import { Toaster } from 'ngx-toast-notifications';
import {COMMA, ENTER} from '@angular/cdk/keycodes'; 
import { map, Observable, startWith } from 'rxjs';
import { NgbModal } from '@ng-bootstrap/ng-bootstrap';
import { EmitService } from '../../../services/Emit/emit.service';
import {
  AbstractControl,
  FormBuilder,
  FormControl,
  FormGroup,
  Validators,
} from '@angular/forms';
import { NgxSpinnerService } from 'ngx-spinner';
@Component({
  selector: 'app-hospital-setup-profile',
  templateUrl: './hospital-setup-profile.component.html',
  styleUrls: ['./hospital-setup-profile.component.scss'],
})
export class HospitalSetupProfileComponent implements OnInit {
  constructor(
    private ApiService: ApiService,
    private toaster: Toaster,
    private formBuilder: FormBuilder,
    private modalService: NgbModal,
    private emitService:EmitService,
    private spinner: NgxSpinnerService
  ) {}
  addressChanged: boolean = false;
  bForm: FormGroup | any;
  b4: boolean = false; 
  acnName:any = '';
  acnShow:boolean = false;
  get f4(): { [key: string]: AbstractControl } {
    return this.bForm.controls;
  }
  ngOnInit(): void {
    this.setupForm = this.formBuilder.group({
      name: ['', Validators.required],
      type: [''],
      phone_no: ['', Validators.required], 
      beds_quantity: [''],
      image: [''],
      about: [''], 
      facilities_avialable: [''],
      empanelments: [''],
      specialities_id: [''],
      procedures_id: [''],
      registration_details: [''],
      registration_file: [''],
      accredition_details: ['', Validators.required],
      accredition_certificate: [''],
    });
    this.lForm = this.formBuilder.group({
      contact_person_name: ['', Validators.required],
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
    this.getHospitalInfo();

    this.emitService.hideAddressDalog.subscribe((flag:any)=>{
      if(flag != ''){
        this.addressChanged = true;
        this.modalService.dismissAll();
        this.getHospitalInfo();
      }
    });
      
    this.filteredFac = this.facCtrl.valueChanges.pipe(
      startWith(''),
      map((value:any) => value != '' ? this._filterFac(value || '') :  this.fList.filter((op1:any) => (!this.selectedFac.some((op2:any) => op1.id === op2.id))).slice(0,10)),
    );
      
    this.filteredEmp = this.empCtrl.valueChanges.pipe(
      startWith(''),
      map((value:any) => value != '' ? this._filterEmp(value || '') :  this.eList.filter((op1:any) => (!this.selectedEmp.some((op2:any) => op1.id === op2.id))).slice(0,10)),
    );
      
    this.filteredSpc = this.spcCtrl.valueChanges.pipe(
      startWith(''),
      map((value:any) => value != '' ? this._filterSpc(value || '') :  this.sList.filter((op1:any) => (!this.selectedSpc.some((op2:any) => op1.id === op2.id))).slice(0,10)),
    );
    this.filteredPro = this.proCtrl.valueChanges.pipe(
      startWith(''),
      map((value:any) => value != '' ? this._filterPro(value || '') :  this.pList.filter((op1:any) => (!this.selectedPro.some((op2:any) => op1.id === op2.id))).slice(0,10)),
    );
  } 
  openAddressPopup(modalName: any) { 
    this.modalService.open(modalName, {
      centered: true,
      size: 'lg',
      backdropClass: 'light-blue-backdrop',
    });
  }
  activeMat: number = 1;
  setupForm: FormGroup | any;
  lForm: FormGroup | any;
  b1: boolean = false;
  b2: boolean = false;
  hInfo: any = [];
  fList: any = [];
  eList: any = [];
  sList: any = [];
  pList: any = [];
  get f1(): { [key: string]: AbstractControl } {
    return this.setupForm.controls;
  }
  get f2(): { [key: string]: AbstractControl } {
    return this.lForm.controls;
  }
  selectedFac: any = [];
  selectedEmp: any = [];
  selectedSpc: any = [];
  selectedPro: any = [];
  facCtrl = new FormControl('');
  empCtrl = new FormControl('');
  spcCtrl = new FormControl('');
  proCtrl = new FormControl('');
  filteredFac: Observable<string[]>|any; 
  filteredEmp: Observable<string[]>|any; 
  filteredSpc: Observable<string[]>|any; 
  filteredPro: Observable<string[]>|any; 
  @ViewChild('facInput') facInput: ElementRef<HTMLInputElement> | any;
  @ViewChild('empInput') empInput: ElementRef<HTMLInputElement> | any;
  @ViewChild('spcInput') spcInput: ElementRef<HTMLInputElement> | any;
  @ViewChild('proInput') proInput: ElementRef<HTMLInputElement> | any;
  separatorKeysCodes: number[] = [ENTER, COMMA];
  add(event: any, type:any): void {
    let value:any = (event.value || '').trim();  
    if(type == 'Facilities'){
      if (value) {
        if(typeof value == 'string'){
          value = { id: value, title : value};
        } 
        this.selectedFac.push(value);
      }  
      event.chipInput!.clear(); 
      this.facCtrl.setValue(null);
    } else if(type == 'Empanelments'){
      if (value) {
        if(typeof value == 'string'){
          value = { id: value, title : value};
        } 
        this.selectedEmp.push(value);
      }  
      event.chipInput!.clear(); 
      this.empCtrl.setValue(null);
    } else if(type == 'Specialities'){
      if (value) {
        if(typeof value == 'string'){
          value = { id: value, speciality_name : value};
        } 
        this.selectedSpc.push(value);
      }  
      event.chipInput!.clear(); 
      this.spcCtrl.setValue(null);
    } else if(type == 'Procedures'){
      if (value) {
        if(typeof value == 'string'){
          value = { id: value, name : value};
        } 
        this.selectedPro.push(value);
      }  
      event.chipInput!.clear(); 
      this.proCtrl.setValue(null);
    } 
    
  }
  
  remove(searchValue: string, type:any): void {
    if(type == 'Facilities'){
      const index = this.selectedFac.indexOf(searchValue); 
      if (index >= 0) {
        this.selectedFac.splice(index, 1);
      }
    }else if(type == 'Empanelments'){
      const index = this.selectedEmp.indexOf(searchValue); 
      if (index >= 0) {
        this.selectedEmp.splice(index, 1);
      }
    }else if(type == 'Specialities'){
      const index = this.selectedSpc.indexOf(searchValue); 
      if (index >= 0) {
        this.selectedSpc.splice(index, 1);
      }
    }else if(type == 'Procedures'){
      const index = this.selectedPro.indexOf(searchValue); 
      if (index >= 0) {
        this.selectedPro.splice(index, 1);
      }
    } 

  }
  
  selected(event: any, type:any): void {  
    if(type == 'Facilities'){
      this.selectedFac.push(event.option.value);
      this.facInput.nativeElement.value = '';
      this.facCtrl.setValue('');
    }else if(type == 'Empanelments'){
      this.selectedEmp.push(event.option.value);
      this.empInput.nativeElement.value = '';
      this.empCtrl.setValue('');
    }else if(type == 'Specialities'){
      this.selectedSpc.push(event.option.value);
      this.spcInput.nativeElement.value = '';
      this.spcCtrl.setValue('');
    }else if(type == 'Procedures'){
      this.selectedPro.push(event.option.value);
      this.proInput.nativeElement.value = '';
      this.proCtrl.setValue('');
    }
  }
  private _filterFac(value: any): string[] {   
    if((typeof value != 'string' && !(value instanceof String))){ return [];}
    const filterValue = value.toLowerCase(); 
    const results = this.fList.filter((op1:any) => (!this.selectedFac.some((op2:any) => op1.id === op2.id)));  
    
    if(value == ''){ return results;}
    return results.filter((option:any) => option.title?.toLowerCase().includes(filterValue.toLowerCase()));
  }
  private _filterEmp(value: any): string[] {   
    if((typeof value != 'string' && !(value instanceof String))){ return [];}
    const filterValue = value.toLowerCase(); 
    const results = this.eList.filter((op1:any) => (!this.selectedEmp.some((op2:any) => op1.id === op2.id)));  
    
    if(value == ''){ return results;}
    return results.filter((option:any) => option.title?.toLowerCase().includes(filterValue.toLowerCase()));
  }
  private _filterSpc(value: any): string[] {   
    if((typeof value != 'string' && !(value instanceof String))){ return [];}
    const filterValue = value.toLowerCase(); 
    const results = this.sList.filter((op1:any) => (!this.selectedSpc.some((op2:any) => op1.id === op2.id)));  
    
    if(value == ''){ return results;}
    return results.filter((option:any) => option.speciality_name?.toLowerCase().includes(filterValue.toLowerCase()));
  }
  private _filterPro(value: any): string[] {   
    if((typeof value != 'string' && !(value instanceof String))){ return [];}
    const filterValue = value.toLowerCase(); 
    const results = this.pList.filter((op1:any) => (!this.selectedPro.some((op2:any) => op1.id === op2.id)));  
    
    if(value == ''){ return results;}
    return results.filter((option:any) => option.name?.toLowerCase().includes(filterValue.toLowerCase()));
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
        } else if (name == 'registration_file') {
          this.setupForm.patchValue({
            registration_file: reader.result,
          });
        } else if (name == 'accredition_certificate') {
          this.setupForm.patchValue({
            accredition_certificate: reader.result,
          });
        }else if (name == 'cancel_cheque') {
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
    this.ApiService.updateHosSetupInfoBank(this.bForm.value).subscribe(
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
          this.getHospitalInfo();
          window.scrollTo(0, 0); 
        } else {
          this.toaster.open({
            text: data.message,
            caption: 'Error',
            duration: 4000,
            type: 'danger',
          });
          this.spinner.hide();
        }
        
        this.activeMat = 4;
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
  getHospitalInfo(): void {
    this.spinner.show();
    this.ApiService.getHospInfo().subscribe(
      (data) => {
        if (data.status) {
          this.hInfo = data.data.data;
          if(this.addressChanged){ 
            this.addressChanged = false;
            this.spinner.hide();
            return;
          } 
          this.fList = data.data.facilities;
          this.eList = data.data.empanelments;
          this.sList = data.data.specialities;
          this.pList = data.data.procedures;
          this.setupForm.controls['name'].setValue(this.hInfo.name);
          this.setupForm.controls['type'].setValue(this.hInfo.type);
          this.setupForm.controls['phone_no'].setValue(this.hInfo.phone_no);
          
          this.setupForm.controls['beds_quantity'].setValue(
            this.hInfo.beds_quantity
          );
          this.setupForm.controls['about'].setValue(this.hInfo.about); 
          this.setupForm.controls['registration_details'].setValue(
            this.hInfo.registration_details
          );
          
          if(this.hInfo.facilities_avialable){
            let parshedFac = JSON.parse(this.hInfo.facilities_avialable)
            this.selectedFac = this.fList.filter((op1:any) => (parshedFac.some((op2:any) => op1.id === op2))); 
            this.setupForm.controls['facilities_avialable'].setValue(parshedFac);
          }
          
          if(this.hInfo.empanelments){
            let parshedEmp = JSON.parse(this.hInfo.empanelments)
            this.selectedEmp = this.eList.filter((op1:any) => (parshedEmp.some((op2:any) => op1.id === op2)));
            this.setupForm.controls['empanelments'].setValue(parshedEmp);
          }
          
          if(this.hInfo.specialities_id){
            let parshedSpc = JSON.parse(this.hInfo.specialities_id)
            this.selectedSpc = this.sList.filter((op1:any) => (parshedSpc.some((op2:any) => op1.id === op2)));
            this.setupForm.controls['specialities_id'].setValue(parshedSpc);
          }

          if(this.hInfo.procedures_id){
            let parshedPro = JSON.parse(this.hInfo.procedures_id)
            this.selectedPro = this.pList.filter((op1:any) => (parshedPro.some((op2:any) => op1.id === op2)));
            this.setupForm.controls['procedures_id'].setValue(parshedPro);
          }

          if( this.hInfo.accredition != ''){
            let acn:any = this.hInfo.accredition_details.split(',');
            this.setupForm.controls['accredition_details'].setValue(acn);
            
            let i1 = acn.indexOf('ISO');
            if(i1 > -1){
              acn.splice(i1, 1);
            }
            let i2 = acn.indexOf('QCI');
            if(i2 > -1){
              acn.splice(i2, 1);
            }
            let i3 = acn.indexOf('NABH');
            if(i3 > -1){
              acn.splice(i3, 1);
            }
            if(acn.length){
              this.acnShow = true;
              this.acnName = acn.join(',');
            }else{
              this.acnShow = false;
            }
          } 

          this.lForm.controls['contact_person_name'].setValue(
            this.hInfo.c_name
          );
          this.lForm.controls['email'].setValue(this.hInfo.c_email);
          this.lForm.controls['mobile'].setValue(this.hInfo.c_mobile);

          this.bForm.controls['name'].setValue(this.hInfo.name_on_bank);
          this.bForm.controls['bank_name'].setValue(this.hInfo.bank_name);
          this.bForm.controls['branch_name'].setValue(this.hInfo.branch_name);
          this.bForm.controls['ifsc'].setValue(this.hInfo.ifsc);
          this.bForm.controls['ac_no'].setValue(this.hInfo.ac_no);
          this.bForm.controls['ac_type'].setValue(this.hInfo.ac_type);
          this.bForm.controls['micr_code'].setValue(this.hInfo.micr_code);
          this.bForm.controls['pan_no'].setValue(this.hInfo.pan_no);
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
  changeAcn(event: any){
    let index = event.value.indexOf('Other');
    if(index > -1){
      this.acnShow = true;
    }else{
      this.acnShow = false;
    }
  }
  onSubmit(): void {
    this.b1 = true;
    var selectedFacArray = this.selectedFac.map(function (obj:any) { return obj.id; }); 
    var selectedEmpArray = this.selectedEmp.map(function (obj:any) { return obj.id; }); 
    var selectedSpcArray = this.selectedSpc.map(function (obj:any) { return obj.id; }); 
    var selectedProArray = this.selectedPro.map(function (obj:any) { return obj.id; }); 
    this.setupForm.controls['facilities_avialable'].setValue(selectedFacArray);
    this.setupForm.controls['empanelments'].setValue(selectedEmpArray);
    this.setupForm.controls['specialities_id'].setValue(selectedSpcArray);
    this.setupForm.controls['procedures_id'].setValue(selectedProArray);
    let index = this.setupForm.value.accredition_details.indexOf('Other');
    if(index > -1){
      this.setupForm.value.accredition_details.pop();
      this.setupForm.value.accredition_details.push(this.acnName);
    } 
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
    this.ApiService.updateHosSetupInfo(this.setupForm.value).subscribe(
      (data) => {
        if (data.status) {
          this.toaster.open({
            text: data.message,
            caption: 'Success',
            duration: 4000,
            type: 'success',
          });
          this.b1 = false;
          this.activeMat = 2;
          this.spinner.hide();
          this.getHospitalInfo();
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
    this.ApiService.updateHosSetupInfoCp(this.lForm.value).subscribe(
      (data) => {
        if (data.status) {
          this.toaster.open({
            text: data.message,
            caption: 'Success',
            duration: 4000,
            type: 'success',
          });
          this.b2 = false;
          this.activeMat = 3;
          this.spinner.hide();
          this.getHospitalInfo();
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
