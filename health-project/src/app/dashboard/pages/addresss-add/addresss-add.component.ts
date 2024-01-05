import { Component, OnInit,Input, ViewChild, ElementRef, NgZone } from '@angular/core';
import { MouseEvent,MapsAPILoader } from '@agm/core';
import { ApiService } from '../../../services/Api/api.service';
import { EmitService } from '../../../services/Emit/emit.service';
import { Toaster } from 'ngx-toast-notifications';
import { NgxSpinnerService } from 'ngx-spinner';
interface marker {
	lat: number;
	lng: number;
	label?: string;
	draggable: boolean;
}
@Component({
  selector: 'app-addresss-add',
  templateUrl: './addresss-add.component.html',
  styleUrls: ['./addresss-add.component.scss']
})
export class AddresssAddComponent implements OnInit {

  constructor(private ApiService: ApiService,private toaster: Toaster,private mapsAPILoader: MapsAPILoader, private ngZone: NgZone, private emitService:EmitService, private spinner: NgxSpinnerService) { }
  @Input() address_type:any = '';
  @Input() updating_for:any = '';
  ngOnInit(): void { 
    this.mapsAPILoader.load().then(() => {
      this.setCurrentLocation();
      this.geoCoder = new google.maps.Geocoder;

      let autocomplete = new google.maps.places.Autocomplete(this.searchElementRef.nativeElement);
      autocomplete.addListener("place_changed", () => {
        this.ngZone.run(() => {
          //get the place result
          let place: google.maps.places.PlaceResult = autocomplete.getPlace();

          //verify result
          if (place.geometry === undefined || place.geometry === null) {
            return;
          }

          //set latitude, longitude and zoom
          this.markers.lat = place.geometry.location.lat();
          this.markers.lng = place.geometry.location.lng();
          this.getAddress(this.markers.lat, this.markers.lng);
          this.zoom = 12;
        });
      });
    });
    this.getAddressInfo();
  }
  address: string = '';
  private geoCoder : any;
  addressData:any = {
    full_address: '',
    address_type: '',
    updating_for: '',
    address : '',
    city: '',
    pincode: '',
    country: '',
    latitude: '',
    longitude: ''
  }

 
  zoom: number = 14;

  @ViewChild('search')
  public searchElementRef: ElementRef | any;

  private setCurrentLocation() {
    if ('geolocation' in navigator) {
      navigator.geolocation.getCurrentPosition((position) => {
        console.log('position',position.coords.accuracy);
        
        this.markers.lat = position.coords.latitude;
        this.markers.lng = position.coords.longitude;
        this.zoom = 15;
      });
    }
  }
  clickedMarker(label: string) {
    console.log(`clicked the marker: ${label}`)
  }
  mapClicked($event: MouseEvent) {
    // this.markers.push({
    //   lat: $event.coords.lat,
    //   lng: $event.coords.lng,
    //   draggable: true
    // });
  }
  markerDragEnd(m: marker, $event:MouseEvent) {
    console.log('dragEnd', m, $event);
    this.markers.lat = $event.coords.lat;
    this.markers.lng = $event.coords.lng;
    this.getAddress(this.markers.lat, this.markers.lng);
  }
  getAddress(latitude:any, longitude:any) {
    this.geoCoder.geocode({ 'location': { lat: latitude, lng: longitude } }, (results:any, status:any) => {
      console.log(results); 
      if (status === 'OK') {
        if (results[0]) {
          this.zoom = 14;
          this.addressData['latitude'] = latitude;
          this.addressData['longitude'] = longitude;
          this.address = results[0].formatted_address;
        
          if (results[0].address_components) {
            const result:any = {};
            results[0].address_components.map((address:any) => {
              console.log(address);
              
              if (address.types[0]) {
                result[address.types[0]] = address.long_name;
              }
            });
            console.log(result);
            this.addressData['country'] = result.country || '';
            this.addressData['city'] = result.administrative_area_level_2 || '';
            if(this.addressData['city'] == ''){
              this.addressData['city'] = result.locality || '';
            }
            this.addressData['pincode'] = result.postal_code || '';
          } 
          
          console.log(this.addressData);
          
        } else {
          window.alert('No results found');
        }
      } else {
        window.alert('Geocoder failed due to: ' + status);
      }

    });
  }
  
  markers: any = 
	  {
		  lat: 51.673858,
		  lng: 7.815982,
		  label: 'A',
		  draggable: true
	  };

  getAddressInfo(): void {
    this.ApiService.getAddressInfo(this.address_type, this.updating_for).subscribe(
      (data) => {
        if (data.status) {
          this.addressData = data.data;  
          this.addressData.full_address = this.address = data.data?.address;
        } else {
          this.toaster.open({
            text: data.message,
            caption: 'Error',
            duration: 4000,
            type: 'danger',
          });
        }
      },
      (err: any) => {}
    );
  }
  updateAddressInfo(): void {
    this.addressData['address_type'] = this.address_type;
    this.addressData['updating_for'] = this.updating_for;
    
    this.spinner.show();
    this.ApiService.updateAddressInfo(this.addressData).subscribe(
      (data) => {
        if (data.status) {
          this.toaster.open({
            text: data.message,
            caption: 'Success',
            duration: 4000,
            type: 'success',
          });
          this.emitService.hideUpdateAddressDalog(true);
          
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
      (err: any) => {
        
        this.spinner.hide();
      }
    );
  }
}
