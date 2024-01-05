import { ComponentFixture, TestBed } from '@angular/core/testing';

import { LabTestRequestComponent } from './lab-test-request.component';

describe('LabTestRequestComponent', () => {
  let component: LabTestRequestComponent;
  let fixture: ComponentFixture<LabTestRequestComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      declarations: [ LabTestRequestComponent ]
    })
    .compileComponents();
  });

  beforeEach(() => {
    fixture = TestBed.createComponent(LabTestRequestComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
