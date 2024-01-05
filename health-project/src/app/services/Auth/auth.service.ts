import { Injectable } from '@angular/core';
import { HttpClient, HttpHeaders, HttpParams } from '@angular/common/http';
import { Observable } from 'rxjs';
import { environment } from '../../../environments/environment';
const AUTH_API = environment.auth_url;

const httpOptions = {
  headers: new HttpHeaders({
    'Content-Type': 'application/x-www-form-urlencoded',
  }),
  //headers: new HttpHeaders({ 'Content-Type': 'application/json'})
};

@Injectable({
  providedIn: 'root',
})
export class AuthService {
  constructor(private http: HttpClient) {}

  login(username: string, password: string): Observable<any> {
    const body = new HttpParams()
      .set('email', username)
      .set('password', password);

    return this.http.post(AUTH_API + 'login', body, httpOptions);
  }

  registerCustomer(step1: any, signupType: any): Observable<any> {
    const body = new HttpParams()
      .set('signupType', signupType)
      .set('name', step1.name)
      .set('mobile', step1.mobile)
      .set('email', step1.email)
      .set('joined_from', step1.joined_from)
      .set('password', step1.password);
    return this.http.post(AUTH_API + 'signup-user', body, httpOptions);
  }

  verifyOtpSignup(form: any): Observable<any> {
    const body = new HttpParams()
      .set('id', form.id)
      .set('otp', form.otp)
      .set('type', form.type);
    return this.http.post(AUTH_API + 'verify-otp-signup', body, httpOptions);
  }
  forgetSendOtp(form: any): Observable<any> {
    const body = new HttpParams()
      .set('mobile', form.mobile) 
      .set('type', form.type);
    return this.http.post(AUTH_API + 'send-otp-forget-password', body, httpOptions);
  }
  verifyOtpForgetPass(form: any): Observable<any> {
    const body = new HttpParams()
      .set('mobile', form.mobile)
      .set('password', form.password)
      .set('c_password', form.c_password)
      .set('otp', form.otp)
      .set('type', form.type);
    return this.http.post(AUTH_API + 'verify-otp-forget-password', body, httpOptions);
  }
}
