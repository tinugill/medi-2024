import { ComponentFixture, TestBed } from '@angular/core/testing';

import { DashboardNursingComponent } from './dashboard-nursing.component';

describe('DashboardNursingComponent', () => {
  let component: DashboardNursingComponent;
  let fixture: ComponentFixture<DashboardNursingComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      declarations: [ DashboardNursingComponent ]
    })
    .compileComponents();
  });

  beforeEach(() => {
    fixture = TestBed.createComponent(DashboardNursingComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
