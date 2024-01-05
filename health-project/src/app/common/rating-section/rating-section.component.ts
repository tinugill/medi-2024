import { Component, Input, OnInit, OnChanges, Output, EventEmitter, SimpleChanges } from '@angular/core';
import { Toaster } from 'ngx-toast-notifications'; 
import { NgbModal } from '@ng-bootstrap/ng-bootstrap';
import { ApiService } from '../../services/Api/api.service';
import { TokenStorageService } from '../../services/Token/token-storage.service'; 
@Component({
  selector: 'app-rating-section',
  templateUrl: './rating-section.component.html',
  styleUrls: ['./rating-section.component.scss']
})
export class RatingSectionComponent implements OnInit, OnChanges {

  constructor( private ApiService: ApiService,private toaster: Toaster,private modalService: NgbModal, private tokenStorage: TokenStorageService) {
     
    this.myInfo = this.tokenStorage.getUser();
    this.typeOfUser = this.myInfo.type;
     
  }
  typeOfUser: any = '';
  myInfo:any = {};
  @Input() count : any = 0;
  @Input() user_id : any = '';
  @Input() service_id : any = '';
  @Input() agent_type : any = '';
  @Output() reviewData:any = new EventEmitter();
  starFill : any = [];
  starUnFill : any = [];
  givenStar : any = 0;
  givenStarFill : any = [];
  givenStarUnFill : any = [];
  @Input() review:any = '';
  ngOnInit(): void {
    if(this.count == null){ this.count = 0;}
    this.setStars(); 
  }
  setStars(){ 
    this.givenStar = this.count; 
    this.starFill = Array(this.count).fill(0);
    this.starUnFill = Array(5-this.count).fill(0);
  }

  ngOnChanges(changes : SimpleChanges):void { 
    if(changes?.count?.currentValue){
      this.count = changes?.count?.currentValue;
      this.setStars();
    } 
    if(changes?.review?.currentValue){
      this.review = changes?.review?.currentValue;
    } 
  }
  changeStar(star:any){
    this.givenStarFill = Array(star).fill(0);
    this.givenStarUnFill = Array(5-star).fill(0);
  }
  openModel(modalName:any, star:any){
    if(this.typeOfUser == 'User'){
      this.givenStar = star;
      this.changeStar(star); 
    }else{
      this.getSingleReview();
    }
    this.modalService.open(modalName, {
      centered: true,
      size: 'sm',
      backdropClass: 'light-blue-backdrop',
    });
  }
  getSingleReview(){
    const reviewDataInfo = { user_id : this.user_id, service_id: this.service_id, type: this.agent_type };
    this.ApiService.getSingleReview(reviewDataInfo).subscribe(
      (data) => {
        if (data.status) {
           console.log(data.data);
           if(data.data){
            this.count = data.data.stars;
            this.givenStar = this.count;
            this.review = data.data.comment; 
           }else{
            this.count = 0;
            this.review = '';
           }
           this.changeStar(this.count); 
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
  submitReview(){
    const reviewDataInfo = { star: this.givenStar, review: this.review, user_id : this.user_id, service_id: this.service_id, type: this.agent_type };
    this.ApiService.submitReview(reviewDataInfo).subscribe(
      (data) => {
        if (data.status) {
          this.reviewData.emit(reviewDataInfo)
          this.modalService.dismissAll();
          this.toaster.open({
            text: 'Review submitted',
            caption: 'Success',
            duration: 4000,
            type: 'success',
          });
           
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
