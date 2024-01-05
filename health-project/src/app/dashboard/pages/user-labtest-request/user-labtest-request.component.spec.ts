import { ComponentFixture, TestBed } from '@angular/core/testing';

import { UserLabtestRequestComponent } from './user-labtest-request.component';

describe('UserLabtestRequestComponent', () => {
  let component: UserLabtestRequestComponent;
  let fixture: ComponentFixture<UserLabtestRequestComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      declarations: [ UserLabtestRequestComponent ]
    })
    .compileComponents();
  });

  beforeEach(() => {
    fixture = TestBed.createComponent(UserLabtestRequestComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
