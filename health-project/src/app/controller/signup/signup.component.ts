import { Component, OnInit } from '@angular/core';
import { AuthService } from '../../services/Auth/auth.service';
import { ApiService } from '../../services/Api/api.service';
import { TokenStorageService } from '../../services/Token/token-storage.service';
import { NgbModal } from '@ng-bootstrap/ng-bootstrap';
import { ActivatedRoute, Router, Params } from '@angular/router';
import { Toaster } from 'ngx-toast-notifications';
import {
  AbstractControl,
  FormBuilder,
  FormGroup,
  Validators,
} from '@angular/forms';
import { NgxSpinnerService } from 'ngx-spinner';
@Component({
  selector: 'app-signup',
  templateUrl: './signup.component.html',
  styleUrls: ['./signup.component.scss'],
})
export class SignupComponent implements OnInit {
  constructor(
    private tokenStorage: TokenStorageService,
    private formBuilder: FormBuilder,
    private toaster: Toaster,
    private _Activatedroute: ActivatedRoute,
    private router: Router,
    private spinner: NgxSpinnerService,
    private authService: AuthService,
    private modalService: NgbModal,
    private ApiService: ApiService
  ) {
    this._Activatedroute.paramMap.subscribe((params) => {
      let type = this._Activatedroute.snapshot.queryParams['type'];
      let ref = this._Activatedroute.snapshot.queryParams['ref'];
      if (type != '' && type != undefined) {
        this.signupType = type;
      }
      console.log('ref',ref);
      
      if(ref != '' && ref != undefined){
        this.refcode = ref;
      }
    });
  }

  ngOnInit(): void {
    if (this.tokenStorage.getToken()) {
      let myInfo = this.tokenStorage.getUser();
      if (myInfo.type == 'User') {
        this.router.navigate(['/Patient-Record/record']);
        return;
      } else if (myInfo.type == 'Hospital') {
        this.router.navigate(['/dashboard/hospital']);
        return;
      } else if (myInfo.type == 'Hospitalstaff') {
        this.router.navigate(['/dashboard/staff']);
        return;
      } else if (myInfo.type == 'Pharmacy') {
        this.router.navigate(['/dashboard/pharmacy']);
        return;
      } else if (myInfo.type == 'Lab') {
        this.router.navigate(['/dashboard/lab']);
        return;
      } else if (myInfo.type == 'Bloodbank') {
        this.router.navigate(['/dashboard/bloodbank']);
        return;
      }else if (myInfo.type == 'Nursing') {
        this.router.navigate(['/dashboard/Nursing']);
        return;
      }else if (myInfo.type == 'Dealer') {
        this.router.navigate(['/dashboard/dealer']);
        return;
      }else if (myInfo.type == 'Ambulance') {
        this.router.navigate(['/dashboard/ambulance']);
        return;
      } 
      this.isLoggedIn = true;
    }
    this.step1Form = this.formBuilder.group({
      full_name: ['', Validators.required],
      mobile: ['', Validators.required],
      email: ['', Validators.required],
      gender: ['', Validators.required],
      about: ['', Validators.required],
      password: ['', Validators.required],
    });
    this.step2Form = this.formBuilder.group({
      degree_file: ['', Validators.required],
      working_days: ['', Validators.required],
      doctor_image: ['', Validators.required],
      experience: ['', Validators.required],
    });
    this.otpForm = this.formBuilder.group({
      id: ['', Validators.required],
      otp: ['', Validators.required],
      type: ['', Validators.required],
    });
    this.userForm = this.formBuilder.group({
      name:  ['', Validators.required],
      email: ['', Validators.required],
      mobile: ['', Validators.required],
      joined_from: [this.refcode],
      password: ['', Validators.required],
      tc: ['', Validators.required],
    }); 
     
    // this.userForm.controls['joined_from'].setValue(this.refcode);

    this.h1Form = this.formBuilder.group({
      name: ['', Validators.required],
      address: ['', Validators.required],
      city: ['', Validators.required],
      pincode: ['', Validators.required],
      country: ['', Validators.required],
      type: [''],
      beds_quantity: [''],
    });
    this.h2Form = this.formBuilder.group({
      image: [''],
      specialities_id: [''],
      procedures_id: [''],
      facilities_avialable: [''],
    });
    this.h3Form = this.formBuilder.group({
      name: [''],
      email: ['', Validators.required],
      mobile: ['', Validators.required],
      password: ['', Validators.required],
    });
    this.p1Form = this.formBuilder.group({
      name: ['', Validators.required],
      address: ['', Validators.required],
      city: ['', Validators.required],
      pincode: ['', Validators.required],
      country: ['', Validators.required],
    });
    this.p2Form = this.formBuilder.group({
      image: [''],
      cp_first_name: [''],
      cp_last_name: [''],
      cp_middle_name: [''],
      drug_liscence_valid_upto: [''],
      drug_liscence_file: [''],
      drug_liscence_number: ['', Validators.required],
      email: ['', Validators.required],
      mobile: ['', Validators.required],
      password: ['', Validators.required],
    });
    this.l1Form = this.formBuilder.group({
      name: ['', Validators.required],
      address: ['', Validators.required],
      city: ['', Validators.required],
      pincode: ['', Validators.required],
      country: ['', Validators.required],
    });
    this.l2Form = this.formBuilder.group({
      image: [''],
      name: [''],
      registration_detail: [''],
      registration_file: [''],
      email: ['', Validators.required],
      mobile: ['', Validators.required],
      password: ['', Validators.required],
    });
    this.bb1Form = this.formBuilder.group({
      name: ['', Validators.required],
      address: ['', Validators.required],
      city: ['', Validators.required],
      pincode: ['', Validators.required],
      country: ['', Validators.required],
    });
    this.bb2Form = this.formBuilder.group({
      image: [''],
      name: [''],
      liscence_no: [''],
      liscence_file: [''],
      email: ['', Validators.required],
      mobile: ['', Validators.required],
      password: ['', Validators.required],
    });
  }

  refcode:any = '';
  isLoggedIn = false;
  isLinear = true;
  step1Form: FormGroup | any;
  step2Form: FormGroup | any;
  userForm: FormGroup | any;
  // user2Form: FormGroup | any;
  h1Form: FormGroup | any;
  h2Form: FormGroup | any;
  h3Form: FormGroup | any;
  p1Form: FormGroup | any;
  p2Form: FormGroup | any;
  l1Form: FormGroup | any;
  l2Form: FormGroup | any;
  bb1Form: FormGroup | any;
  bb2Form: FormGroup | any;
  otpForm: FormGroup | any;
  h1: boolean = false;
  h2: boolean = false;
  h3: boolean = false;
  p1: boolean = false;
  p2: boolean = false;
  u1: boolean = false;
  b1: boolean = false;
  b2: boolean = false;
  l1: boolean = false;
  l2: boolean = false;
  bb1: boolean = false;
  bb2: boolean = false;
  otp: boolean = false;
  isOtpSent: boolean = false;
  signupType: any = '';

  get f1(): { [key: string]: AbstractControl } {
    return this.step1Form.controls;
  }
  get f2(): { [key: string]: AbstractControl } {
    return this.step2Form.controls;
  }
  get op(): { [key: string]: AbstractControl } {
    return this.otpForm.controls;
  }
  get uf(): { [key: string]: AbstractControl } {
    return this.userForm.controls;
  }

  get fh1(): { [key: string]: AbstractControl } {
    return this.h1Form.controls;
  }
  get fh2(): { [key: string]: AbstractControl } {
    return this.h2Form.controls;
  }
  get fh3(): { [key: string]: AbstractControl } {
    return this.h3Form.controls;
  }
  get fp1(): { [key: string]: AbstractControl } {
    return this.p1Form.controls;
  }
  get fp2(): { [key: string]: AbstractControl } {
    return this.p2Form.controls;
  }
  get fl1(): { [key: string]: AbstractControl } {
    return this.l1Form.controls;
  }
  get fl2(): { [key: string]: AbstractControl } {
    return this.l2Form.controls;
  }
  get fbb1(): { [key: string]: AbstractControl } {
    return this.bb1Form.controls;
  }
  get fbb2(): { [key: string]: AbstractControl } {
    return this.bb2Form.controls;
  }
  typeFn(type: any): void {
    this.signupType = type;
    if (type == 'Doctor') {
      this.userForm.controls['name'].setValue('Dr. ');
    }
    this.getSpecialities();
    this.getProcedures();
  }
  onFileChange(e: any, name: any): void {
    const reader = new FileReader();

    if (e.target.files && e.target.files.length) {
      const file = e.target.files[0];
      reader.readAsDataURL(file);

      reader.onload = () => {
        if (name == 'degree_file') {
          this.step2Form.patchValue({
            degree_file: reader.result,
          });
        } else if (name == 'doctor_image') {
          this.step2Form.patchValue({
            doctor_image: reader.result,
          });
        } else if (name == 'hospital') {
          this.h2Form.patchValue({
            image: reader.result,
          });
        } else if (name == 'pharmacy') {
          this.p2Form.patchValue({
            image: reader.result,
          });
        } else if (name == 'drug_liscence_file') {
          this.p2Form.patchValue({
            drug_liscence_file: reader.result,
          });
        } else if (name == 'lab') {
          this.l2Form.patchValue({
            image: reader.result,
          });
        } else if (name == 'lab_registration_file') {
          this.l2Form.patchValue({
            registration_file: reader.result,
          });
        } else if (name == 'bloodbak') {
          this.bb2Form.patchValue({
            image: reader.result,
          });
        } else if (name == 'liscence_file') {
          this.bb2Form.patchValue({
            liscence_file: reader.result,
          });
        }
      };
    }
  }
  logout(): void {
    this.tokenStorage.signOut();
    window.location.reload();
  }
  openVerticallyCentered(modalName: any) {
    this.modalService.open(modalName, {
      centered: true,
      size: 'sm',
      backdropClass: 'light-blue-backdrop',
    });
  }

  commonSubmit(): void {
    this.u1 = true;
    if (this.userForm.invalid) {
      this.toaster.open({
        text: 'Fill all required fields',
        caption: 'Message',
        duration: 4000,
        type: 'danger',
      });
      return;
    }
    this.spinner.show();
    this.authService
      .registerCustomer(this.userForm.value, this.signupType)
      .subscribe(
        (data) => {
          if (data.status) {
            this.toaster.open({
              text: data.message,
              caption: 'Success',
              duration: 4000,
              type: 'success',
            });
            this.otpForm.controls['id'].setValue(data.data.req_id);
            this.otpForm.controls['type'].setValue(data.data.type);
            this.isOtpSent = true;
          } else {
            this.toaster.open({
              text: data.message,
              caption: 'Error',
              duration: 4000,
              type: 'danger',
            });
            this.isOtpSent = false;
            this.u1 = false;
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

  verifyOtp(): void {
    this.isOtpSent = true;

    if (this.otpForm.invalid) {
      this.toaster.open({
        text: 'Fill all required fields',
        caption: 'Message',
        duration: 4000,
        type: 'danger',
      });
      return;
    }
    this.spinner.show();
    this.authService.verifyOtpSignup(this.otpForm.value).subscribe(
      (data) => {
        if (data.status) {
          this.toaster.open({
            text: data.message,
            caption: 'Success',
            duration: 4000,
            type: 'success',
          });
          this.isOtpSent = false;
          this.otpForm.reset();
          this.spinner.hide();
          this.tokenStorage.saveToken(data.data.token);
          this.tokenStorage.saveUser(data.data);
          if (data.data.type == 'Doctor') {
            this.router.navigate(['/dashboard/doctor']);
            return;
          } else if (data.data.type == 'Hospital') {
            this.router.navigate(['/dashboard/hospital']);
            return;
          } else if (data.data.type == 'Hospitalstaff') {
            this.router.navigate(['/dashboard/staff']);
            return;
          } else if (data.data.type == 'Pharmacy') {
            this.router.navigate(['/dashboard/pharmacy']);
            return;
          } else if (data.data.type == 'Lab') {
            this.router.navigate(['/dashboard/lab']);
            return;
          } else if (data.data.type == 'Bloodbank') {
            this.router.navigate(['/dashboard/bloodbank']);
            return;
          } else {
            this.router.navigate(['/Patient-Record/record']);
          }
          return;
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

  sList: any = [];
  pList: any = [];
  fList: any = [];
  getSpecialities(): void {
    this.ApiService.getSpecialities('').subscribe(
      (data) => {
        if (data.status) {
          this.sList = data.data;
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
  getFacilities(): void {
    this.ApiService.getFacilities('').subscribe(
      (data) => {
        if (data.status) {
          this.fList = data.data;
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
  getProcedures(): void {
    this.ApiService.getProcedures('').subscribe(
      (data) => {
        if (data.status) {
          this.pList = data.data;
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
}
