import { ComponentFixture, TestBed } from '@angular/core/testing';

import { NursingInfoComponent } from './nursing-info.component';

describe('NursingInfoComponent', () => {
  let component: NursingInfoComponent;
  let fixture: ComponentFixture<NursingInfoComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      declarations: [ NursingInfoComponent ]
    })
    .compileComponents();
  });

  beforeEach(() => {
    fixture = TestBed.createComponent(NursingInfoComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
