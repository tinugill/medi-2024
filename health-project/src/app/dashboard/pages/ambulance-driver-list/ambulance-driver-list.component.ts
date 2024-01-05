import { Component, OnInit, QueryList, ViewChild } from '@angular/core';
import { ApiService } from '../../../services/Api/api.service';
import { Toaster } from 'ngx-toast-notifications';
import {
  AbstractControl,
  FormBuilder,
  FormGroup,
  Validators,
} from '@angular/forms';
import { NgbModal } from '@ng-bootstrap/ng-bootstrap';
import { EmitService } from '../../../services/Emit/emit.service';
import { NgxSpinnerService } from 'ngx-spinner';
@Component({
  selector: 'app-ambulance-driver-list',
  templateUrl: './ambulance-driver-list.component.html',
  styleUrls: ['./ambulance-driver-list.component.scss']
})
export class AmbulanceDriverListComponent implements OnInit {

  
  constructor(
    private ApiService: ApiService,
    private toaster: Toaster,
    private formBuilder: FormBuilder,
    private modalService: NgbModal,
    private spinner:NgxSpinnerService
  ) {}

  ngOnInit(): void {
    this.setupForm = this.formBuilder.group({ 
      driver_name: ['', Validators.required], 
      id: [''], 
      image: [''], 
      liscence_no: [''], 
      liscence_photo: [''], 
      mobile: [''],
      is_deleted: ['']
    }); 
    this.getMyAmbInfo();
  }
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
    this.setupForm.controls['driver_name'].setValue('');   
    this.setupForm.controls['image'].setValue('');   
    this.setupForm.controls['liscence_no'].setValue('');    
    this.setupForm.controls['is_deleted'].setValue('');    
    this.setupForm.controls['liscence_photo'].setValue('');    
    this.setupForm.controls['mobile'].setValue(''); 
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
        if (name == 'image') {
          this.setupForm.patchValue({
            image: reader.result,
          });
        } else if (name == 'liscence_photo') {
          this.setupForm.patchValue({
            liscence_photo: reader.result,
          });
        }  
      };
    }
  }

  getMyAmbInfo(id = ''): void {
    this.spinner.show();
    this.ApiService.getAmbulanceDriverList(id).subscribe(
      (data) => {
        if (data.status) {
          if(id != ''){
            this.info = data.data;
            this.setupForm.controls['id'].setValue(this.info.id);  
            this.setupForm.controls['driver_name'].setValue(this.info.driver_name);  
            this.setupForm.controls['liscence_no'].setValue(this.info.liscence_no);  
            this.setupForm.controls['is_deleted'].setValue(this.info.is_deleted);  
            this.setupForm.controls['mobile'].setValue(this.info.mobile);  
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
    this.ApiService.updateAmbDriverListInfo(this.setupForm.value).subscribe(
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
