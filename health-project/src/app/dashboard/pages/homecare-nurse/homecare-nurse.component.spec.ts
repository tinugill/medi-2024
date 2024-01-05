import { ComponentFixture, TestBed } from '@angular/core/testing';

import { HomecareNurseComponent } from './homecare-nurse.component';

describe('HomecareNurseComponent', () => {
  let component: HomecareNurseComponent;
  let fixture: ComponentFixture<HomecareNurseComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      declarations: [ HomecareNurseComponent ]
    })
    .compileComponents();
  });

  beforeEach(() => {
    fixture = TestBed.createComponent(HomecareNurseComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
