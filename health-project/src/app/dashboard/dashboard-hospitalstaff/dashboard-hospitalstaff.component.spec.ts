import { ComponentFixture, TestBed } from '@angular/core/testing';

import { DashboardHospitalstaffComponent } from './dashboard-hospitalstaff.component';

describe('DashboardHospitalstaffComponent', () => {
  let component: DashboardHospitalstaffComponent;
  let fixture: ComponentFixture<DashboardHospitalstaffComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      declarations: [ DashboardHospitalstaffComponent ]
    })
    .compileComponents();
  });

  beforeEach(() => {
    fixture = TestBed.createComponent(DashboardHospitalstaffComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
