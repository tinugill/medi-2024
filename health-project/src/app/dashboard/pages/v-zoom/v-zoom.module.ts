import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';

import { VideoZoomComponent } from '../video-zoom/video-zoom.component';
import { authInterceptorProviders } from '../../../helper/auth.interceptor'; 

import { RouterModule, Routes } from '@angular/router';
const routes:Routes = [
  {
    path: '',
    component : VideoZoomComponent,
    pathMatch: 'full',
  }
]


@NgModule({
  declarations: [VideoZoomComponent],
  imports: [
    CommonModule,
    RouterModule.forChild(routes)
  ],
  providers: [authInterceptorProviders],
})
export class VZoomModule { }
