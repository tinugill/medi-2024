import { Injectable } from '@angular/core';
import { HTTP_INTERCEPTORS, HttpEvent } from '@angular/common/http';
import {
  HttpRequest,
  HttpHandler,
  HttpInterceptor,
} from '@angular/common/http';
import { Observable } from 'rxjs';

import { TokenStorageService } from '../services/Token/token-storage.service';

const E_TOKEN = 'e-token';

@Injectable()
export class AuthInterceptor implements HttpInterceptor {
  constructor(private token: TokenStorageService) {}

  intercept(
    request: HttpRequest<any>,
    next: HttpHandler
  ): Observable<HttpEvent<any>> {
    let authReq = request;
    const token = this.token.getToken();

    if (token != null) {
      // authReq = authReq.clone({
      //   headers: request.headers.set(E_TOKEN, token).set(C_TOKEN, info.token),
      // });

      authReq = authReq.clone({
        headers: request.headers.set('Authorization', 'Bearer ' + token),
      });

      //console.log(authReq);
    }
    return next.handle(authReq);
  }
}

export const authInterceptorProviders = [
  { provide: HTTP_INTERCEPTORS, useClass: AuthInterceptor, multi: true },
];
