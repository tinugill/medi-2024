import { ComponentFixture, TestBed } from '@angular/core/testing';

import { DocSetupProfileComponent } from './doc-setup-profile.component';

describe('DocSetupProfileComponent', () => {
  let component: DocSetupProfileComponent;
  let fixture: ComponentFixture<DocSetupProfileComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      declarations: [ DocSetupProfileComponent ]
    })
    .compileComponents();
  });

  beforeEach(() => {
    fixture = TestBed.createComponent(DocSetupProfileComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
