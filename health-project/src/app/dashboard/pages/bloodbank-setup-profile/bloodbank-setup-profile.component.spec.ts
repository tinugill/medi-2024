import { ComponentFixture, TestBed } from '@angular/core/testing';

import { BloodbankSetupProfileComponent } from './bloodbank-setup-profile.component';

describe('BloodbankSetupProfileComponent', () => {
  let component: BloodbankSetupProfileComponent;
  let fixture: ComponentFixture<BloodbankSetupProfileComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      declarations: [ BloodbankSetupProfileComponent ]
    })
    .compileComponents();
  });

  beforeEach(() => {
    fixture = TestBed.createComponent(BloodbankSetupProfileComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
