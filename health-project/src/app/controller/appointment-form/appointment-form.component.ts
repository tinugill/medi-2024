import { Component, OnInit } from '@angular/core';
import { ActivatedRoute, Router, Params } from '@angular/router';
import { TokenStorageService } from '../../services/Token/token-storage.service'; 
import { PayServiceService } from '../../services/Payment/pay-service.service';
import { ApiService } from '../../services/Api/api.service';
import { Toaster } from 'ngx-toast-notifications';
import { NgbModal } from '@ng-bootstrap/ng-bootstrap';
import { AuthService } from '../../services/Auth/auth.service';
import { NgxSpinnerService } from 'ngx-spinner';
import {
  AbstractControl,
  FormBuilder,
  FormGroup,
  Validators,
  FormArray,
} from '@angular/forms';
@Component({
  selector: 'app-appointment-form',
  templateUrl: './appointment-form.component.html',
  styleUrls: ['./appointment-form.component.scss'],
})
export class AppointmentFormComponent implements OnInit {
  slideConfig = {
    slidesToShow: 4,
    slidesToScroll: 1,
    dots: false,
    autoplay: false,
    infinite: false,
    arrows: true,
    responsive: [
      {
        breakpoint: 1024,
        settings: {
          slidesToShow: 4,
          slidesToScroll: 1,
          infinite: true,
          dots: false,
        },
      },
      {
        breakpoint: 600,
        settings: {
          slidesToShow: 3,
          slidesToScroll: 1,
        },
      },
      {
        breakpoint: 480,
        settings: {
          slidesToShow: 2,
          slidesToScroll: 1,
          dots: false,
          autoplay: false,
          arrows: true,
        },
      },
    ],
  };
  constructor(
    private tokenStorage: TokenStorageService,
    private ApiService: ApiService,
    private _Activatedroute: ActivatedRoute,
    private modalService: NgbModal,
    private toaster: Toaster,
    private router: Router,
    private formBuilder: FormBuilder,
    private spinner: NgxSpinnerService,
    private rzp: PayServiceService
  ) {
     
  }

  ngOnInit(): void {
    this.isLoggedIn = !!this.tokenStorage.getToken();
    if (this.isLoggedIn) {
      this.myInfo = this.tokenStorage.getUser(); 
      
    }else{
      this.router.navigate(['/login']);
      return;
    }
    let bt = this._Activatedroute.snapshot.queryParams["c_type"];
    if(bt != undefined && bt != 'Clinic-Hospital'){
      this.bType = bt;
    }else if(bt == 'Clinic-Hospital'){
      this.bType = 'Clinic/Hospital';
    }
    console.log(this.bType);
    
    this._Activatedroute.paramMap.subscribe((params) => {
      this.slug = params.get('slug'); 
      if (this.slug != '') {
        this.getDoctorInfo(this.slug);
      }
    });
    this.form = this.formBuilder.group({
      member_id: ['', Validators.required],
      date: [''],
      time_slot: [''],
      type: [this.bType],
      slug: [''],
      address: [''],
      locality: [''],
      pincode: [''],
      city: [''],
    });
    this.otpForm = this.formBuilder.group({
      id: ['', Validators.required],
      otp: ['', Validators.required],
      type: ['', Validators.required],
    });
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
    //this.getFamilyPatient();
  }
  isAddMore: boolean = false;
  bType:any = 'Online';
  slug: any = '';
  dInfo: any = [];
  fForm: any = [];
  slotList: any = [];
  slotListH: any = [];
  acIn = 0;
  slotTime = '';

  fList: any = [];

  isLoggedIn: boolean = false;
  myInfo: any = '';
  appointmentId: any = '';

  form: FormGroup | any;
  submitted: boolean = false;
  isFSubmit: boolean = false;
  isOtpSent: boolean = false; 
  b2: boolean = false;
  otpForm: FormGroup | any;

  get f(): { [key: string]: AbstractControl } {
    return this.form.controls;
  }
  get op(): { [key: string]: AbstractControl } {
    return this.otpForm.controls;
  }
  get f2(): { [key: string]: AbstractControl } {
    return this.fForm.controls;
  }
  activeDay(date: any): void { 
    this.acIn = date; 
    let h = this.dInfo.slot_hospital.find((o:any) => o.date == date);
    let c = this.dInfo.slot_clinic.find((o:any) => o.date == date);  

    this.slotListH = h?.slot;
    this.slotList = c?.slot; 
    
  }
  setSlot(time: any): void {
    this.slotTime = time;
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
        }  
      };
    }
  }
 
  getDoctorInfo(slug: any): void {
    this.spinner.show();
    this.ApiService.getDoctorInfo(slug).subscribe(
      (data) => {
        if (data.status) {
          this.dInfo = data.data;
          try {
            if (this.dInfo?.slot_hospital?.length > 0) {
              this.slotListH = this.dInfo.slot_hospital[0]?.slot;
              this.slotTime = this.dInfo.slot_hospital[0]?.slot[0]?.slot;
              this.acIn = this.dInfo.slot_hospital[0]?.date;
            }
            if (this.dInfo?.slot_clinic?.length > 0) {
              this.slotList = this.dInfo.slot_clinic[0]?.slot;
              this.slotTime = this.dInfo.slot_clinic[0]?.slot[0]?.slot;
              this.acIn = this.dInfo.slot_clinic[0]?.date;
            }
          } catch (error) {
            this.toaster.open({
              text: 'Appointments timetable not prepared by doctor ',
              caption: 'Message',
              duration: 4000,
              type: 'danger',
            });
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
  addNewMember(modalName: any) {
    this.modalService.open(modalName, {
      centered: true,
      size: 'md',
      backdropClass: 'light-blue-backdrop',
    });
  }
  editMember(modalName: any, id:any) {
    this.getFamilyPatient(id);
    this.modalService.open(modalName, {
      centered: true,
      size: 'md',
      backdropClass: 'light-blue-backdrop',
    });
  }
  getFamilyPatient(id:any = ''): void {
    this.ApiService.getFamilyPatient(id,'today').subscribe(
      (data) => {
        if (data.status) {
          if(id == ''){
            this.fList = data.data; 
            const length = this.fList?.length;
            if(length > 0){
              this.form.controls['member_id'].setValue(this.fList[length-1].id); 
            }
           
          }else{
            let info = data.data;
            this.fForm.controls['id'].setValue(info.id); 
            this.fForm.controls['name'].setValue(info.name); 
            this.fForm.controls['dob'].setValue(info.dob); 
            this.fForm.controls['gender'].setValue(info.gender); 
            this.fForm.controls['is_consent'].setValue(info.is_consent); 
            this.fForm.controls['c_relationship'].setValue(info.c_relationship); 
            this.fForm.controls['current_complaints_w_t_duration'].setValue(info.current_complaints_w_t_duration); 
            this.fForm.controls['marital_status'].setValue(info.marital_status); 
            this.fForm.controls['religion'].setValue(info.religion); 
            this.fForm.controls['occupation'].setValue(info.occupation); 
            this.fForm.controls['dietary_habits'].setValue(info.dietary_habits); 
            this.fForm.controls['last_menstrual_period'].setValue(info.last_menstrual_period); 
            this.fForm.controls['previous_pregnancy_abortion'].setValue(info.previous_pregnancy_abortion); 
            this.fForm.controls['vaccination_in_children'].setValue(info.vaccination_in_children); 
            this.fForm.controls['residence'].setValue(info.residence); 
            this.fForm.controls['height'].setValue(info.height); 
            this.fForm.controls['weight'].setValue(info.weight); 
            this.fForm.controls['pulse'].setValue(info.pulse); 
            this.fForm.controls['b_p'].setValue(info.b_p); 
            this.fForm.controls['temprature'].setValue(info.temprature); 
            this.fForm.controls['blood_suger_fasting'].setValue(info.blood_suger_fasting); 
            this.fForm.controls['blood_suger_random'].setValue(info.blood_suger_random); 
            this.fForm.controls['history_of_previous_diseases'].setValue(info.history_of_previous_diseases); 
            this.fForm.controls['history_of_allergies'].setValue(info.history_of_allergies); 
            this.fForm.controls['history_of_previous_surgeries_or_procedures'].setValue(info.history_of_previous_surgeries_or_procedures); 
            this.fForm.controls['significant_family_history'].setValue(info.significant_family_history); 
            this.fForm.controls['history_of_substance_abuse'].setValue(info.history_of_substance_abuse);  
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

  onSubmitFM(): void {
    this.b2 = true;
    //this.form.controls['slug'].setValue(this.slug);
    if (this.fForm.invalid) {
      this.toaster.open({
        text: 'Fill required fields and check I give my consent for online consultation',
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
          this.getFamilyPatient();
          this.modalService.dismissAll();
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

  onSubmit(): void {
    this.submitted = true;
    if(this.slotTime == undefined){ this.slotTime = '';}
    this.form.controls['time_slot'].setValue(this.slotTime);
    this.form.controls['date'].setValue(this.acIn);
    this.form.controls['slug'].setValue(this.slug);
    if (this.form.invalid) { 
      
      this.toaster.open({
        text: 'Fill all details and add/select patient details',
        caption: 'Error',
        duration: 4000,
        type: 'danger',
      });
      return;
    }
    if(this.form.value.type == 'Home' && (this.form.value.address == '' || this.form.value.pincode == '' || this.form.value.city == '')){
      this.toaster.open({
        text: 'Fill all address details',
        caption: 'Error',
        duration: 4000,
        type: 'danger',
      });
      return;
    }
    this.spinner.show();
    this.ApiService.bookAppointment(this.form.value).subscribe(
      (data) => {
        if (data.status) {
          this.toaster.open({
            text: 'Loading please wait....',
            caption: 'Success',
            duration: 4000,
            type: 'success',
          });
          this.appointmentId = data.data.id; 
          let amount:any = 0;
          if(this.form.value.type == 'Home'){
            amount = this.dInfo?.home_consultancy_fee;
          }else if(this.form.value.type == 'Online'){
            amount = this.dInfo?.online_consultancy_fee;
          }else{
            amount = this.dInfo?.consultancy_fee;
          }
          this.spinner.hide();
          this.rzp.createRzpayOrder(amount,this.appointmentId,'appointment');
          this.submitted = false;
        } else {
          this.isFSubmit = false;
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
