import { Component, Inject, OnInit } from '@angular/core';
import {MatDialog, MatDialogRef, MAT_DIALOG_DATA} from '@angular/material/dialog';
import { Toaster } from 'ngx-toast-notifications';
import { TokenStorageService } from './services/Token/token-storage.service';
import { ApiService } from './services/Api/api.service';
import { EmitService } from './services/Emit/emit.service';
export interface DialogData {
  pincode: string; 
}
@Component({
  selector: 'app-root',
  templateUrl: './app.component.html',
  styleUrls: ['./app.component.scss']
})
export class AppComponent implements OnInit{
  constructor(private toaster: Toaster,public dialog: MatDialog, private emitService:EmitService, private ApiService: ApiService, private tokenService : TokenStorageService) {}
  pincode:any = '';
  locData:any = [];
  ngOnInit():void{
    this.emitService.openPincodeDalog.subscribe((flag:any)=>{
      if(flag){
        this.openDialog();
      }
    })
  }
  openDialog(): void {
    const dialogRef = this.dialog.open(DialogOverviewExampleDialog, {
      width: '350px',
      data: {pincode: this.pincode},
    });

    dialogRef.afterClosed().subscribe(result => {
      if(result != ''){
        this.pincode = result;
        this.updateLatLng();
      }
      console.log('The dialog was closed',result); 
    });
  }
  updateLatLng(){
    this.ApiService.getLatLngPincode(this.pincode).subscribe(
      (data) => {
        if (data.status) {
          this.locData = data.data;  
          this.tokenService.setSession('pincode',this.locData.pincode);
          this.emitService.setChangePincode(this.locData.pincode);
        } else { 
          this.toaster.open({
            text: data.message,
            caption: 'Error',
            duration: 4000,
            type: 'danger',
          });
          this.openDialog();
        }
      },
      (err) => {
        this.toaster.open({
          text: err.error.message,
          caption: 'Message',
          duration: 4000,
          type: 'danger',
        });
        this.openDialog();
      }
    );
  }
}

@Component({
  selector: 'dialog-overview-example-dialog',
  templateUrl: 'dialog-overview-example-dialog.html', 
  styleUrls: ['./app.component.scss']
})
export class DialogOverviewExampleDialog {
  constructor(
    public dialogRef: MatDialogRef<DialogOverviewExampleDialog>,
    @Inject(MAT_DIALOG_DATA) public data: DialogData,private toaster: Toaster
  ) {
    dialogRef.disableClose = true;
  }

  onNoClick(): void {
    this.dialogRef.close();
  }
  sendData(): void {
    if(this.data.pincode == ''){
      this.toaster.open({
        text: 'Enter Pinode First',
        caption: 'Message',
        duration: 4000,
        type: 'danger',
      });
    }else{
      this.dialogRef.close(this.data.pincode);
    }
    
  }
 
}
