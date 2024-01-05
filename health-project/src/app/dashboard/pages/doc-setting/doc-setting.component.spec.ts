import { ComponentFixture, TestBed } from '@angular/core/testing';

import { DocSettingComponent } from './doc-setting.component';

describe('DocSettingComponent', () => {
  let component: DocSettingComponent;
  let fixture: ComponentFixture<DocSettingComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      declarations: [ DocSettingComponent ]
    })
    .compileComponents();
  });

  beforeEach(() => {
    fixture = TestBed.createComponent(DocSettingComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
