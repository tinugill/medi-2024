import { ComponentFixture, TestBed } from '@angular/core/testing';

import { SetupDealerComponent } from './setup-dealer.component';

describe('SetupDealerComponent', () => {
  let component: SetupDealerComponent;
  let fixture: ComponentFixture<SetupDealerComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      declarations: [ SetupDealerComponent ]
    })
    .compileComponents();
  });

  beforeEach(() => {
    fixture = TestBed.createComponent(SetupDealerComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
