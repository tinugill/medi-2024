import { ComponentFixture, TestBed } from '@angular/core/testing';

import { DashboardPharmacyComponent } from './dashboard-pharmacy.component';

describe('DashboardPharmacyComponent', () => {
  let component: DashboardPharmacyComponent;
  let fixture: ComponentFixture<DashboardPharmacyComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      declarations: [ DashboardPharmacyComponent ]
    })
    .compileComponents();
  });

  beforeEach(() => {
    fixture = TestBed.createComponent(DashboardPharmacyComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
