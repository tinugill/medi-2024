import { Component, OnInit, ViewChild, QueryList } from '@angular/core';
import { ActivatedRoute, Router, Params } from '@angular/router';
import { TokenStorageService } from '../../services/Token/token-storage.service';
import { ApiService } from '../../services/Api/api.service';
import { Toaster } from 'ngx-toast-notifications';
import { NgbModal } from '@ng-bootstrap/ng-bootstrap';
import InlineEditor from '@ckeditor/ckeditor5-build-inline';
import { NgxSpinnerService } from "ngx-spinner";
import { environment } from '../../../environments/environment';
import {
  AbstractControl,
  FormBuilder,
  FormGroup,
  Validators,
  FormArray,
} from '@angular/forms';

import { Pipe, PipeTransform } from '@angular/core';

@Pipe({
  name: 'productFilter'
})
export class ProductFilterPipe implements PipeTransform {
  transform(products: any[], filterText: string, key: string): any[] {
    if (!filterText) {
      // If the input box is empty, show all products
      return products;
    }

    // If input is not empty, filter the products by matching the substring with product titles
    filterText = filterText.toLowerCase();
    return products.filter(product =>
      product[key].toLowerCase().includes(filterText)
    );
  }
}

@Component({
  selector: 'app-dashboard-pharmacy',
  templateUrl: './dashboard-pharmacy.component.html',
  styleUrls: ['./dashboard-pharmacy.component.scss'],
})
export class DashboardPharmacyComponent implements OnInit {
  constructor(
    private tokenStorage: TokenStorageService,
    private ApiService: ApiService,
    private formBuilder: FormBuilder,
    private toaster: Toaster,
    private router: Router,
    private modalService: NgbModal,
    private spinner : NgxSpinnerService
  ) {
    this.isLoggedIn = !!this.tokenStorage.getToken();
    if (this.isLoggedIn) {
      this.myInfo = this.tokenStorage.getUser();

      if (this.myInfo.type == 'User') {
        this.router.navigate(['/Patient-Record/record']);
        return;
      } else if (this.myInfo.type == 'Doctor') {
        this.router.navigate(['/dashboard/doctor']);
        return;
      } else if (this.myInfo.type == 'Hospitalstaff') {
        this.router.navigate(['/dashboard/staff']);
        return;
      } else if (this.myInfo.type == 'Hospital') {
        this.router.navigate(['/dashboard/hospital']);
        return;
      } else if (this.myInfo.type == 'Lab') {
        this.router.navigate(['/dashboard/lab']);
        return;
      } else if (this.myInfo.type == 'Bloodbank') {
        this.router.navigate(['/dashboard/bloodbank']);
        return;
      }else if (this.myInfo.type == 'Nursing') {
        this.router.navigate(['/dashboard/Nursing']);
        return;
      }else if (this.myInfo.type == 'Dealer') {
        this.router.navigate(['/dashboard/dealer']);
        return;
      }else if (this.myInfo.type == 'Ambulance') {
        this.router.navigate(['/dashboard/ambulance']);
        return;
      }
    } else {
      this.router.navigate(['/home']);
      return;
    }
     
  }
  filterText:any = '';
  ngOnInit(): void {
    this.form = this.formBuilder.group({
      id: [''],
      category_id: ['', Validators.required],
      sub_category_id: [''],
      title: ['', Validators.required],
      manufacturer_name: [''],
      formulation_id: [''],
      avaliblity: ['', Validators.required],
      prescription_required: ['', Validators.required],
      // benefits: [''],
      // ingredients: [''],
      // uses: [''],
      manufacturer_address: [''],
      brand_name: [''],
      expiry_type: ['on'],
      expiry_month: [''],
      expiry_year: [''],
      salt_name: [''],
      description: [''],
      variant_name: ['', Validators.required],
      mrp: ['', Validators.required],
      discount: ['', Validators.required],
      strength: [''],
      image: [''],
      image_2: [''],
      image_3: [''],
      image_4: [''],
      copy_from: [''],
    });

    
    this.getMyPharmacyProduct();
    this.getPharmacyCategory();
    this.getPharmacyFormulation();
    this.getPharmacyComposition();
    this.getPharmacyOrder();
    this.getDeliveryBoy();

    this.yearLoop = Array(100).fill(1).map((x,i)=>i);
  }

  get f(): { [key: string]: AbstractControl } {
    return this.form.controls;
  }

  yearLoop:any = [];

  isLoading: boolean = false;
  isLoggedIn: boolean = false;
  myInfo: any = ''; 
  page: any = 'my-products';
  productType: any = 'medicine';
  vpage: any = 'list';
  catList: any = [];
  subCatList: any = [];
  productList: any = [];
  productInfo: any = [];
  fmList: any = [];
  compList: any = [];
  orderList: any = [];
  sData: any = [];
  form: FormGroup | any; 
  submitted: boolean = false;
  sm: boolean = false;
  vimg: any = '';
  active_product_id: any = '';

  editor: any = InlineEditor;
  @ViewChild('myEditor') myEditor: QueryList<any> | any;
  ckconfig: any;
  BACK_END_MAPPING_URL_FOR_SAVE_IMG: string =
    environment.base_url + 'temp-image';

    listDb:any = [];
    getDeliveryBoy(): void {
      this.ApiService.getExecutive('').subscribe(
        (data) => {
          if (data.status) { 
              this.listDb = data.data; 
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
  changePage(page: any, type:any = '') {
    this.page = page;
    this.productType = type; 
     
    if(type != ''){
      this.productList = [];
      
      this.getMyPharmacyProduct();
    } 
    if(page == 'orders'){
      this.getPharmacyOrder();
    }
  }
  logout(): void {
    this.tokenStorage.signOut();
    this.router.navigate(['/home']);
    window.location.reload();
  }
  openVerticallyCentered(modalName: any) {
    this.modalService.open(modalName, {
      centered: true,
      size: 'sm',
      backdropClass: 'light-blue-backdrop',
    });
  } 
  editProduct(id: any = '') {
    this.form.reset();
    this.active_product_id = id;
    this.page = 'edit-product';
    if (id != '') {
      this.getMyPharmacyProduct(id);
    }
  }
  cancelProduct(): void {
    this.page = 'my-products';
  }
  getMyPharmacyProduct(id: any = ''): void { 
    this.isLoading = true;
    this.sData = [];
    this.ApiService.getMyPharmacyProduct(id, this.productType).subscribe(
      (data) => {
        this.isLoading = false;
        if (data.status) {
          if (id == '') {
            this.productList = data.data;
          } else {
            this.productInfo = data.data;
            this.form.controls['id'].setValue(this.productInfo.id);
            this.form.controls['variant_name'].setValue(this.productInfo.variant_name);
            this.form.controls['mrp'].setValue(this.productInfo.mrp);
            this.form.controls['discount'].setValue(this.productInfo.discount);
            this.form.controls['strength'].setValue(this.productInfo.strength);
            this.form.controls['category_id'].setValue(
              this.productInfo.category_id
            );
            this.getPharmacySubCategory(this.productInfo.category_id);
            // this.form.controls['sub_category_id'].setValue(
            //   this.productInfo.sub_category_id
            // );
            this.form.controls['formulation_id'].setValue(
              this.productInfo.formulation_id
            );
            this.form.controls['avaliblity'].setValue(
              this.productInfo.avaliblity
            );
            this.form.controls['prescription_required'].setValue(
              this.productInfo.prescription_required
            );
            this.form.controls['title'].setValue(this.productInfo.title);
            this.form.controls['manufacturer_name'].setValue(
              this.productInfo.manufacturer_name
            );
            this.form.controls['manufacturer_address'].setValue(
              this.productInfo.manufacturer_address
            );
            // this.form.controls['benefits'].setValue(this.productInfo.benefits);
            // this.form.controls['ingredients'].setValue(
            //   this.productInfo.ingredients
            // );
            // this.form.controls['uses'].setValue(this.productInfo.uses);
            this.form.controls['description'].setValue(
              this.productInfo.description
            );
            this.form.controls['salt_name'].setValue(
              this.productInfo.salt_name
            );
            this.form.controls['expiry_type'].setValue(
              this.productInfo.expiry_type
            );
            this.form.controls['expiry_month'].setValue(
              this.productInfo.expiry_month
            );
            this.form.controls['expiry_year'].setValue(
              this.productInfo.expiry_year
            );
            this.form.controls['brand_name'].setValue(
              this.productInfo.brand_name
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
      },
      (err) => {}
    );
  }
  updateEC(e:any, id:any, type:any){ 
    this.spinner.show();
    this.ApiService.updatePharmasyEc(id, e.value, type).subscribe(
      (data) => {
        if (data.status) {
          this.toaster.open({
            text: data.message,
            caption: 'Success',
            duration: 4000,
            type: 'success',
          });
          this.getPharmacyOrder();
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
  getPharmacyComposition(): void {
    this.ApiService.getPharmacyComposition().subscribe(
      (data) => {
        if (data.status) {
          this.compList = data.data;
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
  getPharmacyFormulation(): void {
    this.ApiService.getPharmacyFormulation().subscribe(
      (data) => {
        if (data.status) {
          this.fmList = data.data;
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
  getPharmacyCategory(): void {
    this.ApiService.getPharmacyCategory().subscribe(
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
  getPharmacyOrder(): void {
    this.ApiService.getPharmacyOrder().subscribe(
      (data) => {
        if (data.status) {
          this.orderList = data.data;
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
  catChange(e: any): void {
    this.getPharmacySubCategory(e.value);
  } 
  getPharmacySubCategory(cat_id: any): void {
    this.ApiService.getPharmacySubCategory('', cat_id).subscribe(
      (data) => {
        if (data.status) {
          this.subCatList = data.data;
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

   
  onFileChange(e: any, filename:any): void {
    const reader = new FileReader();

    if (e.target.files && e.target.files.length) {
      const file = e.target.files[0];
      reader.readAsDataURL(file);

      reader.onload = () => {
        if(filename == 'image'){
          this.form.patchValue({image: reader.result});
        }else if(filename == 'image_2'){
          this.form.patchValue({image_2: reader.result});
        }else if(filename == 'image_3'){
          this.form.patchValue({image_3: reader.result});
        }else if(filename == 'image_4'){
          this.form.patchValue({image_4: reader.result});
        }
        
      };
    }
  }
  fillProduct(data:any){ 
    data = {...data, copy_from : data.id}; 
    
    this.productInfo = {...data};
    delete data.id;
    delete data.slug;
    data.image = '';
    data.image_2 = '';
    data.image_3 = '';
    data.image_4 = '';
    this.form.patchValue(data);
    console.log('data',data);
    
    this.sData = [];
  }
  productChange(event:any){
    let s = event.target.value;
    if(/\s/g.test(s) || s.length > 2){
      this.ApiService.searchMyProductMedi(s, this.productType).subscribe(
        (data) => {
          if (data.status) {
            this.sData = data.data; 
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
  }
  onSubmit(): void {
    
    this.submitted = true;
    if (this.form.invalid) {
      console.log(this.form);
      
      this.toaster.open({
        text: 'All fields required',
        caption: 'Success',
        duration: 4000,
        type: 'success',
      });
      return;
    }
    this.spinner.show();
    this.ApiService.addMyPharmacyProduct(this.form.value, this.productType).subscribe(
      (data) => {
        if (data.status) {
          this.toaster.open({
            text: data.message,
            caption: 'Success',
            duration: 4000,
            type: 'success',
          }); 
          this.getMyPharmacyProduct();
          this.active_product_id = data.data.id;
          this.submitted = false;
          this.page = 'my-products'
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
        this.toaster.open({
          text: 'Server connection failed',
          caption: 'Message',
          duration: 4000,
          type: 'danger',
        });
      }
    );
  }
  
  changeStatus(e:any, id:any, type:any){ 
    this.updateData(id,e.value,type)
  }
  updateData(id:any,status:any = '',type:any = ''){
    this.ApiService.getProductOrderUpdate(id, {status :status, type:type}).subscribe(
      (data) => {
        if (data.status) {
          this.toaster.open({
            text: data.message,
            caption: 'Success',
            duration: 4000,
            type: 'success',
          });
          this.getPharmacyOrder();
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
}
