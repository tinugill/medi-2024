import { ComponentFixture, TestBed } from '@angular/core/testing';

import { BloodBankIndexComponent } from './blood-bank-index.component';

describe('BloodBankIndexComponent', () => {
  let component: BloodBankIndexComponent;
  let fixture: ComponentFixture<BloodBankIndexComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      declarations: [ BloodBankIndexComponent ]
    })
    .compileComponents();
  });

  beforeEach(() => {
    fixture = TestBed.createComponent(BloodBankIndexComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
