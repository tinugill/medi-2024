import { Component, OnInit } from '@angular/core';
import { ApiService } from '../../../services/Api/api.service';
import { Toaster } from 'ngx-toast-notifications';
import {
  AbstractControl,
  FormBuilder,
  FormGroup,
  Validators,
} from '@angular/forms';
import { map, Observable, startWith } from 'rxjs';
import { NgxSpinnerService } from 'ngx-spinner';
@Component({
  selector: 'app-lab-test-list',
  templateUrl: './lab-test-list.component.html',
  styleUrls: ['./lab-test-list.component.scss'],
})
export class LabTestListComponent implements OnInit {
  constructor(
    private ApiService: ApiService,
    private formBuilder: FormBuilder,
    private toaster: Toaster,
    private spinner: NgxSpinnerService
  ) {
    this.getTestListForLab();
  }
  filterText:any = '';
  ngOnInit(): void { 
    this.sForm = this.formBuilder.group({
      id: [''],
      category_id: ['', Validators.required],
      test_name: ['', Validators.required],
      image: [''],
      price: ['', Validators.required],
      discount: [''],
      prerequisite: [''],
      home_sample_collection: ['', Validators.required], 
      report_home_delivery: ['', Validators.required], 
      ambulance_available: ['', Validators.required], 
      ambulance_fee: [0], 
    });
    this.filteredT = this.sForm.get('test_name').valueChanges.pipe(
      startWith(''),
      map((value:any) => value ? this._filterT(value || '') : this.allLabTest.slice(0,10)),
    );
  }
  private _filterT(value: string): string[] { 
    if(value == ''){ return [];}
    const filterValue = value.toLowerCase(); 
    return this.allLabTest.filter((option:any) => option.title?.toLowerCase().includes(filterValue.toLowerCase()));
  }
  filteredT: Observable<string[]>|any;
  allLabTest: any = [];
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
      this.getTestListForLab(id);
    }
    this.sForm.reset();
  }
  testFind(e:any){
    console.log(e.target.value);
    this.getAllLabTest(e.target.value);
  }
  selectField(option:any){
    console.log('option',option);
    
    this.sForm.controls['category_id'].setValue(option.category_id);
    this.sForm.controls['test_name'].setValue(option.test_name);
    this.sForm.controls['price'].setValue(option.price);
    this.sForm.controls['discount'].setValue(option.discount);
    this.sForm.controls['prerequisite'].setValue(
      option.prerequisite
    );
    this.sForm.controls['home_sample_collection'].setValue(
      option.home_sample_collection
    );
    
    this.sForm.controls['report_home_delivery'].setValue(
      option.report_home_delivery
    );
    this.sForm.controls['ambulance_available'].setValue(
      option.ambulance_available
    );
    this.sForm.controls['ambulance_fee'].setValue(
      option.ambulance_fee
    );
  }
  getAllLabTest(title:any = ''): void {
    this.ApiService.getAllLabTest(title).subscribe(
      (data) => {
        if (data.status) { 
          this.allLabTest = data.data;  
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
  getTestListForLab(id: any = ''): void {
    this.spinner.show();
    this.ApiService.getTestListForLab(id).subscribe(
      (data) => {
        if (data.status) {
          if (id == '') {
            this.testList = data.data.data;
            this.cList = data.data.cat;
          } else {
            this.tInfo = data.data.data;

            this.sForm.controls['id'].setValue(this.tInfo.id);
            this.sForm.controls['category_id'].setValue(this.tInfo.category_id);
            this.sForm.controls['test_name'].setValue(this.tInfo.test_name);
            this.sForm.controls['price'].setValue(this.tInfo.price);
            this.sForm.controls['discount'].setValue(this.tInfo.discount);
            this.sForm.controls['prerequisite'].setValue(
              this.tInfo.prerequisite
            );
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
    this.ApiService.updateLabTestInfo(this.sForm.value).subscribe(
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
          this.getTestListForLab();
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
