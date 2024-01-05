import { ComponentFixture, TestBed } from '@angular/core/testing';

import { DealerProductOrdersComponent } from './dealer-product-orders.component';

describe('DealerProductOrdersComponent', () => {
  let component: DealerProductOrdersComponent;
  let fixture: ComponentFixture<DealerProductOrdersComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      declarations: [ DealerProductOrdersComponent ]
    })
    .compileComponents();
  });

  beforeEach(() => {
    fixture = TestBed.createComponent(DealerProductOrdersComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
