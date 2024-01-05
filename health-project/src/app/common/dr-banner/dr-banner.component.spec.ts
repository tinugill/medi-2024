import { ComponentFixture, TestBed } from '@angular/core/testing';

import { DrBannerComponent } from './dr-banner.component';

describe('DrBannerComponent', () => {
  let component: DrBannerComponent;
  let fixture: ComponentFixture<DrBannerComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      declarations: [ DrBannerComponent ]
    })
    .compileComponents();
  });

  beforeEach(() => {
    fixture = TestBed.createComponent(DrBannerComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
