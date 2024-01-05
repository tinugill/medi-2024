import { ComponentFixture, TestBed } from '@angular/core/testing';

import { DocAppointmentListComponent } from './doc-appointment-list.component';

describe('DocAppointmentListComponent', () => {
  let component: DocAppointmentListComponent;
  let fixture: ComponentFixture<DocAppointmentListComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      declarations: [ DocAppointmentListComponent ]
    })
    .compileComponents();
  });

  beforeEach(() => {
    fixture = TestBed.createComponent(DocAppointmentListComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
