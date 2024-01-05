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
  selector: 'app-bloodbank-stock-list',
  templateUrl: './bloodbank-stock-list.component.html',
  styleUrls: ['./bloodbank-stock-list.component.scss'],
})
export class BloodbankStockListComponent implements OnInit {
  filterText:any = '';
  constructor(
    private ApiService: ApiService,
    private formBuilder: FormBuilder,
    private toaster: Toaster,
    private spinner: NgxSpinnerService
  ) {
    this.getStockListForBB();
  }

  ngOnInit(): void {
    this.sForm = this.formBuilder.group({
      id: [''],
      component_name: ['', Validators.required],
      avialablity: ['', Validators.required],
      available_unit: [''],
    });
  }
  stockList: any = [];
  tInfo: any = [];
  cList: any = [];
  sForm: FormGroup | any;
  b1: boolean = false;
  editPage: boolean = false;
  get f1(): { [key: string]: AbstractControl } {
    return this.sForm.controls;
  }
  editStock(id: any = '') {
    this.editPage = !this.editPage;
    if (id != '') {
      this.getStockListForBB(id);
    }
  }
  statusChange(e:any){ 
    if(e.value == 'No'){
      this.sForm.controls['available_unit'].setValue(0);
    }else{
      this.sForm.controls['available_unit'].setValue(this.tInfo?.available_unit);
    }
  }
  getStockListForBB(id: any = ''): void {
    this.spinner.show();
    this.ApiService.getStockListForBB(id).subscribe(
      (data) => {
        if (data.status) {
          if (id == '') {
            this.stockList = data.data.data;
            this.cList = data.data.component;
          } else {
            this.tInfo = data.data.data;

            this.sForm.controls['id'].setValue(this.tInfo.id);
            this.sForm.controls['component_name'].setValue(
              this.tInfo.component_name
            );
            this.sForm.controls['avialablity'].setValue(this.tInfo.avialablity);
            this.sForm.controls['available_unit'].setValue(
              this.tInfo.available_unit
            );
          }
          this.spinner.hide();
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
    this.ApiService.updateBBStockInfo(this.sForm.value).subscribe(
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
          this.getStockListForBB();
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
