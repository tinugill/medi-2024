import { Component, OnInit } from '@angular/core';
import { ActivatedRoute, Router, Params } from '@angular/router';
import { TokenStorageService } from '../../services/Token/token-storage.service'; 
import { ApiService } from '../../services/Api/api.service';
import { Toaster } from 'ngx-toast-notifications'; 
import { NgxSpinnerService } from 'ngx-spinner';

@Component({
  selector: 'app-review-page',
  templateUrl: './review-page.component.html',
  styleUrls: ['./review-page.component.scss']
})
export class ReviewPageComponent implements OnInit {

  constructor(private ApiService: ApiService,private spinner: NgxSpinnerService, private _Activatedroute: ActivatedRoute,private toaster: Toaster) { }

  ngOnInit(): void {
    this._Activatedroute.paramMap.subscribe((params) => {
      this.type = params.get('type');
      this.id = params.get('id'); 
      if (this.id != '' && this.type != '') {
         this.getReviews()
      }
    }); 
  }
  type:any = '';
  reviews : any;
  id:any = '';

  getReviews(){
    this.spinner.show();
    this.ApiService.getReviews(this.type, this.id).subscribe(
      (data) => {
        this.reviews = data.data;
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
