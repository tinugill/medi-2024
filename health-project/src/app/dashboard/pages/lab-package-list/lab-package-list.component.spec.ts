import { ComponentFixture, TestBed } from '@angular/core/testing';

import { LabPackageListComponent } from './lab-package-list.component';

describe('LabPackageListComponent', () => {
  let component: LabPackageListComponent;
  let fixture: ComponentFixture<LabPackageListComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      declarations: [ LabPackageListComponent ]
    })
    .compileComponents();
  });

  beforeEach(() => {
    fixture = TestBed.createComponent(LabPackageListComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
