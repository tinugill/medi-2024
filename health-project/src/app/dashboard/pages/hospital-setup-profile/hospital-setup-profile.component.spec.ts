import { ComponentFixture, TestBed } from '@angular/core/testing';

import { HospitalSetupProfileComponent } from './hospital-setup-profile.component';

describe('HospitalSetupProfileComponent', () => {
  let component: HospitalSetupProfileComponent;
  let fixture: ComponentFixture<HospitalSetupProfileComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      declarations: [ HospitalSetupProfileComponent ]
    })
    .compileComponents();
  });

  beforeEach(() => {
    fixture = TestBed.createComponent(HospitalSetupProfileComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
