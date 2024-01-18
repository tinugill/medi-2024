import { AfterViewChecked, AfterViewInit, Component, OnInit,ViewChild } from '@angular/core';
import { TokenStorageService } from '../../services/Token/token-storage.service';
import { EmitService } from '../../services/Emit/emit.service';
import { Toaster } from 'ngx-toast-notifications';
import { Router } from '@angular/router';
import { ActivatedRoute } from '@angular/router';
import { ApiService } from '../../services/Api/api.service';
import {
  AbstractControl,
  FormBuilder,
  FormGroup,
  Validators, 
} from '@angular/forms';
@Component({
  selector: 'app-header',
  templateUrl: './header.component.html',
  styleUrls: ['./header.component.scss'],
})
export class HeaderComponent implements OnInit, AfterViewInit {
  constructor(private tokenStorage: TokenStorageService, private emitService:EmitService,private formBuilder: FormBuilder,private toaster: Toaster,private _Activatedroute: ActivatedRoute, private ApiService: ApiService) {
    this.isLoggedIn = !!this.tokenStorage.getToken();
    if (this.isLoggedIn) {
      this.myInfo = this.tokenStorage.getUser();
    }
    this.pincode = this.tokenStorage.getSession('pincode');
    this.emitService.changePincode.subscribe((pincode:any)=>{
      if(pincode != ''){
        this.pincode = pincode;
      }
    });
    this.emitService.cartCount.subscribe((count:any)=>{ 
        this.cartCount = count; 
    });

    this.form = this.formBuilder.group({
      pincode: ['', Validators.required],
      searchby: ['Hospital', Validators.required],
      search: ['', Validators.required],
    });

    this._Activatedroute.paramMap.subscribe((params) => {
      let searchby = this._Activatedroute.snapshot.queryParams['searchby'];
      let q = this._Activatedroute.snapshot.queryParams['q'];
      let sub = this._Activatedroute.snapshot.queryParams['sub'];
      let page = this._Activatedroute.snapshot.queryParams['page'];
      if (searchby != '' && searchby != undefined) {
        this.searchby = searchby;
      } 
      if (sub != '' && sub != undefined) {
        this.searchby2 = sub;
      } 
      this.searchByChange();
      if (q != '' && q != undefined) {
        this.search = q;
      } 
      if (page != '' && page != undefined) {
        this.page = page;
      } 
    });

    let cartItem:any = this.tokenStorage.getSession('cart'); 
    try {
      if (cartItem == null || cartItem == '') {
        cartItem = [];
      } else {
        cartItem = JSON.parse(cartItem);
      }
    } catch (error) { 
      cartItem = [];
    }
    this.cartCount = cartItem?.length;
  } 
  cartCount:any = 0;
  get f(): { [key: string]: AbstractControl } {
    return this.form.controls;
  }
  ngAfterViewInit() { 
    const sideNav:any = document.querySelector('#sideNav');
    const menuIcon:any = document.querySelector('#menuIcon'); 
    sideNav.addEventListener('click', () => { 
      const menus = document.querySelectorAll('.menu');
 
      menus.forEach(menu => {
        menu.classList.toggle('add-menu');
      });

      menuIcon.classList.toggle('fa-bars');
      menuIcon.classList.toggle('fa-times');
    });
    
  }
  openPincodeDialog(){
    this.emitService.openPincodeDalogPopup(true);
  }
  searchNow(){
    if(this.page == '' || this.page == 'home'){
      this.toaster.open({
        text: 'Select searchby',
        caption: 'Error',
        duration: 4000,
        type: 'danger',
      });
      return;
    }
    if(this.searchby == 'Ambulance'){
      if(this.searchby2 == 'Type'){
        this.search += '&type=ambulance';
      } 
    } 
    
    if(this.searchby == 'Medicine'){
      window.location.href = this.page+'?searchby='+this.searchby+"&q="+this.search+"&page="+encodeURIComponent(this.page);
    }else{
      window.location.href = this.page+'?searchby='+this.searchby+"&sub="+this.searchby2+"&q="+this.search;
    }
    
  }
  searchByChange(){
    this.searchData = [];
    
    if(this.searchby == 'Hospital'){
      this.page = "hospital-list";
      this.searchby2 = 'Name';
    }else if(this.searchby == 'Doctor'){ 
      this.page = "doctor-list";
      this.searchby2 = 'Name';
    }else if(this.searchby == 'Procedures'){
      this.page = "doctor-list";
    }else if(this.searchby == 'Treatment'){
      this.page = "doctor-list";
    }else if(this.searchby == 'Illness'){
      this.page = "doctor-list";
    }else if(this.searchby == 'Symptoms'){
      this.page = "doctor-list";
    }else if(this.searchby == 'Pharmacy'){
      this.searchby2 = '';
      this.page = "pharmacy-list";
    }else if(this.searchby == 'Medicine'){
      this.searchby2 = '';
      this.page = "medicine-list";
    }else if(this.searchby == 'Lab'){
      this.searchby2 = 'Name';
      this.page = "lab/lab-list";
    }else if(this.searchby == 'LabTest'){
      this.page = "lab/lab-list";
    }else if(this.searchby == 'Bloodbank'){
      this.searchby2 = 'Name';
      this.page = "blood-bank/blood-bank-list";
    }else if(this.searchby == 'Equipment'){
      this.searchby2 = '';
       this.page = "equipment/equipment-list";
    }else if(this.searchby == 'Homecare'){
      this.searchby2 = 'Name';
      this.page = "home-nursing/list";
    }else if(this.searchby == 'Ambulance'){
      this.searchby2 = 'Name';
      this.page = "ambulance/list";
    }else if(this.searchby == 'AmbulanceType'){
      this.page = "ambulance/list";
    }else{
      this.searchby2 = '';
    }
  }
  selectValue(val:any){
    this.searchData = [];  
    this.search = val;
    this.searchNow();
  }
  changeVal(){
    let cat = this.searchby;
    let sub_cat = this.searchby2;
    let search = this.search;
    this.ApiService.getAutouggestion(cat, sub_cat, search).subscribe(
      (data) => {
        if (data.status) {
          this.searchData = data.data; 
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
  form: FormGroup | any;
  submitted: boolean = false;
  isLoggedIn: boolean = false;
  myInfo: any = '';
  page: any = 'hospital-list';
  searchData:any = [];
  pincode: any = '';
  searchby: any = 'Hospital';
  searchby2: any = 'Name';
  search: any = '';
  ngOnInit(): void {}

 
 
}
