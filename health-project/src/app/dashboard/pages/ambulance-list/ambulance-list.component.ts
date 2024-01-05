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
  selector: 'app-ambulance-lists',
  templateUrl: './ambulance-list.component.html',
  styleUrls: ['./ambulance-list.component.scss']
})
export class AmbulanceListComponent implements OnInit {

  constructor(
    private ApiService: ApiService,
    private toaster: Toaster,
    private formBuilder: FormBuilder,
    private spinner : NgxSpinnerService
  ) {}

  ngOnInit(): void {
    this.setupForm = this.formBuilder.group({
      id: [''],  
      ambulance_type: ['', Validators.required],  
      charges_per_day: [''],  
      discount_per_day: [''],  
      charges_per_km: [''],  
      discount_per_km: [''],  
      regis_no: ['', Validators.required],  
      regis_proof: [''],
      img_1: [''], 
      img_2: [''], 
      img_3: [''], 
      img_4: [''], 
      img_5: [''], 
      img_6: [''],
      is_deleted: ['']
    }); 
    this.getMyAmbInfo();
    this.getAmbList();
  }
  setupForm: FormGroup | any;
  b1: boolean = false;
  info: any = [];
  list: any = [];
  ambList: any = [];
  p : any = 'list';
  get f1(): { [key: string]: AbstractControl } {
    return this.setupForm.controls;
  }

  editInfo(id:any = ''){
    this.p = 'edit';
    this.setupForm.reset();
    this.setupForm.controls['id'].setValue('');   
      this.setupForm.controls['ambulance_type'].setValue('');   
      this.setupForm.controls['charges_per_day'].setValue('');   
      this.setupForm.controls['discount_per_day'].setValue('');   
      this.setupForm.controls['charges_per_km'].setValue('');   
      this.setupForm.controls['discount_per_km'].setValue('');   
      this.setupForm.controls['regis_no'].setValue('');   
      this.setupForm.controls['is_deleted'].setValue('');   
      this.setupForm.controls['regis_proof'].setValue('');   
      this.setupForm.controls['img_1'].setValue('');    
      this.setupForm.controls['img_2'].setValue('');    
      this.setupForm.controls['img_3'].setValue('');    
      this.setupForm.controls['img_4'].setValue('');    
      this.setupForm.controls['img_5'].setValue('');    
      this.setupForm.controls['img_6'].setValue('');    
    if(id != ''){
      this.getMyAmbInfo(id);
    }   
    
  }
  onFileChange(e: any, name: any): void {
    const reader = new FileReader();

    if (e.target.files && e.target.files.length) {
      const file = e.target.files[0];
      reader.readAsDataURL(file);

      reader.onload = () => {
        if (name == 'regis_proof') {
          this.setupForm.patchValue({
            regis_proof: reader.result,
          });
        } else if (name == 'img_1') {
          this.setupForm.patchValue({
            img_1: reader.result,
          });
        } else if (name == 'img_2') {
          this.setupForm.patchValue({
            img_2: reader.result,
          });
        } else if (name == 'img_3') {
          this.setupForm.patchValue({
            img_3: reader.result,
          });
        } else if (name == 'img_4') {
          this.setupForm.patchValue({
            img_4: reader.result,
          });
        } else if (name == 'img_5') {
          this.setupForm.patchValue({
            img_5: reader.result,
          });
        } else if (name == 'img_6') {
          this.setupForm.patchValue({
            img_6: reader.result,
          });
        }  
      };
    }
  }

  getAmbList(id = ''): void {
    
    this.spinner.show();
    this.ApiService.getAmbTypeList().subscribe(
      (data) => {
        if (data.status) { 
          this.ambList = data.data;
          
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
  getMyAmbInfo(id = ''): void {
    this.spinner.show();
    this.ApiService.getAmbulanceList(id).subscribe(
      (data) => {
        if (data.status) {
          if(id != ''){
            this.info = data.data;
            this.setupForm.controls['id'].setValue(this.info.id);  
            this.setupForm.controls['regis_no'].setValue(this.info.regis_no);  
            this.setupForm.controls['is_deleted'].setValue(this.info.is_deleted);  
            this.setupForm.controls['ambulance_type'].setValue(this.info.ambulance_type);  
            this.setupForm.controls['charges_per_day'].setValue(this.info.charges_per_day);  
            this.setupForm.controls['discount_per_day'].setValue(this.info.discount_per_day);  
            this.setupForm.controls['charges_per_km'].setValue(this.info.charges_per_km);  
            this.setupForm.controls['discount_per_km'].setValue(this.info.discount_per_km);   
          }else{
            this.list = data.data;
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
    if (this.setupForm.invalid) {
      this.toaster.open({
        text: 'Fill all required fields',
        caption: 'Message',
        duration: 4000,
        type: 'danger',
      });
      return;
    }
    this.spinner.show();
    this.ApiService.updateAmbListInfo(this.setupForm.value).subscribe(
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
          this.getMyAmbInfo(); 
          this.p = 'list';
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
