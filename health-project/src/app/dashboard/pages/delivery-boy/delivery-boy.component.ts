import { Component, OnInit } from '@angular/core';
import { ApiService } from '../../../services/Api/api.service';
import { Toaster } from 'ngx-toast-notifications';
import { TokenStorageService } from '../../../services/Token/token-storage.service';
import {
  AbstractControl,
  FormBuilder,
  FormGroup,
  Validators,
} from '@angular/forms';
import { NgxSpinnerService } from 'ngx-spinner';

@Component({
  selector: 'app-delivery-boy',
  templateUrl: './delivery-boy.component.html',
  styleUrls: ['./delivery-boy.component.scss']
})
export class DeliveryBoyComponent implements OnInit {

  constructor(
    private ApiService: ApiService,
    private toaster: Toaster,
    private formBuilder: FormBuilder,
    private tokenStorage: TokenStorageService,
    private spinner: NgxSpinnerService
  ) {}

  ngOnInit(): void {
    this.isLoggedIn = !!this.tokenStorage.getToken();
    if (this.isLoggedIn) {
      this.myInfo = this.tokenStorage.getUser();
      console.log(this.myInfo);
      
    }
    this.setupForm = this.formBuilder.group({
      id: [''],  
      name: ['', Validators.required],  
      type: [''],
      mobile: [''],
      is_deleted: ['']
    }); 
    this.getDeliveryBoy();
  }
  isLoggedIn: boolean = false;
  myInfo: any = '';
  setupForm: FormGroup | any;
  b1: boolean = false;
  info: any = [];
  list: any = [];
  p : any = 'list';
  get f1(): { [key: string]: AbstractControl } {
    return this.setupForm.controls;
  }

  editInfo(id:any = ''){
    this.p = 'edit';
    this.setupForm.reset();
    this.setupForm.controls['id'].setValue('');   
      this.setupForm.controls['name'].setValue('');   
      this.setupForm.controls['type'].setValue('');   
      this.setupForm.controls['mobile'].setValue('');   
      this.setupForm.controls['is_deleted'].setValue('');   
    if(id != ''){
      this.getDeliveryBoy(id);
    }   
    
  }
  getDeliveryBoy(id = ''): void {
    this.spinner.hide();
    this.ApiService.getExecutive(id).subscribe(
      (data) => {
        if (data.status) {
          if(id != ''){
            this.info = data.data;
            this.setupForm.controls['id'].setValue(this.info.id);  
            this.setupForm.controls['name'].setValue(this.info.name);  
            this.setupForm.controls['type'].setValue(this.info.type);  
            this.setupForm.controls['mobile'].setValue(this.info.mobile);  
            this.setupForm.controls['is_deleted'].setValue(this.info.is_deleted);  
          }else{
            this.list = data.data;
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
    this.ApiService.updateExecutive(this.setupForm.value).subscribe(
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
          this.getDeliveryBoy(); 
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
 
