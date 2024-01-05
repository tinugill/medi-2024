import { ComponentFixture, TestBed } from '@angular/core/testing';

import { AmbulanceSetupProfileComponent } from './ambulance-setup-profile.component';

describe('AmbulanceSetupProfileComponent', () => {
  let component: AmbulanceSetupProfileComponent;
  let fixture: ComponentFixture<AmbulanceSetupProfileComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      declarations: [ AmbulanceSetupProfileComponent ]
    })
    .compileComponents();
  });

  beforeEach(() => {
    fixture = TestBed.createComponent(AmbulanceSetupProfileComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
