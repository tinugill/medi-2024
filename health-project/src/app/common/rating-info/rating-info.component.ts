import { Component, Input, OnInit, SimpleChanges } from '@angular/core';
import { Router } from '@angular/router'; 
@Component({
  selector: 'app-rating-info',
  templateUrl: './rating-info.component.html',
  styleUrls: ['./rating-info.component.scss']
})
export class RatingInfoComponent implements OnInit {

  constructor(private router: Router) { }

  ngOnInit(): void {
    this.url =  this.router.url;
    this.giveStar();
  }
  ngOnChanges(changes: SimpleChanges){
    if(changes.star){
      this.star = changes.star.currentValue;

      setTimeout(() => {
        this.giveStar();
      }, 1000);
    }
  }
  giveStar(){
    this.star = parseInt(this.star);
    
    this.givenStarFill = Array(this.star).fill(0);
    this.givenStarUnFill = Array(5-this.star).fill(0);
  }
  @Input() star:any = 0;
  @Input() slug:any = '';
  givenStarFill:any = 0;
  givenStarUnFill:any = 0;
  url:any = '';
}
