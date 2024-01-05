import { Component, OnInit } from '@angular/core';
import { TokenStorageService } from '../../services/Token/token-storage.service';
import { ApiService } from '../../services/Api/api.service';
import { Toaster } from 'ngx-toast-notifications';
import { NgxSpinnerService } from 'ngx-spinner';
import { ActivatedRoute, Router, Params } from '@angular/router';
@Component({
  selector: 'app-blog-page',
  templateUrl: './blog-page.component.html',
  styleUrls: ['./blog-page.component.scss']
})
export class BlogPageComponent implements OnInit {

  constructor(
    private tokenStorage: TokenStorageService,
    private ApiService: ApiService,
    private toaster: Toaster, 
    private _Activatedroute: ActivatedRoute,
    private spinner: NgxSpinnerService
  ) { }
  blogList:any = [];
  skip:any = 0;
  ngOnInit(): void {
    this.getBlogList();
  }
  getSmall(val:any){
    return val.substring(0,200)+'...';
  }
  changePage(type:any){
    if(type == 'prev'){
      this.skip = this.skip - 10;
      if(this.skip < 0){
        this.skip = 0;
      }
    }else{
      this.skip = this.skip + 10;
    }
    this.getBlogList();
  }
  getBlogList(slug: any = ''): void {
    this.spinner.show();
    this.ApiService.getBlogList(slug, '', this.skip, 10).subscribe(
      (data) => {
        if (data.status) { 
          this.blogList = data.data; 
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
      (err) => {}
    );
  }
}
