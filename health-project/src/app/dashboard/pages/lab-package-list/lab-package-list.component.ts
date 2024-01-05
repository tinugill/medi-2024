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
  selector: 'app-lab-package-list',
  templateUrl: './lab-package-list.component.html',
  styleUrls: ['./lab-package-list.component.scss'],
})
export class LabPackageListComponent implements OnInit {
  constructor(
    private ApiService: ApiService,
    private formBuilder: FormBuilder,
    private toaster: Toaster,
    private spinner: NgxSpinnerService
  ) {
    this.getTestPackageListForLab();
  }

  ngOnInit(): void {
    this.sForm = this.formBuilder.group({
      id: [''],
      test_ids: ['', Validators.required],
      package_name: ['', Validators.required],
      image: [''],
      price: ['', Validators.required],
      discount: [''],
      home_sample_collection: ['', Validators.required], 
      report_home_delivery: ['', Validators.required], 
      ambulance_available: ['', Validators.required], 
      ambulance_fee: [0]
    });
    this.getTestListForLab();
  }
  filterText:any = '';
  packageList: any = [];
  testList: any = [];
  tInfo: any = [];
  cList: any = [];
  sForm: FormGroup | any;
  b1: boolean = false;
  editPage: boolean = false;
  get f1(): { [key: string]: AbstractControl } {
    return this.sForm.controls;
  }
  editTest(id: any = '') {
    this.editPage = !this.editPage;
    if (id != '') {
      this.getTestPackageListForLab(id);
    }
  }
  getTestListForLab(): void {
    this.spinner.show();
    this.ApiService.getTestListForLab('').subscribe(
      (data) => {
        if (data.status) {
          this.testList = data.data.data;
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
  getTestPackageListForLab(id: any = ''): void {
    this.spinner.show();
    this.ApiService.getTestPackageListForLab(id).subscribe(
      (data) => {
        if (data.status) {
          if (id == '') {
            this.packageList = data.data.data;
          } else {
            this.tInfo = data.data.data;

            this.sForm.controls['id'].setValue(this.tInfo.id);
            this.sForm.controls['test_ids'].setValue(
              JSON.parse(this.tInfo.test_ids)
            );
            this.sForm.controls['package_name'].setValue(
              this.tInfo.package_name
            );
            this.sForm.controls['price'].setValue(this.tInfo.price);
            this.sForm.controls['discount'].setValue(this.tInfo.discount);
            this.sForm.controls['home_sample_collection'].setValue(
              this.tInfo.home_sample_collection
            );
            
            this.sForm.controls['report_home_delivery'].setValue(
              this.tInfo.report_home_delivery
            );
            this.sForm.controls['ambulance_available'].setValue(
              this.tInfo.ambulance_available
            );
            this.sForm.controls['ambulance_fee'].setValue(
              this.tInfo.ambulance_fee
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
    this.ApiService.updateLabTestPackageInfo(this.sForm.value).subscribe(
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
          this.getTestPackageListForLab();
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
