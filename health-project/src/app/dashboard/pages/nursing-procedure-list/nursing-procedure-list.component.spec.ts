import { ComponentFixture, TestBed } from '@angular/core/testing';

import { NursingProcedureListComponent } from './nursing-procedure-list.component';

describe('NursingProcedureListComponent', () => {
  let component: NursingProcedureListComponent;
  let fixture: ComponentFixture<NursingProcedureListComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      declarations: [ NursingProcedureListComponent ]
    })
    .compileComponents();
  });

  beforeEach(() => {
    fixture = TestBed.createComponent(NursingProcedureListComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
