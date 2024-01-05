import { Component, OnInit, OnDestroy, QueryList, ViewChild, ElementRef } from '@angular/core';
import { TokenStorageService } from '../../../services/Token/token-storage.service';
import { ApiService } from '../../../services/Api/api.service';
import { Toaster } from 'ngx-toast-notifications';
import { Router, ActivatedRoute } from '@angular/router';
import { environment } from '../../../../environments/environment';
import { NgxSpinnerService } from 'ngx-spinner';
import { NgbModal } from '@ng-bootstrap/ng-bootstrap';
import InlineEditor from '@ckeditor/ckeditor5-build-inline';
import {COMMA, ENTER} from '@angular/cdk/keycodes';
import { map, Observable, startWith } from 'rxjs';
import {
  AbstractControl,
  FormBuilder,
  FormGroup,
  Validators,
  FormArray,
  FormControl,
} from '@angular/forms';
@Component({
  selector: 'app-user-chat',
  templateUrl: './user-chat.component.html',
  styleUrls: ['./user-chat.component.scss']
})
export class UserChatComponent implements OnInit, OnDestroy {

  constructor(
    private tokenStorage: TokenStorageService,
    private ApiService: ApiService,
    private modalService: NgbModal,
    private _Activatedroute: ActivatedRoute,
    private router: Router,
    private formBuilder: FormBuilder,
    private spinner: NgxSpinnerService,
    private toaster: Toaster
  ) {
    this.isLoggedIn = !!this.tokenStorage.getToken();
    if (this.isLoggedIn) {
      this.myInfo = this.tokenStorage.getUser();
      console.log(this.myInfo); 
    } else {
      this.router.navigate(['/login']);
    }
    this.activeApnId = this._Activatedroute.snapshot.queryParams["aid"]; 
    if(this.activeApnId){
      this.tokenStorage.setSession('activeApnId',this.activeApnId);
    }else{
      this.activeApnId = this.tokenStorage.getSession('activeApnId');
    }
    console.log('this.activeApnId ',this.activeApnId );
    
  }
  editor: any = InlineEditor;
  @ViewChild('myEditor') myEditor: QueryList<any> | any;
  ckconfig: any;
  BACK_END_MAPPING_URL_FOR_SAVE_IMG: string =
    environment.base_url + 'temp-image';
    fmList: any = [];
  editInfo : boolean = false;
  isLoggedIn: boolean = false;
  vPage: any = 'chat';
  reportMsg: any = '';
  fv: any = [];
  fvpage : any = 'list';
  pdList: any = [];
  myInfo: any = [];
  apnList: any = [];
  activeApn :any = [];
  messageList :any = [];
  message:any = '';
  activeApnId:any = '';
  interval: any;
  cmtList: any = [];
  medList: any = [];
  searchProduct: any = [];
 
  b2: boolean = false;
  cb: boolean = false; 
  fForm: any = [];
  cForm: any = []; 
  docInfo: any = []; 
  get f2(): { [key: string]: AbstractControl } {
    return this.fForm.controls;
  }
  get c2(): { [key: string]: AbstractControl } {
    return this.cForm.controls;
  }
 
  ngOnInit(): void {
    this.getAppointment();
    this.getDiagnosisList();
    
    this.interval = setInterval(() => {
      if(this.activeApn?.id){
        this.getMessage(this.activeApn?.id);
      } 
    }, 5000);

    this.fForm = this.formBuilder.group({
      id: [''],
      name: ['', Validators.required],
      dob: ['', Validators.required],
      gender: ['', Validators.required],
      p_reports: [''],
      id_proof: [''],
      is_consent: [''],
      c_relationship: [''],
      c_relationship_proof: [''],
      consent_with_proof: [''],
      current_complaints_w_t_duration: [''],
      marital_status: [''],
      religion: [''],
      occupation: [''],
      dietary_habits: [''],
      last_menstrual_period: [''],
      previous_pregnancy_abortion: [''],
      vaccination_in_children: [''],
      residence: [''],
      height: [''],
      weight: [''],
      pulse: [''],
      b_p: [''],
      temprature: [''],
      blood_suger_fasting: [''],
      blood_suger_random: [''],
      history_of_previous_diseases: [''],
      history_of_allergies: [''],
      history_of_previous_surgeries_or_procedures: [''],
      significant_family_history: [''],
      history_of_substance_abuse: [''],
    });
    this.cForm = this.formBuilder.group({
      id: [''],
      relevent_point_from_history: [''],
      provisional_diagnosis: [''],
      investigation_suggested: [''],
      treatment_suggested: [''],
      special_instruction: [''],
      followup_advice: [''],
      prescription_reports: [''],
      medical_advice: this.formBuilder.array([])
    });
    this.addNewMG();
     
    let qfyUniq = this.pdList.filter((op1:any) => (!this.selectedInves.some((op2:any) => op1.id === op2.id))); 
    this.filteredInves = this.invsCtrl.valueChanges.pipe(
      startWith(''),
      map((value:any) => value ? this._filterInves(value || '') : qfyUniq.slice(0,10)),
    );

    this.getPharmacyFormulation();
  }
  getPharmacyFormulation(): void {
    this.ApiService.getPharmacyFormulation().subscribe(
      (data) => {
        if (data.status) {
          this.fmList = data.data;
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
  updateProduct(p:any,index:any){
    const add:any = this.cForm.get('medical_advice') as FormArray;
    add.at(index).get('name').setValue(p.title); 
    if(!p.strength || p.strength == 'null'){
      p.strength = '';
    }
    add.at(index).get('strength').setValue(p.strength);
    this.searchProduct[index] = [];
    this.searchProduct = this.searchProduct.map((d:any) => []);
  }
  changeName(e:any, index:any){ 
    this.ApiService.searchPharmacyProduct(e.target.value).subscribe(
      (data) => {
        if (data.status) {
          this.searchProduct[index] = data.data;
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
  addNewMG() {
    const add = this.cForm.get('medical_advice') as FormArray;
    add.push(this.formBuilder.group({
      formulation: [''],
      name: [''],
      strength: [''],
      route_of_administration: [''],
      frequncy: [''],
      duration: [''],
      special_instruction: ['']
    }))
  } 
  deleteMG(index: number) {
    const add = this.cForm.get('medical_advice') as FormArray;
    add.removeAt(index)
  }
  viewP(data:any){
    this.fvpage = 'view';
    this.fv = data;
    if(!this.fv.treatment_suggested){
      setTimeout(() => {
        const btn = document.getElementById('vpr') as HTMLElement;
        btn.click();
      }, 500);
    }
    this.medList = [];
    this.getApnMedicien(data.id);
  }
  filteredInves: Observable<string[]>|any; 
  selectedInves: any = [];
  invsCtrl = new FormControl(''); 
  @ViewChild('invsInput') invsInput: ElementRef<HTMLInputElement> | any;
  separatorKeysCodes: number[] = [ENTER, COMMA];
  private _filterInves(value: any): string[] {  
    if(value == '' || (typeof value != 'string' && !(value instanceof String))){ return [];} 
    const filterValue = value.toLowerCase();  
    const results = this.pdList.filter((op1:any) => (!this.selectedInves.some((op2:any) => op1.id === op2.id))); 
    
    return results.filter((option:any) => option.title?.toLowerCase().includes(filterValue.toLowerCase()));
  }
  add(event: any, type:any = ''): void {
    let value:any = (event.value || '').trim();  
    if (value) {
      if(typeof value == 'string'){
        value = { id: value, title : value};
      } 
      this.selectedInves.push(value);
    }  
    event.chipInput!.clear(); 
    this.invsCtrl.setValue(null);
  }
  
  remove(searchValue: string, type:any): void { 
      const index = this.selectedInves.indexOf(searchValue); 
      if (index >= 0) {
        this.selectedInves.splice(index, 1);
      } 
  }
  
  selected(event: any, type:any): void { 
      this.selectedInves.push(event.option.value);
      this.invsInput.nativeElement.value = '';
      this.invsCtrl.setValue('');
      //var specializationArray = this.selectedInves.map(function (obj:any) { return obj.id; }); 
  }
  getFamilyPatient(id:any): void {
    this.ApiService.getFamilyPatient(id).subscribe(
      (data) => {
        if (data.status) { 
          delete data.data.id;
          delete data.data.p_reports;
          delete data.data.id_proof;
          delete data.data.c_relationship_proof;
          delete data.data.consent_with_proof;
          this.activeApn = {...data.data};
          console.log(this.activeApn);
          
          this.fForm.patchValue(this.activeApn)
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
  getDiagnosisList(id:any = ''): void {
    this.ApiService.getDiagnosisList().subscribe(
      (data) => {
        if (data.status) {   
            this.pdList = data.data; 
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
  getApnComment(id:any = ''): void {
    this.ApiService.getApnComment(this.activeApnId,id).subscribe(
      (data) => {
        if (data.status) {  
          if(id == ''){
            this.cmtList = data.data;
          }else{
            this.cForm.patchValue(data.data)
          } 
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
  submitPrsForm(): void { 
    this.cb = true; 
    if (this.cForm.value.prescription_reports == '') {
      this.toaster.open({
        text: 'Fill select file',
        caption: 'Success',
        duration: 4000,
        type: 'success',
      });
      return;
    }
    this.spinner.show();
    this.ApiService.submitPrsForm(this.activeApnId,this.cForm.value).subscribe(
      (data) => {
        if (data.status) {  
          this.toaster.open({
            text: data.message,
            caption: 'Success',
            duration: 4000,
            type: 'success',
          });
          this.vPage = 'prh';
          this.cForm.reset();
          this.spinner.hide();
          this.getApnComment();
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
  submitApnComment(): void { 
    this.cb = true;
    //this.form.controls['slug'].setValue(this.slug);
    var specializationArray = this.selectedInves.map(function (obj:any) { return obj.id; }); 
    this.cForm.controls['investigation_suggested'].setValue(specializationArray);
    if (this.cForm.invalid) {
      this.toaster.open({
        text: 'Fill required field',
        caption: 'Success',
        duration: 4000,
        type: 'success',
      });
      return;
    }
    this.spinner.show();
    this.ApiService.submitApnComment(this.activeApnId,this.cForm.value).subscribe(
      (data) => {
        if (data.status) {  
          this.toaster.open({
            text: data.message,
            caption: 'Success',
            duration: 4000,
            type: 'success',
          });
          this.vPage = 'prh';
          this.cForm.reset();
          this.spinner.hide();
          this.getApnComment();
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
        this.getApnComment();
      }
    );
  }
   
  getApnMedicien(mid:any = ''): void {
    this.ApiService.getApnMedicien(this.activeApnId,mid).subscribe(
      (data) => {
        if (data.status) {  
            this.medList = data.data;
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
   

  onSubmitFM(): void {
    this.b2 = true;
    //this.form.controls['slug'].setValue(this.slug);
    if (this.fForm.invalid) {
      this.toaster.open({
        text: 'Fill required field',
        caption: 'Success',
        duration: 4000,
        type: 'success',
      });
      return;
    }
    this.spinner.show();
    this.ApiService.addFamilyMember(this.fForm.value).subscribe(
      (data) => {
        if (data.status) {
          this.toaster.open({
            text: data.message,
            caption: 'Success',
            duration: 4000,
            type: 'success',
          });
          this.getFamilyPatient(this.fForm.value.id);
          this.editInfo = false;
          this.fForm.reset();
        } else {
          this.toaster.open({
            text: data.message,
            caption: 'Error',
            duration: 4000,
            type: 'danger',
          });
        }
        this.spinner.hide();
        this.b2 = false;
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
  ngOnDestroy(): void {
    if (this.interval) {
      clearInterval(this.interval);
      console.log('interval cleared'); 
   }
  }
  openMeeting(data:any):any{
    //this.router.navigate(['/meeting/',data.message,data.appointment_id,{ queryParams: {mid: data.id, sType: data.sender_type}}]);
    const url = this.router.serializeUrl(this.router.createUrlTree(['/meeting/',data.message,data.appointment_id,data.id], { queryParams:{mid: data.id, sType: data.sender_type} }));
    window.open(url, '_blank');
  }
  startVideo():any{
    this.spinner.show();
    this.ApiService.createVideoLink(this.activeApn?.id).subscribe(
      (data) => {
        if (data.status) {
          if(data.data.iscreated){ 
            this.messageList.push(data.data);
            this.scrollBtm();
          }else{
            window.open(environment.zoom_login, '_blank');
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
  pagechange(page: any) {
    this.vPage = page; 
    this.fvpage = 'list';
  }
  viewMember(modalName: any) {
    this.modalService.open(modalName, {
      centered: true,
      size: 'md',
      backdropClass: 'light-blue-backdrop',
    });
  }
  reportModelAction(modalName: any) {
    this.modalService.open(modalName, {
      centered: true,
      size: 'md',
      backdropClass: 'light-blue-backdrop',
    });
  }

  submitReport():void{
    if(this.activeApn?.id == ''){
      this.toaster.open({
        text: 'Select appointment first',
        caption: 'Message',
        duration: 4000,
        type: 'danger',
      });
    }
    if(this.reportMsg == ''){
      this.toaster.open({
        text: 'Enter your message first',
        caption: 'Message',
        duration: 4000,
        type: 'danger',
      });
    }

    this.ApiService.reportApn(this.activeApn?.id, this.reportMsg ).subscribe(
      (data) => {
        if (data.status) {
          this.toaster.open({
            text: data.message,
            caption: 'Success',
            duration: 4000,
            type: 'success',
          });
          this.modalService.dismissAll();
        } else {
          this.toaster.open({
            text: data.message,
            caption: 'Message',
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
  getDocInfo(id:any = ''): void {
    this.ApiService.getDocInfo(id).subscribe(
      (data) => {
        if (data.status) {
          this.docInfo = data.data.data; 
          console.log(this.docInfo);
           
        } else {
          this.docInfo = [];
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
  selectApn(data:any){  
    this.messageList = [];
    this.activeApn = {...data};
    console.log(this.activeApn);
    
    let d = {...data};
    
    d.id = this.activeApn.fm_id;
    delete d.p_reports;
    delete d.id_proof;
    delete d.c_relationship_proof;
    delete d.consent_with_proof;
    this.fForm.patchValue(d);
    this.activeApnId = this.activeApn?.id;
    this.getMessage(this.activeApn?.id);
    this.getApnComment(); 
    this.getDocInfo(d.doctor_id);
  }
  getAppointment(): void {
    this.spinner.show();
    this.ApiService.getAppointment(this.activeApnId).subscribe(
      (data) => {
        if (data.status) {
          let d = this.apnList = data.data; 
          if(this.activeApnId != '' && this.activeApnId != null){
            this.apnList.forEach((e:any) => {
              if(e.id == this.activeApnId){
                this.selectApn(e);
              }
            });
          }else{
            try{
              this.selectApn(this.apnList[0]);
            }catch(e){
              console.log(e);
            }
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
  scrollBtm(){
    if(this.vPage == 'chat'){
      setTimeout(() => {
        var objDiv = document.getElementById("chat-box") as any;
        objDiv.scrollTop = objDiv.scrollHeight;
      }, 100); 
    } 
  }
  calculateAge(dateString:any){
    var today = new Date();
    var birthDate = new Date(dateString);
    var age = today.getFullYear() - birthDate.getFullYear();
    var m = today.getMonth() - birthDate.getMonth();
    if (m < 0 || (m === 0 && today.getDate() < birthDate.getDate())) {
        age--;
    }
    return age;
  }
  getMessage(id:any = ''):any{ 
    if(id == ''){
      return;
    }
    
    this.ApiService.getMessage(id).subscribe(
      (data) => {
        if (data.status) {
          this.messageList = data.data;
          this.scrollBtm();
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
  sendMessage():any{
    if(this.message == ''){ return null;}
    const msg = this.message; 
    this.message = '';
    this.ApiService.sendMessage(this.activeApn?.id, msg,'message').subscribe(
      (data) => {
        if (data.status) {
          this.messageList.push(data.data);
          this.scrollBtm();
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
  onFileChange(e: any, name: any): void {
    const reader = new FileReader();

    if (e.target.files && e.target.files.length) {
      const file = e.target.files[0];
      reader.readAsDataURL(file);

      reader.onload = () => {
        if (name == 'p_reports') {
          this.fForm.patchValue({
            p_reports: reader.result,
          });
        } else if (name == 'id_proof') {
          this.fForm.patchValue({
            id_proof: reader.result,
          });
        } else if (name == 'c_relationship_proof') {
          this.fForm.patchValue({
            c_relationship_proof: reader.result,
          });
        } else if (name == 'consent_with_proof') {
          this.fForm.patchValue({
            consent_with_proof: reader.result,
          });
        } else if (name == 'prescription_reports') {
          this.cForm.patchValue({
            prescription_reports: reader.result,
          });
        }  
      };
    }
  }
  

}
