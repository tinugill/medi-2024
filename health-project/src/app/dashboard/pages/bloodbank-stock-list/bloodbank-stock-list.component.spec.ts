import { ComponentFixture, TestBed } from '@angular/core/testing';

import { BloodbankStockListComponent } from './bloodbank-stock-list.component';

describe('BloodbankStockListComponent', () => {
  let component: BloodbankStockListComponent;
  let fixture: ComponentFixture<BloodbankStockListComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      declarations: [ BloodbankStockListComponent ]
    })
    .compileComponents();
  });

  beforeEach(() => {
    fixture = TestBed.createComponent(BloodbankStockListComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
