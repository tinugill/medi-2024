import { ComponentFixture, TestBed } from '@angular/core/testing';

import { NursingCareRequestComponent } from './nursing-care-request.component';

describe('NursingCareRequestComponent', () => {
  let component: NursingCareRequestComponent;
  let fixture: ComponentFixture<NursingCareRequestComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      declarations: [ NursingCareRequestComponent ]
    })
    .compileComponents();
  });

  beforeEach(() => {
    fixture = TestBed.createComponent(NursingCareRequestComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
