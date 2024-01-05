import { Injectable } from '@angular/core';
import { TokenStorageService } from '../../services/Token/token-storage.service';
import { EmitService } from '../../services/Emit/emit.service';
import { Observable, of } from 'rxjs';
@Injectable({
  providedIn: 'root',
})
export class CartService {
  private cartItem: any = [];
  
  constructor(private tokenStorage: TokenStorageService, private emit: EmitService) {
    this.cartItem = this.tokenStorage.getSession('cart');
    console.log(this.cartItem);
    try {
      if (this.cartItem == null || this.cartItem == '') {
        this.cartItem = [];
      } else {
        this.cartItem = JSON.parse(this.cartItem);
      }
    } catch (error) {
      console.log(error);
      this.cartItem = [];
    }
  }
  clearList() {
    this.cartItem = [];
    this.tokenStorage.setSession('cart', JSON.stringify([]));
  }
  getList() {
    return this.cartItem;
  }
  countItem() {
    return this.cartItem?.length;
  }
  addItem(type: any, id: any, qty :any, is_equp:any = '', store_id: any = '') {
    this.cartItem = [...this.cartItem, { id: id, type: type, qty:qty, is_equp : is_equp, store_id: store_id }];
    this.tokenStorage.setSession('cart', JSON.stringify(this.cartItem));
    this.emit.cartCountData(this.cartItem?.length);
  }
  removeItem(type: any, id: any, is_equp:any = '') {
    this.cartItem.splice(
      this.cartItem.findIndex((a: any) => a.id == id && a.type == type && a.is_equp == is_equp),
      1
    );
    this.emit.cartCountData(this.cartItem?.length);
  }
  removeItemByIndex(index: any): Observable<any> { 
    this.cartItem.splice(index, 1);
    this.tokenStorage.setSession('cart', JSON.stringify(this.cartItem));
    console.log(this.cartItem);
    this.emit.cartCountData(this.cartItem?.length);
    return of(this.cartItem);
  }
 
  plusminus(index:any, action:any): Observable<any>{
    
    let qty = parseInt(this.cartItem[index].qty);
    if(action == 'minus'){
      qty = qty-1;
      if(qty < 1){
        this.removeItemByIndex(index).subscribe(
          (data) => {
             console.log(data); 
          },
          (err) => {}); 
      }else{
        this.cartItem[index].qty = qty;
        this.tokenStorage.setSession('cart', JSON.stringify(this.cartItem));
      }
    }else{
      this.cartItem[index].qty = parseInt(this.cartItem[index].qty) + 1;
      this.tokenStorage.setSession('cart', JSON.stringify(this.cartItem));
    }
    console.log(this.cartItem);
    this.emit.cartCountData(this.cartItem?.length);
    return of(this.cartItem);
  }
  findItem(type: any, id: any, is_equp:any = '') {
    let index: any = this.cartItem.findIndex(
      (a: any) => a.id == id && a.type == type && a?.is_equp == is_equp
    );
    if (index === -1) {
      return false;
    } else {
      return true;
    }
  }
  findItemAndUpdate(id: any, type: any, qty:any, is_equp = '') {
    let index: any = this.cartItem.findIndex(
      (a: any) => a.id == id && a.type == type && a?.is_equp == is_equp
    );
    if (index === -1) {
      return false;
    } else {
      this.cartItem[index].qty = qty;
      this.tokenStorage.setSession('cart', JSON.stringify(this.cartItem)); 
      return true;
    }
  }
}
