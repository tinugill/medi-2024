import { Component, OnInit } from '@angular/core';
import { AuthService } from '../../services/Auth/auth.service';
import { TokenStorageService } from '../../services/Token/token-storage.service';
import { NgbModal } from '@ng-bootstrap/ng-bootstrap';
import { Router } from '@angular/router';
import { Toaster } from 'ngx-toast-notifications';
import {
  AbstractControl,
  FormBuilder,
  FormGroup,
  Validators,
} from '@angular/forms';
import { NgxSpinnerService } from 'ngx-spinner';
@Component({
  selector: 'app-login',
  templateUrl: './login.component.html',
  styleUrls: ['./login.component.scss'],
})
export class LoginComponent implements OnInit {
  form: any = {
    username: null,
    password: null,
    otp: null,
  };
  isLoggedIn = false;
  isLoginFailed = false;
  errorMessage = '';
  isOtpSent = false;
  otpMessage = '';
  submitted = false;
  otpForm: FormGroup | any;
  forgetForm: FormGroup | any;
  constructor(
    private authService: AuthService,
    private tokenStorageService: TokenStorageService,
    private router: Router,
    private modalService: NgbModal,
    private formBuilder: FormBuilder,
    private toaster: Toaster,
    private spinner: NgxSpinnerService
  ) {}

  ngOnInit(): void {
    if (this.tokenStorageService.getToken()) {
      let myInfo = this.tokenStorageService.getUser();
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
      
      return;
      this.isLoggedIn = true;
    }
    this.otpForm = this.formBuilder.group({
      id: ['', Validators.required],
      otp: ['', Validators.required],
      type: ['', Validators.required],
    });
    this.forgetForm = this.formBuilder.group({
      mobile: ['', Validators.required],
      otp: [''],
      password: [''],
      c_password: [''],
      type: ['', Validators.required],
    });
  }
  isForgetPass: boolean = false;
  forgetPass(){
    this.isForgetPass = !this.isForgetPass;
  }
  get op(): { [key: string]: AbstractControl } {
    return this.otpForm.controls;
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
          this.tokenStorageService.saveToken(data.data.token);
          this.tokenStorageService.saveUser(data.data);
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
  verifyOtpForgetPass(): void {  
    if (this.forgetForm.invalid) {
      this.toaster.open({
        text: 'Fill all required fields',
        caption: 'Message',
        duration: 4000,
        type: 'danger',
      });
      return;
    }
    this.spinner.show();
    this.authService.verifyOtpForgetPass(this.forgetForm.value).subscribe(
      (data) => {
        if (data.status) {
          this.toaster.open({
            text: data.message,
            caption: 'Success',
            duration: 4000,
            type: 'success',
          }); 
          this.isForgetPass = false;
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
  forgetSendOtp(): void {  
    if (this.forgetForm.invalid) {
      this.toaster.open({
        text: 'Fill all required fields',
        caption: 'Message',
        duration: 4000,
        type: 'danger',
      });
      return;
    }
    this.spinner.show();
    this.authService.forgetSendOtp(this.forgetForm.value).subscribe(
      (data) => {
        if (data.status) {
          this.toaster.open({
            text: data.message,
            caption: 'Success',
            duration: 4000,
            type: 'success',
          }); 
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
  onSubmit(): void {
    this.submitted = true;
    this.errorMessage = '';
    const { username, password } = this.form;

    this.spinner.show();
    this.authService.login(username, password).subscribe(
      (data) => {
        if (data.status) {
          this.spinner.hide();
          if (data.data.req_id != undefined) {
            this.otpForm.controls['id'].setValue(data.data.req_id);
            this.otpForm.controls['type'].setValue(data.data.type);
            this.isOtpSent = true;
            return;
          }
          this.tokenStorageService.saveToken(data.data.token);
          this.tokenStorageService.saveUser(data.data);

          this.isLoginFailed = false;
          this.isLoggedIn = true;
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
        } else {
          this.errorMessage = data.message;
        }
        this.spinner.hide();
      },
      (err) => {
        this.spinner.hide();
        this.errorMessage = err.error.message;
      }
    );
  }

  logout(): void {
    this.tokenStorageService.signOut();
    window.location.reload();
  }
  openVerticallyCentered(modalName: any) {
    this.modalService.open(modalName, {
      centered: true,
      size: 'sm',
      backdropClass: 'light-blue-backdrop',
    });
  }
}
