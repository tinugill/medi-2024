import { ComponentFixture, TestBed } from '@angular/core/testing';

import { HospitalBannerComponent } from './hospital-banner.component';

describe('HospitalBannerComponent', () => {
  let component: HospitalBannerComponent;
  let fixture: ComponentFixture<HospitalBannerComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      declarations: [ HospitalBannerComponent ]
    })
    .compileComponents();
  });

  beforeEach(() => {
    fixture = TestBed.createComponent(HospitalBannerComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
