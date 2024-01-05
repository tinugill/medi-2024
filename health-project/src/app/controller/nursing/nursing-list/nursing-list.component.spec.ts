import { ComponentFixture, TestBed } from '@angular/core/testing';

import { NursingListComponent } from './nursing-list.component';

describe('NursingListComponent', () => {
  let component: NursingListComponent;
  let fixture: ComponentFixture<NursingListComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      declarations: [ NursingListComponent ]
    })
    .compileComponents();
  });

  beforeEach(() => {
    fixture = TestBed.createComponent(NursingListComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
