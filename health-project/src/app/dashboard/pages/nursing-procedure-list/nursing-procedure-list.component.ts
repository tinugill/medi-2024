import { Component, OnInit } from '@angular/core';
import { ApiService } from '../../../services/Api/api.service';
import { Toaster } from 'ngx-toast-notifications';
import {
  AbstractControl,
  FormBuilder,
  FormGroup,
  Validators,
} from '@angular/forms';
import { NgxSpinnerService } from 'ngx-spinner';
@Component({
  selector: 'app-nursing-procedure-list',
  templateUrl: './nursing-procedure-list.component.html',
  styleUrls: ['./nursing-procedure-list.component.scss']
})
export class NursingProcedureListComponent implements OnInit {
  filterText:any = '';
  constructor(
    private ApiService: ApiService,
    private formBuilder: FormBuilder,
    private toaster: Toaster,
    private spinner: NgxSpinnerService
  ) {
    this.getNursingProcedure();
  }

  ngOnInit(): void {
    this.sForm = this.formBuilder.group({
      id: [''],
      title: ['', Validators.required],
      price: ['', Validators.required], 
      status: ['', Validators.required]
    });
  }
  npList: any = [];
  tInfo: any = []; 
  sForm: FormGroup | any;
  b1: boolean = false;
  editPage: boolean = false;
  get f1(): { [key: string]: AbstractControl } {
    return this.sForm.controls;
  }
  editTest(id: any = '') {
    this.editPage = !this.editPage;
    if (id != '') {
      this.getNursingProcedure(id);
    }
  }
  getNursingProcedure(id: any = ''): void {
    this.spinner.show();
    this.ApiService.getNursingProcedure(id).subscribe(
      (data) => {
        if (data.status) {
          if (id == '') {
            this.npList = data.data; 
          } else {
            this.tInfo = data.data; 
            this.sForm.controls['id'].setValue(this.tInfo.id);
            this.sForm.controls['title'].setValue(this.tInfo.title);
            this.sForm.controls['price'].setValue(this.tInfo.price);
            this.sForm.controls['status'].setValue(this.tInfo.status); 
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
    this.ApiService.updateNursingProcedureInfo(this.sForm.value).subscribe(
      (data) => {
        if (data.status) {
          this.toaster.open({
            text: data.message,
            caption: 'Success',
            duration: 4000,
            type: 'success',
          });
          this.b1 = false;
          this.spinner.hide();
          this.getNursingProcedure();
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

}
