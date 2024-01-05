import { ComponentFixture, TestBed } from '@angular/core/testing';

import { BloodBankDetailsComponent } from './blood-bank-details.component';

describe('BloodBankDetailsComponent', () => {
  let component: BloodBankDetailsComponent;
  let fixture: ComponentFixture<BloodBankDetailsComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      declarations: [ BloodBankDetailsComponent ]
    })
    .compileComponents();
  });

  beforeEach(() => {
    fixture = TestBed.createComponent(BloodBankDetailsComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
