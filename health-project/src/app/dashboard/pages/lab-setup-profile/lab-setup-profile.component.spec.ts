import { ComponentFixture, TestBed } from '@angular/core/testing';

import { LabSetupProfileComponent } from './lab-setup-profile.component';

describe('LabSetupProfileComponent', () => {
  let component: LabSetupProfileComponent;
  let fixture: ComponentFixture<LabSetupProfileComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      declarations: [ LabSetupProfileComponent ]
    })
    .compileComponents();
  });

  beforeEach(() => {
    fixture = TestBed.createComponent(LabSetupProfileComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
