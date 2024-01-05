import { ComponentFixture, TestBed } from '@angular/core/testing';

import { AmbulanceDriverListComponent } from './ambulance-driver-list.component';

describe('AmbulanceDriverListComponent', () => {
  let component: AmbulanceDriverListComponent;
  let fixture: ComponentFixture<AmbulanceDriverListComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      declarations: [ AmbulanceDriverListComponent ]
    })
    .compileComponents();
  });

  beforeEach(() => {
    fixture = TestBed.createComponent(AmbulanceDriverListComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
