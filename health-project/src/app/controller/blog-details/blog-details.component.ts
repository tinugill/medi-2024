import { Component, OnInit } from '@angular/core';
import { TokenStorageService } from '../../services/Token/token-storage.service';
import { ApiService } from '../../services/Api/api.service';
import { Toaster } from 'ngx-toast-notifications';
import { NgxSpinnerService } from 'ngx-spinner';
import { ActivatedRoute, Router, Params } from '@angular/router';
import {
  AbstractControl,
  FormBuilder,
  FormGroup,
  Validators,
} from '@angular/forms';
@Component({
  selector: 'app-blog-details',
  templateUrl: './blog-details.component.html',
  styleUrls: ['./blog-details.component.scss'],
})
export class BlogDetailsComponent implements OnInit {
  constructor(
    private tokenStorage: TokenStorageService,
    private ApiService: ApiService,
    private toaster: Toaster,
    private formBuilder: FormBuilder,
    private _Activatedroute: ActivatedRoute,
    private spinner: NgxSpinnerService
  ) {
    this.isLoggedIn = !!this.tokenStorage.getToken();
    if (this.isLoggedIn) {
      this.myInfo = this.tokenStorage.getUser();
    } else {
    }
  }
  isLoggedIn: boolean = false;
  myInfo: any = '';
  slug: any = '';
  blogList: any = [];
  topBlog: any = [];
  cForm: FormGroup | any;
  b1: boolean = false;
  ngOnInit(): void {
    this._Activatedroute.paramMap.subscribe((params) => {
      this.slug = params.get('slug');
      if (this.slug != '') {
        this.getBlogList(this.slug);
      }
    });
    this.getBlogList();
    this.cForm = this.formBuilder.group({
      blog_id: ['', Validators.required],
      name: ['', Validators.required],
      email: ['', Validators.required],
      comment: ['', Validators.required],
    });
  }
  get f1(): { [key: string]: AbstractControl } {
    return this.cForm.controls;
  }
  onSubmitComment(): void {
    this.b1 = true;
    this.cForm.controls['blog_id'].setValue(this.blogList.id);
    if (this.cForm.invalid) {
      this.toaster.open({
        text: 'Fill all required fields',
        caption: 'Message',
        duration: 4000,
        type: 'danger',
      });
      return;
    }
    this.ApiService.submitBlogComment(this.cForm.value).subscribe(
      (data) => {
        this.toaster.open({
          text: data.message,
          caption: 'Success',
          duration: 4000,
          type: 'success',
        });
        this.b1 = false;
        this.cForm.reset();
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
  getBlogList(slug: any = ''): void {
    this.spinner.show();
    this.ApiService.getBlogList(slug, 'Hospital').subscribe(
      (data) => {
        if (data.status) {
          if (slug != '') {
            this.blogList = data.data;
          } else {
            this.topBlog = data.data;
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
      (err) => {}
    );
  }
}
