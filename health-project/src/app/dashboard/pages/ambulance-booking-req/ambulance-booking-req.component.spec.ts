import { ComponentFixture, TestBed } from '@angular/core/testing';

import { AmbulanceBookingReqComponent } from './ambulance-booking-req.component';

describe('AmbulanceBookingReqComponent', () => {
  let component: AmbulanceBookingReqComponent;
  let fixture: ComponentFixture<AmbulanceBookingReqComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      declarations: [ AmbulanceBookingReqComponent ]
    })
    .compileComponents();
  });

  beforeEach(() => {
    fixture = TestBed.createComponent(AmbulanceBookingReqComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
