import { ComponentFixture, TestBed } from '@angular/core/testing';

import { DashboardHospitalComponent } from './dashboard-hospital.component';

describe('DashboardHospitalComponent', () => {
  let component: DashboardHospitalComponent;
  let fixture: ComponentFixture<DashboardHospitalComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      declarations: [ DashboardHospitalComponent ]
    })
    .compileComponents();
  });

  beforeEach(() => {
    fixture = TestBed.createComponent(DashboardHospitalComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
