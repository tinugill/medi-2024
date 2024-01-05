import { ComponentFixture, TestBed } from '@angular/core/testing';

import { DashboardBloodbankComponent } from './dashboard-bloodbank.component';

describe('DashboardBloodbankComponent', () => {
  let component: DashboardBloodbankComponent;
  let fixture: ComponentFixture<DashboardBloodbankComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      declarations: [ DashboardBloodbankComponent ]
    })
    .compileComponents();
  });

  beforeEach(() => {
    fixture = TestBed.createComponent(DashboardBloodbankComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
