import { ComponentFixture, TestBed } from '@angular/core/testing';

import { SetupNursingComponent } from './setup-nursing.component';

describe('SetupNursingComponent', () => {
  let component: SetupNursingComponent;
  let fixture: ComponentFixture<SetupNursingComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      declarations: [ SetupNursingComponent ]
    })
    .compileComponents();
  });

  beforeEach(() => {
    fixture = TestBed.createComponent(SetupNursingComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
