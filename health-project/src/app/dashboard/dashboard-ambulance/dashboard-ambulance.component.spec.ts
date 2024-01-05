import { ComponentFixture, TestBed } from '@angular/core/testing';

import { DashboardAmbulanceComponent } from './dashboard-ambulance.component';

describe('DashboardAmbulanceComponent', () => {
  let component: DashboardAmbulanceComponent;
  let fixture: ComponentFixture<DashboardAmbulanceComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      declarations: [ DashboardAmbulanceComponent ]
    })
    .compileComponents();
  });

  beforeEach(() => {
    fixture = TestBed.createComponent(DashboardAmbulanceComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
