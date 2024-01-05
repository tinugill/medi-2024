import { ComponentFixture, TestBed } from '@angular/core/testing';

import { DocTreatmentRequestComponent } from './doc-treatment-request.component';

describe('DocTreatmentRequestComponent', () => {
  let component: DocTreatmentRequestComponent;
  let fixture: ComponentFixture<DocTreatmentRequestComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      declarations: [ DocTreatmentRequestComponent ]
    })
    .compileComponents();
  });

  beforeEach(() => {
    fixture = TestBed.createComponent(DocTreatmentRequestComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
