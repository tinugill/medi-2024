import { ComponentFixture, TestBed } from '@angular/core/testing';

import { HomeNursingComponent } from './home-nursing.component';

describe('HomeNursingComponent', () => {
  let component: HomeNursingComponent;
  let fixture: ComponentFixture<HomeNursingComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      declarations: [ HomeNursingComponent ]
    })
    .compileComponents();
  });

  beforeEach(() => {
    fixture = TestBed.createComponent(HomeNursingComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
