import { ComponentFixture, TestBed } from '@angular/core/testing';

import { DashboardDealerComponent } from './dashboard-dealer.component';

describe('DashboardDealerComponent', () => {
  let component: DashboardDealerComponent;
  let fixture: ComponentFixture<DashboardDealerComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      declarations: [ DashboardDealerComponent ]
    })
    .compileComponents();
  });

  beforeEach(() => {
    fixture = TestBed.createComponent(DashboardDealerComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
