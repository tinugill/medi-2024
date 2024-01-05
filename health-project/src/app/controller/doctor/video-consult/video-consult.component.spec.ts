import { ComponentFixture, TestBed } from '@angular/core/testing';

import { VideoConsultComponent } from './video-consult.component';

describe('VideoConsultComponent', () => {
  let component: VideoConsultComponent;
  let fixture: ComponentFixture<VideoConsultComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      declarations: [ VideoConsultComponent ]
    })
    .compileComponents();
  });

  beforeEach(() => {
    fixture = TestBed.createComponent(VideoConsultComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
