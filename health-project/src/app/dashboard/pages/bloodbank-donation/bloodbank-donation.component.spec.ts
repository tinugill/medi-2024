import { ComponentFixture, TestBed } from '@angular/core/testing';

import { BloodbankDonationComponent } from './bloodbank-donation.component';

describe('BloodbankDonationComponent', () => {
  let component: BloodbankDonationComponent;
  let fixture: ComponentFixture<BloodbankDonationComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      declarations: [ BloodbankDonationComponent ]
    })
    .compileComponents();
  });

  beforeEach(() => {
    fixture = TestBed.createComponent(BloodbankDonationComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
