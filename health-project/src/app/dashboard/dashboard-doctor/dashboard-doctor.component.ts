import { Component, ElementRef, OnInit, ViewChild } from '@angular/core';
import { ActivatedRoute, Router, Params } from '@angular/router';
import { TokenStorageService } from '../../services/Token/token-storage.service';
import { ApiService } from '../../services/Api/api.service';
import { Toaster } from 'ngx-toast-notifications';
import { NgbModal } from '@ng-bootstrap/ng-bootstrap';
import { environment } from "../../../environments/environment";
import html2canvas from 'html2canvas';
import domtoimage from 'dom-to-image';

import { Pipe, PipeTransform } from '@angular/core';
import { HttpClient, HttpHeaders } from '@angular/common/http';
import { DomSanitizer, SafeUrl } from '@angular/platform-browser';
import { Observable } from 'rxjs';
import { map, catchError } from 'rxjs/operators';

@Pipe({
  name: 'imageToBase64'
})
export class ImageToBase64Pipe implements PipeTransform {
  constructor(private http: HttpClient, private sanitizer: DomSanitizer) {}

  transform(imageUrl: string): any {
    this.toDataUrl(imageUrl, (myBase64:any) => {
      console.log('myBase64',myBase64); // myBase64 is the base64 string
    });
    // const a = this.getImageBase64(imageUrl).pipe(
    //   map(base64String => this.sanitizer.bypassSecurityTrustUrl(base64String)),
    //   catchError(async () => this.sanitizer.bypassSecurityTrustUrl(''))
    // );
    // console.log('a',a);
    
    // return a;
  }
  private toDataUrl(url:any, callback:any) {
    var xhr = new XMLHttpRequest();
    xhr.onload = function() {
        var reader = new FileReader();
        reader.onloadend = function() {
            callback(reader.result);
        }
        reader.readAsDataURL(xhr.response);
    };
    xhr.open('GET', url);
    xhr.responseType = 'blob';
    xhr.send();
}
  private getImageBase64(imageUrl: string): Observable<string> {
    let httpOptions:any = {
      headers: new HttpHeaders({
        'Content-Type': 'application/x-www-form-urlencoded',
      }),
      observe: 'body', responseType: 'blob' as 'json'
    };
    return this.http.get(imageUrl, httpOptions).pipe(
      map(response => {
        const base64String = btoa(new Uint8Array(response).reduce((data, byte) => data + String.fromCharCode(byte), ''));
        return `data:image/png;base64,${base64String}`;
      })
    );
  }
}

@Component({
  selector: 'app-dashboard-doctor',
  templateUrl: './dashboard-doctor.component.html',
  styleUrls: ['./dashboard-doctor.component.scss'],
})
export class DashboardDoctorComponent implements OnInit {
  constructor(
    private tokenStorage: TokenStorageService,
    private ApiService: ApiService,
    private _Activatedroute: ActivatedRoute,
    private toaster: Toaster,
    private router: Router,
    private modalService: NgbModal
  ) {
    this.isLoggedIn = !!this.tokenStorage.getToken();
    if (this.isLoggedIn) {
      this.myInfo = this.tokenStorage.getUser();

      if (this.myInfo.type == 'User') {
        this.router.navigate(['/Patient-Record/record']);
        return;
      } else if (this.myInfo.type == 'Hospital') {
        this.router.navigate(['/dashboard/hospital']);
        return;
      } else if (this.myInfo.type == 'Hospitalstaff') {
        this.router.navigate(['/dashboard/staff']);
        return;
      } else if (this.myInfo.type == 'Pharmacy') {
        this.router.navigate(['/dashboard/pharmacy']);
        return;
      } else if (this.myInfo.type == 'Lab') {
        this.router.navigate(['/dashboard/lab']);
        return;
      } else if (this.myInfo.type == 'Bloodbank') {
        this.router.navigate(['/dashboard/bloodbank']);
        return;
      }else if (this.myInfo.type == 'Nursing') {
        this.router.navigate(['/dashboard/Nursing']);
        return;
      }else if (this.myInfo.type == 'Dealer') {
        this.router.navigate(['/dashboard/dealer']);
        return;
      }else if (this.myInfo.type == 'Ambulance') {
        this.router.navigate(['/dashboard/ambulance']);
        return;
      }
    } else {
      this.router.navigate(['/home']);
      return;
    }
  }

  ngOnInit(): void {}
  isLoggedIn: boolean = false;
  myInfo: any = '';
  page: any = 'my-appointment';
  url:any = environment.my_url

  changePage(page: any) {
    this.page = page;
  }
  logout(): void {
    this.tokenStorage.signOut();
    this.router.navigate(['/home']);
    window.location.reload();
  }
  openVerticallyCentered(modalName: any) {
    this.modalService.open(modalName, {
      centered: true,
      size: 'sm',
      backdropClass: 'light-blue-backdrop',
    });
  } 
  loadImages(element: HTMLElement): Promise<void> {
    const images = Array.from(element.getElementsByTagName('img'));
    const imageLoadPromises = images.map(img => this.imageLoaded(img));

    return Promise.all(imageLoadPromises).then(() => {
      // All images loaded
    });
  }
  imageLoaded(img: HTMLImageElement): Promise<void> {
    return new Promise((resolve) => {
      if (img.complete) {
        resolve();
      } else {
        img.onload = () => resolve();
      }
    });
  }

  async downloadAsImage() {
    console.log('====');
    const iddd = document.getElementById('iddd') as HTMLElement;
    iddd.style.display = 'block';
    const element:any = document.getElementById('printDiv');

    await this.loadImages(element);
    domtoimage.toBlob(element)
      .then((blob) => {
        const url = URL.createObjectURL(blob);
        const link = document.createElement('a');
        link.href = url;
        link.download = 'my-id.png';
        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);
        setTimeout(() => {
          iddd.style.display = 'none';
        }, 1000);
      })
      .catch((error) => {
        console.error('Error capturing image:', error);
      });
     
  }

}
