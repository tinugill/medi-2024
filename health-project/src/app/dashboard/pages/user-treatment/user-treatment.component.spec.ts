import { ComponentFixture, TestBed } from '@angular/core/testing';

import { UserTreatmentComponent } from './user-treatment.component';

describe('UserTreatmentComponent', () => {
  let component: UserTreatmentComponent;
  let fixture: ComponentFixture<UserTreatmentComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      declarations: [ UserTreatmentComponent ]
    })
    .compileComponents();
  });

  beforeEach(() => {
    fixture = TestBed.createComponent(UserTreatmentComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
