import { ComponentFixture, TestBed } from '@angular/core/testing';

import { PharmacySetupProfileComponent } from './pharmacy-setup-profile.component';

describe('PharmacySetupProfileComponent', () => {
  let component: PharmacySetupProfileComponent;
  let fixture: ComponentFixture<PharmacySetupProfileComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      declarations: [ PharmacySetupProfileComponent ]
    })
    .compileComponents();
  });

  beforeEach(() => {
    fixture = TestBed.createComponent(PharmacySetupProfileComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
