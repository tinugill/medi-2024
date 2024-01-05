import { Injectable, Output, EventEmitter } from '@angular/core';
import { TokenStorageService } from '../Token/token-storage.service';

@Injectable({
  providedIn: 'root'
})
export class EmitService {

  constructor(private tokenStorage: TokenStorageService) { }
  @Output() changePincode: EventEmitter<any> = new EventEmitter();
  @Output() openPincodeDalog: EventEmitter<any> = new EventEmitter();
  @Output() hideAddressDalog: EventEmitter<any> = new EventEmitter();
  @Output() cartCount: EventEmitter<any> = new EventEmitter();
  @Output() indOrBue: EventEmitter<any> = new EventEmitter();

  setChangeIndOrBue(val:any){
    const myInfo = this.tokenStorage.getUser();
    myInfo.buero_type = val;
    
    this.tokenStorage.saveUser(myInfo)
    this.indOrBue.emit(val);
  }
  setChangePincode(pincode:any){
    this.changePincode.emit(pincode);
  }
  hideUpdateAddressDalog(flag:any){
    this.hideAddressDalog.emit(flag);
  }
  openPincodeDalogPopup(flag:any){
    this.openPincodeDalog.emit(flag);
  }
  cartCountData(count:any){
    this.cartCount.emit(count);
  }
}
