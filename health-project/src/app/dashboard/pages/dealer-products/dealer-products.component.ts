import { Component, OnInit, Input } from '@angular/core';
import { ApiService } from '../../../services/Api/api.service';
import { TokenStorageService } from '../../../services/Token/token-storage.service';
import { Toaster } from 'ngx-toast-notifications';
import { NgxSpinnerService } from 'ngx-spinner';
import {
  AbstractControl,
  FormBuilder,
  FormGroup,
  Validators,
} from '@angular/forms';
import InlineEditor from '@ckeditor/ckeditor5-build-inline';
import { environment } from '../../../../environments/environment';
@Component({
  selector: 'app-dealer-products',
  templateUrl: './dealer-products.component.html',
  styleUrls: ['./dealer-products.component.scss']
})
export class DealerProductsComponent implements OnInit {
  filterText:any = '';
  constructor(
    private ApiService: ApiService,
    private formBuilder: FormBuilder,
    private toaster: Toaster,
    private tokenStorage: TokenStorageService,
    private spinner: NgxSpinnerService
  ) {
    this.isLoggedIn = !!this.tokenStorage.getToken();
    if (this.isLoggedIn) {
      this.myInfo = this.tokenStorage.getUser();
    }
    this.getDealerProductList();
  }
  isLoggedIn: boolean = false;
  myInfo: any = '';
  @Input() page: any = '';
  ngOnInit(): void {
    this.sForm = this.formBuilder.group({
      id: [''],
      item_name: ['', Validators.required],
      company: [''],
      image: [''],
      image_2: [''],
      image_3: [''],
      image_4: [''],
      description: [''],
      mrp: ['0', Validators.required],
      discount: ['0'],
      delivery_charges: ['0'],
      is_rent: ['0'],
      rent_per_day: [''],
      security_for_rent: [''],
      delivery_charges_for_rent: [''],
      manufacturer_address: [''],
      category_id: [''],
      is_prescription_required: [''], 
      pack_size: [''], 
      status: ['', Validators.required],
    });

    this.getDealerEqpCategory();
  }
  editor: any = InlineEditor;
  ckconfig: any;
  BACK_END_MAPPING_URL_FOR_SAVE_IMG: string =
    environment.base_url + 'temp-image';
  pList: any = []; 
  info: any = []; 
  catList: any = []; 
  sForm: FormGroup | any;
  b1: boolean = false;
  editPage: boolean = false;
  get f1(): { [key: string]: AbstractControl } {
    return this.sForm.controls;
  }
  editInfo(id: any = '') {
    this.editPage = !this.editPage;
    if (id != '') {
      this.getDealerProductList(id);
    } else {
      this.sForm.controls['description'].setValue(
        '<p><strong>Details :</strong></p><p>&nbsp;</p><p>&nbsp;</p><p>&nbsp;</p><p>&nbsp;</p>'
      );
    }
  }
  onFileChange(e: any, type:any): void {
    const reader = new FileReader();

    if (e.target.files && e.target.files.length) {
      const file = e.target.files[0];
      reader.readAsDataURL(file);

      reader.onload = () => { 
        if(type == 'image'){
          this.sForm.patchValue({
            image: reader.result,
          }); 
        }else if(type == 'image_2'){
          this.sForm.patchValue({
            image_2: reader.result,
          }); 
        }else if(type == 'image_3'){
          this.sForm.patchValue({
            image_3: reader.result,
          }); 
        }else if(type == 'image_4'){
          this.sForm.patchValue({
            image_4: reader.result,
          }); 
        } 
      };
    }
  }
  getDealerEqpCategory(id:any = ''): void {
    this.ApiService.getDealerEqpCategory(id).subscribe(
      (data) => {
        if (data.status) {
          this.catList = data.data;
        } else {
          this.toaster.open({
            text: data.message,
            caption: 'Error',
            duration: 4000,
            type: 'danger',
          });
        }
      },
      (err) => {}
    );
  }
  getDealerProductList(id:any = ''): void {
    this.spinner.show();
    this.ApiService.getDealerProductList(id).subscribe(
      (data) => {
        if (data.status) {
          if(id == ''){
            this.pList = data.data;
          }else{
            this.info = data.data;
            this.sForm.controls['id'].setValue(this.info?.id);
            this.sForm.controls['item_name'].setValue(this.info?.item_name);
            this.sForm.controls['company'].setValue(this.info?.company);
            this.sForm.controls['description'].setValue(this.info?.description);
            this.sForm.controls['mrp'].setValue(this.info?.mrp);
            this.sForm.controls['discount'].setValue(this.info?.discount);
            this.sForm.controls['delivery_charges'].setValue(this.info?.delivery_charges);
            this.sForm.controls['is_rent'].setValue(this.info?.is_rent);
            this.sForm.controls['rent_per_day'].setValue(this.info?.rent_per_day);
            this.sForm.controls['security_for_rent'].setValue(this.info?.security_for_rent);
            this.sForm.controls['delivery_charges_for_rent'].setValue(this.info?.delivery_charges_for_rent);
            this.sForm.controls['manufacturer_address'].setValue(this.info?.manufacturer_address);
            this.sForm.controls['category_id'].setValue(this.info?.category_id);
            this.sForm.controls['is_prescription_required'].setValue(this.info?.is_prescription_required);
            this.sForm.controls['pack_size'].setValue(this.info?.pack_size);
             this.sForm.controls['status'].setValue(this.info?.status);
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
    this.ApiService.updateDealerProductInfo(this.sForm.value).subscribe(
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
          this.getDealerProductList();
          this.sForm.reset();
          this.sForm.controls['id'].setValue('');
          this.sForm.controls['rent_per_day'].setValue('');
          this.sForm.controls['security_for_rent'].setValue('');
          this.sForm.controls['delivery_charges_for_rent'].setValue('');
          this.sForm.controls['manufacturer_address'].setValue('');
          this.sForm.controls['category_id'].setValue('');
          this.sForm.controls['is_prescription_required'].setValue('');
          this.sForm.controls['pack_size'].setValue('');
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
