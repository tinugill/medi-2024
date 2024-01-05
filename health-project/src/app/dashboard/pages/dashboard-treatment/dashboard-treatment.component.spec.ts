import { ComponentFixture, TestBed } from '@angular/core/testing';

import { DashboardTreatmentComponent } from './dashboard-treatment.component';

describe('DashboardTreatmentComponent', () => {
  let component: DashboardTreatmentComponent;
  let fixture: ComponentFixture<DashboardTreatmentComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      declarations: [ DashboardTreatmentComponent ]
    })
    .compileComponents();
  });

  beforeEach(() => {
    fixture = TestBed.createComponent(DashboardTreatmentComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
