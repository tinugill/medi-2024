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
  selector: 'app-doc-setting',
  templateUrl: './doc-setting.component.html',
  styleUrls: ['./doc-setting.component.scss'],
})
export class DocSettingComponent implements OnInit {
  constructor(
    private ApiService: ApiService,
    private toaster: Toaster,
    private formBuilder: FormBuilder,
    private spinner: NgxSpinnerService
  ) {}
  slotList: any = [];
  slotForm: FormGroup | any;
  submitBtn: boolean = false;
  isEdit: boolean = false;
  editSlotId = '';
  ngOnInit(): void {
    this.slotForm = this.formBuilder.group({
      id: [''],
      day: ['', Validators.required],
      slot_interval: ['', Validators.required],
      shift1_start_at: ['', Validators.required],
      shift1_end_at: ['', Validators.required],
      shift2_start_at: [''],
      shift2_end_at: [''],
    });
    this.getTimeslots();
  }
  get f(): { [key: string]: AbstractControl } {
    return this.slotForm.controls;
  }
  editBtn(id: any = ''): void {
    this.editSlotId = id;
    this.isEdit = !this.isEdit;
    if (id != '') {
      this.getTimeslots(id);
    }
  }
  getTimeslots(id: any = ''): void {
    this.spinner.show();
    this.ApiService.getTimeslots(id).subscribe(
      (data) => {
        if (data.status) {
          if (id == '') {
            this.slotList = data.data;
          } else {
            let info = data.data;
            let day = [info.day];
            this.slotForm.controls['id'].setValue(info.id);
            this.slotForm.controls['day'].setValue(day);
            this.slotForm.controls['slot_interval'].setValue(
              '' + info.slot_interval
            );
            this.slotForm.controls['shift1_start_at'].setValue(
              info.shift1_start_at
            );
            this.slotForm.controls['shift1_end_at'].setValue(
              info.shift1_end_at
            );
            this.slotForm.controls['shift2_start_at'].setValue(
              info.shift2_start_at
            );
            this.slotForm.controls['shift2_end_at'].setValue(
              info.shift2_end_at
            );
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
  deleteSlot(id: any): void {
    this.spinner.show();
    this.ApiService.deleteSlot(id).subscribe(
      (data) => {
        if (data.status) {
          this.toaster.open({
            text: data.message,
            caption: 'Success',
            duration: 4000,
            type: 'success',
          });
          this.spinner.hide();
          this.getTimeslots();
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
  addSlot(): void {
    this.submitBtn = true;
    if (this.slotForm.invalid) {
      this.toaster.open({
        text: 'Fill all required fields',
        caption: 'Message',
        duration: 4000,
        type: 'danger',
      });
      return;
    }

    this.spinner.show();
    this.ApiService.addSlot(this.slotForm.value).subscribe(
      (data) => {
        if (data.status) {
          this.toaster.open({
            text: data.message,
            caption: 'Success',
            duration: 4000,
            type: 'success',
          });
          this.submitBtn = false;
          this.spinner.hide();
          this.getTimeslots();
          this.isEdit = !this.isEdit;
          this.slotForm.reset();
          this.slotForm.controls['id'].setValue('');
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
