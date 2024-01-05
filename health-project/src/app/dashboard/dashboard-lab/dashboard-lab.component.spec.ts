import { ComponentFixture, TestBed } from '@angular/core/testing';

import { DashboardLabComponent } from './dashboard-lab.component';

describe('DashboardLabComponent', () => {
  let component: DashboardLabComponent;
  let fixture: ComponentFixture<DashboardLabComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      declarations: [ DashboardLabComponent ]
    })
    .compileComponents();
  });

  beforeEach(() => {
    fixture = TestBed.createComponent(DashboardLabComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
