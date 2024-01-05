import { TestBed } from '@angular/core/testing';

import { WindowRefUniversalService } from './window-ref-universal.service';

describe('WindowRefUniversalService', () => {
  let service: WindowRefUniversalService;

  beforeEach(() => {
    TestBed.configureTestingModule({});
    service = TestBed.inject(WindowRefUniversalService);
  });

  it('should be created', () => {
    expect(service).toBeTruthy();
  });
});
