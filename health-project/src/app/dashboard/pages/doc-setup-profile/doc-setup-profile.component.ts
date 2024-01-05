import { Component, OnInit,ElementRef, ViewChild } from '@angular/core';
import { ApiService } from '../../../services/Api/api.service';
import { TokenStorageService } from '../../../services/Token/token-storage.service';
import { Toaster } from 'ngx-toast-notifications';
import InlineEditor from '@ckeditor/ckeditor5-build-inline';
import { environment } from '../../../../environments/environment';
import {COMMA, ENTER} from '@angular/cdk/keycodes';
import { NgbModal } from '@ng-bootstrap/ng-bootstrap';
import { EmitService } from '../../../services/Emit/emit.service';
import {
  AbstractControl,
  FormBuilder,
  FormControl,
  FormGroup,
  Validators,
} from '@angular/forms';
import { map, Observable, startWith } from 'rxjs';
import { NgxSpinnerService } from 'ngx-spinner';
@Component({
  selector: 'app-doc-setup-profile',
  templateUrl: './doc-setup-profile.component.html',
  styleUrls: ['./doc-setup-profile.component.scss'],
})
export class DocSetupProfileComponent implements OnInit {
  constructor(
    private ApiService: ApiService,
    private toaster: Toaster,
    private tokenStorage: TokenStorageService,
    private formBuilder: FormBuilder,
    private modalService: NgbModal,
    private emitService:EmitService,
    private spinner: NgxSpinnerService
  ) {
    this.isLoggedIn = !!this.tokenStorage.getToken();
    if (this.isLoggedIn) {
      this.myInfo = this.tokenStorage.getUser();
      console.log(this.myInfo);
      
    }
  }
  
  isLoggedIn: boolean = false;
  myInfo: any = '';
  editor: any = InlineEditor;
  ckconfig: any;
  BACK_END_MAPPING_URL_FOR_SAVE_IMG: string =
    environment.base_url + 'temp-image';
  sList: any = [];
  bankDetails: any = [];
  docInfo: any = [];
  medical_counsiling: any = [];
  spz_list: any = [];
  symptomList: any = [];
  deasiesList: any = [];
  treatmentList: any = [];
  qList: any = [];
  designation: any = [];
  eduList: any = [];
  setupForm: FormGroup | any;
  sForm: FormGroup | any;
  aForm: FormGroup | any;
  bForm: FormGroup | any;
  eForm: FormGroup | any;
  stepExpn: any = 1;
  b1: boolean = false;
  b2: boolean = false;
  b3: boolean = false;
  b4: boolean = false;
  b5: boolean = false;
  address_type:any = '';
  addressChanged: boolean = false;
  ngOnInit(): void {
    this.emitService.hideAddressDalog.subscribe((flag:any)=>{
      if(flag != ''){
        this.addressChanged = true;
        this.modalService.dismissAll();
        this.getDocInfo();
      }
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
    this.sForm = this.formBuilder.group({
      specialization_id: ['', Validators.required],
      specialities_id: ['', Validators.required],
      symptom_i_see: [''],
      deasies_i_treat: [''],
      treatment_and_surgery: [''],
    });
    this.aForm = this.formBuilder.group({
      award: [''],
      memberships_detail: [''],
    });
    this.eForm = this.formBuilder.group({
      qualification_id: ['', Validators.required],
      certificate: [''],
    });
    this.setupForm = this.formBuilder.group({
      full_name: ['', Validators.required],
      gender: [''],
      degree_file: [''],
      working_days: ['', Validators.required],
      password: [''],
      l_h_image: [''],
      l_h_sign: [''],
      doctor_image: [''],
      doctor_banner: [''],
      home_visit: ['', Validators.required],
      consultancy_fee: ['', Validators.required],
      home_consultancy_fee: ['0'],
      online_consultancy_fee: ['0'],
      designation: [''],
      about: [''],
      experience: [''],
      registration_details: ['', Validators.required],
      medical_counsiling: ['', Validators.required],
      registration_certificate: [''], 
      letterhead: [''],
      signature: [''],
    });

    this.getDocInfo();
    this.getDesignation();
    this.getMedicalCounsiling();
   

    setTimeout(() => {
      this.getSpecialities();
      this.getDocWFieldList();
    }, 300);

    this.filteredDesi = this.setupForm.get('designation').valueChanges.pipe(
      startWith(''),
      map((value:any) => value ? this._filterDesig(value || '') : this.designation.slice(0,10)),
    );
    this.filteredMedi = this.setupForm.get('medical_counsiling').valueChanges.pipe(
      startWith(''),
      map((value:any) => value ? this._filterMedi(value || '') : this.medical_counsiling.slice(0,10)),
    );
    let qfyUniq = this.spz_list.filter((op1:any) => (!this.selectedQualifi.some((op2:any) => op1.id === op2.id))); 
    this.filteredQulfy = this.qulfyCtrl.valueChanges.pipe(
      startWith(''),
      map((value:any) => value ? this._filterQulfy(value || '') : qfyUniq.slice(0,10)),
    );
    let splstUniq = this.sList.filter((op1:any) => (!this.selectedSpl.some((op2:any) => op1.id === op2.id))); 
    this.filteredSpl = this.spCtrl.valueChanges.pipe(
      startWith(''),
      map((value:any) => value ? this._filterSp(value || '') : splstUniq.slice(0,10)),
    );
    let ssiUniq = this.symptomList.filter((op1:any) => (!this.selectedSSI.some((op2:any) => op1.id === op2.id))); 
    this.filteredSSI = this.ssiCtrl.valueChanges.pipe(
      startWith(''),
      map((value:any) => value ? this._filterSSI(value || '') : ssiUniq.slice(0,10)),
    );
    let ditUniq = this.deasiesList.filter((op1:any) => (!this.selectedDIT.some((op2:any) => op1.id === op2.id))); 
    this.filteredDIT = this.ditCtrl.valueChanges.pipe(
      startWith(''),
      map((value:any) => value ? this._filterDIT(value || '') : ditUniq.slice(0,10)),
    );
    let tiUniq = this.treatmentList.filter((op1:any) => (!this.selectedTI.some((op2:any) => op1.id === op2.id))); 
    this.filteredTI = this.tiCtrl.valueChanges.pipe(
      startWith(''),
      map((value:any) => value ? this._filterTI(value || '') : tiUniq.slice(0,10)),
    );
  }
  filteredDesi: Observable<string[]>|any;
  filteredMedi: Observable<string[]>|any;
  filteredQulfy: Observable<string[]>|any; 
  filteredSpl: Observable<string[]>|any; 
  filteredSSI: Observable<string[]>|any; 
  filteredDIT: Observable<string[]>|any; 
  filteredTI: Observable<string[]>|any; 
  selectedQualifi: any = [];
  selectedSpl: any = [];
  selectedSSI: any = [];
  selectedDIT: any = [];
  selectedTI: any = [];
  qulfyCtrl = new FormControl('');
  spCtrl = new FormControl('');
  ssiCtrl = new FormControl('');
  ditCtrl = new FormControl('');
  tiCtrl = new FormControl('');
  @ViewChild('qulfyInput') qulfyInput: ElementRef<HTMLInputElement> | any;
  @ViewChild('splInput') splInput: ElementRef<HTMLInputElement> | any;
  @ViewChild('ssiInput') ssiInput: ElementRef<HTMLInputElement> | any;
  @ViewChild('ditInput') ditInput: ElementRef<HTMLInputElement> | any;
  @ViewChild('tiInput') tiInput: ElementRef<HTMLInputElement> | any;
  separatorKeysCodes: number[] = [ENTER, COMMA];

  add(event: any, type:any): void {
    let value:any = (event.value || '').trim();  
    if(type == 'qualification'){
      if (value) {
        if(typeof value == 'string'){
          value = { id: value, degree : value, type: ''};
        } 
        this.selectedQualifi.push(value);
      } 
      // Clear the input value
      event.chipInput!.clear(); 
      this.qulfyCtrl.setValue(null);
    }else if(type == 'speciality'){
      if (value) {
        if(typeof value == 'string'){
          value = { id: value, speciality_name : value};
        } 
        this.selectedSpl.push(value);
      }  
      event.chipInput!.clear(); 
      this.spCtrl.setValue(null);
    }else if(type == 'ssi'){
      if (value) {
        if(typeof value == 'string'){
          value = { id: value, title : value};
        } 
        this.selectedSSI.push(value);
      }  
      event.chipInput!.clear(); 
      this.ssiCtrl.setValue(null);
    }else if(type == 'dit'){
      if (value) {
        if(typeof value == 'string'){
          value = { id: value, title : value};
        } 
        this.selectedDIT.push(value);
      }  
      event.chipInput!.clear(); 
      this.ditCtrl.setValue(null);
    }else if(type == 'ti'){
      if (value) {
        if(typeof value == 'string'){
          value = { id: value, title : value};
        } 
        this.selectedTI.push(value);
      }  
      event.chipInput!.clear(); 
      this.tiCtrl.setValue(null);
    }
    
  }
  
  remove(searchValue: string, type:any): void {
    if(type == 'qualification'){
      const index = this.selectedQualifi.indexOf(searchValue); 
      if (index >= 0) {
        this.selectedQualifi.splice(index, 1);
      }
    }else if(type == 'speciality'){
      const index = this.selectedSpl.indexOf(searchValue); 
      if (index >= 0) {
        this.selectedSpl.splice(index, 1);
      }
    }else if(type == 'ssi'){
      const index = this.selectedSSI.indexOf(searchValue); 
      if (index >= 0) {
        this.selectedSSI.splice(index, 1);
      }
    }else if(type == 'dit'){
      const index = this.selectedDIT.indexOf(searchValue); 
      if (index >= 0) {
        this.selectedDIT.splice(index, 1);
      }
    }else if(type == 'ti'){
      const index = this.selectedTI.indexOf(searchValue); 
      if (index >= 0) {
        this.selectedTI.splice(index, 1);
      }
    }

  }
  
  selected(event: any, type:any): void {  
    if(type == 'qualification'){
      this.selectedQualifi.push(event.option.value);
      this.qulfyInput.nativeElement.value = '';
      this.qulfyCtrl.setValue('');
      var specializationArray = this.selectedQualifi.map(function (obj:any) { return obj.id; }); 
      this.changeSpecialization(specializationArray);
    }
    else if(type == 'speciality'){
      this.selectedSpl.push(event.option.value);
      this.splInput.nativeElement.value = '';
      this.spCtrl.setValue(''); 
    }
    else if(type == 'ssi'){
      this.selectedSSI.push(event.option.value);
      this.ssiInput.nativeElement.value = '';
      this.ssiCtrl.setValue(''); 
    }else if(type == 'dit'){
      this.selectedDIT.push(event.option.value);
      this.ditInput.nativeElement.value = '';
      this.ditCtrl.setValue(''); 
    }else if(type == 'ti'){
      this.selectedTI.push(event.option.value);
      this.tiInput.nativeElement.value = '';
      this.tiCtrl.setValue(''); 
    }
  }
 
 
  get f1(): { [key: string]: AbstractControl } {
    return this.setupForm.controls;
  }
  get f2(): { [key: string]: AbstractControl } {
    return this.sForm.controls;
  }
  get f3(): { [key: string]: AbstractControl } {
    return this.aForm.controls;
  }
  get f4(): { [key: string]: AbstractControl } {
    return this.bForm.controls;
  }
  matStep(step: any) {
    this.stepExpn = step;
  }
  openAddressPopup(modalName: any, type:any = '') {
    this.address_type = type;
    this.modalService.open(modalName, {
      centered: true,
      size: 'lg',
      backdropClass: 'light-blue-backdrop',
    });
  }
  getSpecialities(specialization_id: any = ''): void {
    specialization_id = '';
    this.ApiService.getSpecialities('', specialization_id).subscribe(
      (data) => {
        if (data.status) {
          this.sList = data.data;
          let parshedSpzid = JSON.parse(this.docInfo.specialities_id)
          this.selectedSpl = this.sList.filter((op1:any) => (parshedSpzid.some((op2:any) => op1.id === op2))); 
        } else {
          this.toaster.open({
            text: data.message,
            caption: 'Error',
            duration: 4000,
            type: 'danger',
          });
        }
      },
      (err: any) => {}
    );
  }
  changeSpecialization(value: any) {
    //this.getSpecialities(value);
    this.refreshQfy(value);
  }
  refreshQfy(value: any = '') { 
    let result: any;
    if (value == '') {
      value = this.docInfo.specialization_id.replace('[', '').replace(']', '');
      value = value.split(',');
      result = value.map(function (x: any) {
        return parseInt(x, 10);
      });
      this.selectedQualifi = this.spz_list.filter((op1:any) => (result.some((op2:any) => op1.id === op2)));  
    } else {
      result = value;
    }
    if(typeof result == 'string'){
      result = result?.split(',');
    }
    this.qList = [];
    this.spz_list.forEach((element: any) => {
      let id = element.id;
      if (result.includes(id)) {
        element.link = '';
        this.eduList.forEach((e: any) => {
          if (e?.qualification_id == id) {
            element.link = e.certificate;
          }
        });
        this.qList.push(element);
      }
    });
  }
  private _filterDesig(value: string): string[] { 
    if(value == ''){ return [];}
    const filterValue = value.toLowerCase(); 
    return this.designation.filter((option:any) => option.title?.toLowerCase().includes(filterValue.toLowerCase()));
  }
  private _filterMedi(value: string): string[] { 
    if(value == ''){ return [];}
    const filterValue = value.toLowerCase(); 
    return this.medical_counsiling.filter((option:any) => option.title?.toLowerCase().includes(filterValue.toLowerCase()));
  }
  private _filterQulfy(value: any): string[] {  
    if(value == '' || (typeof value != 'string' && !(value instanceof String))){ return [];} 
    const filterValue = value.toLowerCase();  
    const results = this.spz_list.filter((op1:any) => (!this.selectedQualifi.some((op2:any) => op1.id === op2.id))); 
    
    return results.filter((option:any) => option.degree?.toLowerCase().includes(filterValue.toLowerCase()));
  }
  private _filterSp(value: any): string[] {  
    if(value == '' || (typeof value != 'string' && !(value instanceof String))){ return [];} 
    const filterValue = value.toLowerCase();   
    
    const results = this.sList.filter((op1:any) => (!this.selectedSpl.some((op2:any) => op1.id === op2.id))); 
    
    return results.filter((option:any) => option.speciality_name?.toLowerCase().includes(filterValue.toLowerCase()));
  }
  private _filterSSI(value: any): string[] {  
    if(value == '' || (typeof value != 'string' && !(value instanceof String))){ return [];} 
    const filterValue = value.toLowerCase();    
    const results = this.symptomList.filter((op1:any) => (!this.selectedSSI.some((op2:any) => op1.id === op2.id)));  
    return results.filter((option:any) => option.title?.toLowerCase().includes(filterValue.toLowerCase()));
  }
  private _filterDIT(value: any): string[] {  
    if(value == '' || (typeof value != 'string' && !(value instanceof String))){ return [];} 
    const filterValue = value.toLowerCase();    
    const results = this.deasiesList.filter((op1:any) => (!this.selectedDIT.some((op2:any) => op1.id === op2.id)));  
    return results.filter((option:any) => option.title?.toLowerCase().includes(filterValue.toLowerCase()));
  }
  private _filterTI(value: any): string[] {  
    if(value == '' || (typeof value != 'string' && !(value instanceof String))){ return [];} 
    const filterValue = value.toLowerCase();    
    const results = this.treatmentList.filter((op1:any) => (!this.selectedTI.some((op2:any) => op1.id === op2.id)));  
    return results.filter((option:any) => option.title?.toLowerCase().includes(filterValue.toLowerCase()));
  }
  getDesignation(): void {
    this.ApiService.getDesignation('').subscribe(
      (data) => {
        if (data.status) {
          this.designation = data.data; 
        } else {
          this.toaster.open({
            text: data.message,
            caption: 'Error',
            duration: 4000,
            type: 'danger',
          });
        }
      },
      (err: any) => {}
    );
  }
  getMedicalCounsiling(): void {
    this.ApiService.getMedicalCounsiling('').subscribe(
      (data) => {
        if (data.status) {
          this.medical_counsiling = data.data; 
        } else {
          this.toaster.open({
            text: data.message,
            caption: 'Error',
            duration: 4000,
            type: 'danger',
          });
        }
      },
      (err: any) => {}
    );
  }
  getSpecialization(): void {
    this.ApiService.getSpecialization('').subscribe(
      (data) => {
        if (data.status) {
          this.spz_list = data.data;
          this.refreshQfy();
        } else {
          this.toaster.open({
            text: data.message,
            caption: 'Error',
            duration: 4000,
            type: 'danger',
          });
        }
      },
      (err: any) => {}
    );
  }
  getDocWFieldList(): void {
    this.ApiService.getDocWFieldList().subscribe(
      (data) => {
        if (data.status) {
          
          this.symptomList = data.data.symptomList;
          this.deasiesList = data.data.deasiesList;
          this.treatmentList = data.data.treatmentList;
          console.log(this.docInfo);
          
          let parshedSSI:any = [];
          if(this.docInfo.symptom_i_see != ''){
            parshedSSI = JSON.parse(this.docInfo.symptom_i_see)
          } 
          this.selectedSSI = this.symptomList.filter((op1:any) => (parshedSSI.some((op2:any) => op1.id === op2))); 

          let parshedDIT:any = [];
          if(this.docInfo.deasies_i_treat != ''){
            parshedDIT = JSON.parse(this.docInfo.deasies_i_treat)
          } 
          this.selectedDIT = this.deasiesList.filter((op1:any) => (parshedDIT.some((op2:any) => op1.id === op2))); 

          let parshedTI:any = [];
          if(this.docInfo.treatment_and_surgery != ''){
            parshedTI = JSON.parse(this.docInfo.treatment_and_surgery)
          } 
          this.selectedTI = this.treatmentList.filter((op1:any) => (parshedTI.some((op2:any) => op1.id === op2))); 
        } else {
          this.toaster.open({
            text: data.message,
            caption: 'Error',
            duration: 4000,
            type: 'danger',
          });
        }
      },
      (err: any) => {}
    );
  }
  onFileChange(e: any, name: any): void {
    const reader = new FileReader();

    if (e.target.files && e.target.files.length) {
      const file = e.target.files[0];
      reader.readAsDataURL(file);

      reader.onload = () => {
        if (name == 'degree_file') {
          this.setupForm.patchValue({
            degree_file: reader.result,
          });
        } else if (name == 'l_h_image') {
          this.setupForm.patchValue({
            l_h_image: reader.result,
          });
        } else if (name == 'l_h_sign') {
          this.setupForm.patchValue({
            l_h_sign: reader.result,
          });
        } else if (name == 'doctor_image') {
          this.setupForm.patchValue({
            doctor_image: reader.result,
          });
        } else if (name == 'doctor_banner') {
          this.setupForm.patchValue({
            doctor_banner: reader.result,
          });
        } else if (name == 'registration_certificate') {
          this.setupForm.patchValue({
            registration_certificate: reader.result,
          });
        } else if (name == 'letterhead') {
          this.setupForm.patchValue({
            letterhead: reader.result,
          });
        } else if (name == 'signature') {
          this.setupForm.patchValue({
            signature: reader.result,
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
  onQChange(e: any, qid: any): void {
    const reader = new FileReader();

    if (e.target.files && e.target.files.length) {
      const file = e.target.files[0];
      reader.readAsDataURL(file);

      reader.onload = () => {
        this.eForm.patchValue({
          certificate: reader.result,
        });
        this.eForm.patchValue({
          qualification_id: qid,
        });

        this.onSubmiEdu();
      };
    }
  }
  getDocInfo(): void {
    this.spinner.show();
    this.ApiService.getDocInfo().subscribe(
      (data) => {
        if (data.status) {
          this.docInfo = data.data.data; 
          if(this.addressChanged){ 
            this.addressChanged = false;
            this.spinner.hide();
            return;
          }
          this.bankDetails = data.data.doctor_bank_docs;
          this.eduList = data.data.Doctor_edu;
          this.setupForm.controls['full_name'].setValue(this.docInfo.full_name);
          this.setupForm.controls['gender'].setValue(this.docInfo.gender);
          this.sForm.controls['specialization_id'].setValue(
            JSON.parse(this.docInfo.specialization_id)
          );

          let parshedSpzid = JSON.parse(this.docInfo.specialities_id);
          this.sForm.controls['specialities_id'].setValue(parshedSpzid); 

          if (this.docInfo.symptom_i_see != '') {
            this.sForm.controls['symptom_i_see'].setValue(
              JSON.parse(this.docInfo.symptom_i_see)
            );
          }
          if (this.docInfo.deasies_i_treat != '') {
            this.sForm.controls['deasies_i_treat'].setValue(
              JSON.parse(this.docInfo.deasies_i_treat)
            );
          }
          if (this.docInfo.treatment_and_surgery != '') {
            this.sForm.controls['treatment_and_surgery'].setValue(
              JSON.parse(this.docInfo.treatment_and_surgery)
            );
          }
          if (
            this.docInfo.specialization_id != '' &&
            this.docInfo.specialization_id != null
          ) {
            this.changeSpecialization(
              this.docInfo.specialization_id.replace('[', '').replace(']', '')
            );
          }

          if (this.docInfo.working_days != '') {
          }
          this.setupForm.controls['working_days'].setValue(
            JSON.parse(this.docInfo.working_days)
          );

          if (this.docInfo.home_visit == '') {
            this.docInfo.home_visit = 'No';
          }
          if (this.docInfo.consultancy_fee == '') {
            this.docInfo.consultancy_fee = 0;
          }
          if (this.docInfo.home_consultancy_fee == '') {
            this.docInfo.home_consultancy_fee = 0;
          }
          if (this.docInfo.online_consultancy_fee == '') {
            this.docInfo.online_consultancy_fee = 0;
          }
          this.setupForm.controls['home_visit'].setValue(
            this.docInfo.home_visit
          );
          this.setupForm.controls['consultancy_fee'].setValue(
            this.docInfo.consultancy_fee
          );
          this.setupForm.controls['home_consultancy_fee'].setValue(
            this.docInfo.home_consultancy_fee
          );
          this.setupForm.controls['online_consultancy_fee'].setValue(
            this.docInfo.online_consultancy_fee
          );
          this.setupForm.controls['designation'].setValue(
            this.docInfo.designation
          );
          this.setupForm.controls['about'].setValue(this.docInfo.about);
          this.setupForm.controls['experience'].setValue(
            this.docInfo.experience
          );
          
          this.setupForm.controls['registration_details'].setValue(
            this.docInfo.registration_details
          );
          this.setupForm.controls['medical_counsiling'].setValue(
            this.docInfo.medical_counsiling
          );

          this.aForm.controls['award'].setValue(this.docInfo.award);
          this.aForm.controls['memberships_detail'].setValue(
            this.docInfo.memberships_detail
          );

          this.bForm.controls['name'].setValue(this.bankDetails?.name);
          this.bForm.controls['bank_name'].setValue(
            this.bankDetails?.bank_name
          );
          this.bForm.controls['branch_name'].setValue(
            this.bankDetails?.branch_name
          );
          this.bForm.controls['ifsc'].setValue(this.bankDetails?.ifsc);
          this.bForm.controls['ac_no'].setValue(this.bankDetails?.ac_no);
          this.bForm.controls['ac_type'].setValue(this.bankDetails?.ac_type);
          this.bForm.controls['micr_code'].setValue(
            this.bankDetails?.micr_code
          );
          this.bForm.controls['pan_no'].setValue(this.bankDetails?.pan_no);
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
        this.getSpecialization();
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
    this.ApiService.updateDocSetupInfo(
      this.setupForm.value,
      this.myInfo.user_id
    ).subscribe(
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
          this.getDocInfo();
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
  onSubmitSS(): void {
    this.b2 = true;
    var specializationArray = this.selectedQualifi.map(function (obj:any) { return obj.id; }); 
    var specialitiesArray = this.selectedSpl.map(function (obj:any) { return obj.id; }); 
    var SSIArray = this.selectedSSI.map(function (obj:any) { return obj.id; }); 
    var DITArray = this.selectedDIT.map(function (obj:any) { return obj.id; }); 
    var TIArray = this.selectedTI.map(function (obj:any) { return obj.id; }); 
    console.log(DITArray);
    this.sForm.controls['specialities_id'].setValue(specialitiesArray);
    this.sForm.controls['specialization_id'].setValue(specializationArray);
    this.sForm.controls['symptom_i_see'].setValue(SSIArray);
    this.sForm.controls['deasies_i_treat'].setValue(DITArray);
    this.sForm.controls['treatment_and_surgery'].setValue(TIArray);
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
    this.ApiService.updateDocSetupInfoSS(this.sForm.value).subscribe(
      (data) => {
        if (data.status) {
          this.toaster.open({
            text: data.message,
            caption: 'Success',
            duration: 4000,
            type: 'success',
          });
          this.b2 = false;
          this.spinner.hide();
          this.getDocInfo();
          this.matStep(3);
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
  onSubmitAward(): void {
    this.b3 = true;

    if (this.aForm.invalid) {
      this.toaster.open({
        text: 'Fill all required fields',
        caption: 'Message',
        duration: 4000,
        type: 'danger',
      });
      return;
    }
    this.spinner.show();
    this.ApiService.updateDocSetupInfoAward(this.aForm.value).subscribe(
      (data) => {
        if (data.status) {
          this.toaster.open({
            text: data.message,
            caption: 'Success',
            duration: 4000,
            type: 'success',
          });
          this.b3 = false;
          this.spinner.hide();
          this.getDocInfo();
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
    this.ApiService.updateDocSetupInfoBank(this.bForm.value).subscribe(
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
          this.getDocInfo();
          window.scrollTo(0, 0);
          this.matStep(5);
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

  onSubmiEdu(): void {
    this.b5 = true;

    if (this.eForm.invalid) {
      this.toaster.open({
        text: 'Fill all required fields',
        caption: 'Message',
        duration: 4000,
        type: 'danger',
      });
      return;
    }
    this.spinner.show();
    this.ApiService.updateDocInfoForSetupEdu(this.eForm.value).subscribe(
      (data) => {
        if (data.status) {
          console.log('Q DOC UPDATED');

          this.b5 = false;
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
