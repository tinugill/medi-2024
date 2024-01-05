import { ComponentFixture, TestBed } from '@angular/core/testing';

import { AmbulanceInfoComponent } from './ambulance-info.component';

describe('AmbulanceInfoComponent', () => {
  let component: AmbulanceInfoComponent;
  let fixture: ComponentFixture<AmbulanceInfoComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      declarations: [ AmbulanceInfoComponent ]
    })
    .compileComponents();
  });

  beforeEach(() => {
    fixture = TestBed.createComponent(AmbulanceInfoComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
