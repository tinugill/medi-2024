import { Component, OnInit } from '@angular/core';
import { ApiService } from '../../services/Api/api.service';
import { Toaster } from 'ngx-toast-notifications';
import {
  AbstractControl,
  FormBuilder,
  FormGroup,
  Validators,
} from '@angular/forms';
import InlineEditor from '@ckeditor/ckeditor5-build-inline';
import { environment } from '../../../environments/environment';
import { Pipe, PipeTransform } from '@angular/core';
import { NgxSpinnerService } from 'ngx-spinner';
@Pipe({
  name: 'striphtml',
})
export class StripHtmlPipe implements PipeTransform {
  transform(value: string): any {
    if (value != null) {
      return value.replace(/<.*?>/g, ''); // replace tags
    } else {
      return null;
    }
  }
}
@Component({
  selector: 'app-dashboard-blog',
  templateUrl: './dashboard-blog.component.html',
  styleUrls: ['./dashboard-blog.component.scss'],
})
export class DashboardBlogComponent implements OnInit {
  constructor(
    private ApiService: ApiService,
    private formBuilder: FormBuilder,
    private toaster: Toaster,
    private spinner: NgxSpinnerService
  ) {
    this.getBlogListUser();
  }

  ngOnInit(): void {
    this.sForm = this.formBuilder.group({
      id: [''],
      title: ['', Validators.required],
      image: [''],
      date: ['', Validators.required],
      desc: ['', Validators.required],
    });
  }
  editor: any = InlineEditor;
  ckconfig: any;
  BACK_END_MAPPING_URL_FOR_SAVE_IMG: string =
    environment.base_url + 'temp-image';
  blogList: any = [];
  tInfo: any = [];
  sForm: FormGroup | any;
  b1: boolean = false;
  editPage: boolean = false;
  get f1(): { [key: string]: AbstractControl } {
    return this.sForm.controls;
  }
  editBlog(id: any = '') {
    this.editPage = !this.editPage;
    if (id != '') {
      this.getBlogListUser(id);
    }
  }
  onFileChange(e: any, name: any): void {
    const reader = new FileReader();

    if (e.target.files && e.target.files.length) {
      const file = e.target.files[0];
      reader.readAsDataURL(file);

      reader.onload = () => {
        if (name == 'image') {
          this.sForm.patchValue({
            image: reader.result,
          });
        }
      };
    }
  }
  getBlogListUser(id: any = ''): void {
    this.ApiService.getBlogListUser(id).subscribe(
      (data) => {
        if (data.status) {
          if (id == '') {
            this.blogList = data.data.data;
          } else {
            this.tInfo = data.data.data;

            this.sForm.controls['id'].setValue(this.tInfo.id);
            this.sForm.controls['title'].setValue(this.tInfo.title);
            this.sForm.controls['date'].setValue(this.tInfo.date);
            this.sForm.controls['desc'].setValue(this.tInfo.desc);
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

  onSubmit(): void {
    this.b1 = true;
    if (this.sForm.invalid) {
      this.toaster.open({
        text: 'Fill all required fields',
        caption: 'Message',
        duration: 4000,
        type: 'danger',
      });
      return;
    }
    this.spinner.show();
    this.ApiService.updateBlogInfoUser(this.sForm.value).subscribe(
      (data) => {
        if (data.status) {
          this.toaster.open({
            text: data.message,
            caption: 'Success',
            duration: 4000,
            type: 'success',
          });
          this.b1 = false;
          this.getBlogListUser();
          this.sForm.reset();
          this.sForm.controls['id'].setValue('');
          this.editPage = !this.editPage;
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
}
