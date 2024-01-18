import { Component, OnInit } from '@angular/core';
import { ActivatedRoute, Router, Params } from '@angular/router';
import { TokenStorageService } from '../../../services/Token/token-storage.service'; 
import { ApiService } from '../../../services/Api/api.service';
import { Toaster } from 'ngx-toast-notifications'; 

import { ZoomMtg } from '@zoomus/websdk';
ZoomMtg.setZoomJSLib('https://source.zoom.us/2.16.0/lib', '/av');

ZoomMtg.preLoadWasm();
ZoomMtg.prepareWebSDK();
// //ZoomMtg.prepareJssdk();
  
ZoomMtg.i18n.load('en-US');
ZoomMtg.i18n.reload('en-US');
@Component({
  selector: 'app-video-zoom',
  templateUrl: './video-zoom.component.html',
  styleUrls: ['./video-zoom.component.scss']
})
export class VideoZoomComponent implements OnInit {

  constructor(
    private tokenStorage: TokenStorageService, 
    private ApiService: ApiService,
    private _Activatedroute: ActivatedRoute,
    private router: Router,
    private toaster: Toaster
  ) {
    
    
  }

  ngOnInit(): void {
    if (navigator.mediaDevices && navigator.mediaDevices.getUserMedia) {
      // Ask for permission to access the camera
      navigator.mediaDevices.getUserMedia({ video: true, audio: true})
          .then(function (stream) {
              // User granted permission
              // You can now use the stream to do something with the camera
              // For example, display it in a video element:
              // const videoElement = document.getElementById('video');
              // videoElement.srcObject = stream;
          })
          .catch(function (error) {
              // User denied permission or there was an error
              console.error('Error accessing camera:', error);
          });
  } else {
      console.error('getUserMedia is not supported in this browser');
  }
    this._Activatedroute.paramMap.subscribe((params) => {
      this.msgId = params.get('msgId');
      this.appointment_id = params.get('appointment_id');
      this.msg = params.get('msg');
      if (this.appointment_id != '' && this.msgId && this.msg) {
        this.leaveUrl = this.leaveUrl + this.appointment_id;
        this.getZoomDetails(this.appointment_id, this.msgId, this.msg);
      }
    }); 
  }
  msgId:any = '';
  msg:any = '';
  appointment_id:any = '';
  info:any = [];

  sdkKey = '';
  meetingNumber:any = '';
  role:any = 0;
  leaveUrl = 'http://topmedz.com/chat?aid=';
  userName:any = '';
  userEmail:any = '';
  passWord:any = '';
  //registrantToken = 'eyJ0eXAiOiJKV1QiLCJzdiI6IjAwMDAwMSIsInptX3NrbSI6InptX28ybSIsImFsZyI6IkhTMjU2In0.eyJhdWQiOiJjbGllbnRzbSIsInVpZCI6InR3c1UzUldRU01xak1XcmVrczZxWEEiLCJpc3MiOiJ3ZWIiLCJzayI6IjM0MzE4MTA2ODY4OTg5MDc3NTQiLCJzdHkiOjEwMCwid';
  signature:any = '';
  registrantToken:any = '';
  startMeetingNow() { 
    let zoomrt = document.getElementById('zmmtg-root') as any;
    zoomrt.style.display = 'block'

    ZoomMtg.init({
      leaveUrl: this.leaveUrl,
      success: (success:any) => {
        console.log(success)
        ZoomMtg.join({
          signature: this.signature,
          meetingNumber: this.meetingNumber,
          userName: this.userName,
          sdkKey: this.sdkKey,
          userEmail: this.userEmail,
          passWord: this.passWord, 
          success: (success:any) => {
            console.log(success)
          },
          error: (error:any) => {
            console.log(error)
          }
        })
      },
      error: (error:any) => {
        console.log(error)
      }
    })
  }
  zoomUrl:any = '';
  callUpdateSecret(id:any,token:any){
    this.ApiService.updateMeetingSecret(id, token).subscribe(
      (data) => {})
  }
  getZoomDetails(appointment_id:any, msgId:any, msg:any):any{
    this.ApiService.getZoomDetails(appointment_id, msgId, msg).subscribe(
      (data) => {
        if (data.status) { 
          this.info = data.data; 
          
          if(this.info.secret == ''){
            let config = {
              meetingNumber: this.info.meeting_id,
              sdkKey: 'IaZ4cjjuzDD6Hwq7faEhAEu5Rx1IjWmHlzA5',
              sdkSecret: 'oWnC4AkijQ8VRcmiYDFUyEJVc9QDYQ8b7Vks',
              role: '1', 
            }
            console.log('config',config);
            this.info.secret = ZoomMtg.generateSDKSignature(config);
            this.callUpdateSecret(this.info.id,this.info.secret);
          }
          
          
          console.log(this.info.secret);
          

          this.signature = this.info.secret;
          this.registrantToken = this.info.token;
          this.passWord = this.info.password;
          this.userEmail = this.info.host_email;
          this.userName = this.info.topic;
          this.role = this.info.role;
          this.meetingNumber = this.info.meeting_id;
          this.sdkKey = 'IaZ4cjjuzDD6Hwq7faEhAEu5Rx1IjWmHlzA5';
          this.startMeetingNow();
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
