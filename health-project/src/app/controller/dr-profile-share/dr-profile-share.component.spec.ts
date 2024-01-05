import { ComponentFixture, TestBed } from '@angular/core/testing';

import { DrProfileShareComponent } from './dr-profile-share.component';

describe('DrProfileShareComponent', () => {
  let component: DrProfileShareComponent;
  let fixture: ComponentFixture<DrProfileShareComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      declarations: [ DrProfileShareComponent ]
    })
    .compileComponents();
  });

  beforeEach(() => {
    fixture = TestBed.createComponent(DrProfileShareComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
