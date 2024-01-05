import { Component, OnInit } from '@angular/core';

@Component({
  selector: 'app-blood-bank-index',
  templateUrl: './blood-bank-index.component.html',
  styleUrls: ['./blood-bank-index.component.scss']
})
export class BloodBankIndexComponent implements OnInit {

  constructor() { }
  slides = [
    {img: "https://via.placeholder.com/600.png/09f/fff"},
    {img: "https://via.placeholder.com/600.png/021/fff"},
    {img: "https://via.placeholder.com/600.png/321/fff"},
    {img: "https://via.placeholder.com/600.png/422/fff"},
    {img: "https://via.placeholder.com/600.png/654/fff"}
  ];
  slideConfig = {
    "slidesToShow": 4,
    "slidesToScroll": 1,
    "dots": false,
    "autoplay": true,
    "infinite": false,
    "arrows": true,
    "responsive": [
      {
        breakpoint: 1024,
        settings: {
          slidesToShow: 4,
          slidesToScroll: 1,
          infinite: true,
          dots: false
        }
      },
      {
        breakpoint: 600,
        settings: {
          slidesToShow: 2,
          slidesToScroll: 1
        }
      },
      {
        breakpoint: 480,        
        settings: {
          slidesToShow: 2,
          slidesToScroll: 1,
          dots: false,
          autoplay: true,
          arrows: false,
        }
      }
    ]
  };
  ngOnInit(): void {
  }

}
