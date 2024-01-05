import { ComponentFixture, TestBed } from '@angular/core/testing';

import { HospitalDocListComponent } from './hospital-doc-list.component';

describe('HospitalDocListComponent', () => {
  let component: HospitalDocListComponent;
  let fixture: ComponentFixture<HospitalDocListComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      declarations: [ HospitalDocListComponent ]
    })
    .compileComponents();
  });

  beforeEach(() => {
    fixture = TestBed.createComponent(HospitalDocListComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
