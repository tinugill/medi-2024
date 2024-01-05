import { ComponentFixture, TestBed } from '@angular/core/testing';

import { ListingstatusComponent } from './listingstatus.component';

describe('ListingstatusComponent', () => {
  let component: ListingstatusComponent;
  let fixture: ComponentFixture<ListingstatusComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      declarations: [ ListingstatusComponent ]
    })
    .compileComponents();
  });

  beforeEach(() => {
    fixture = TestBed.createComponent(ListingstatusComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
