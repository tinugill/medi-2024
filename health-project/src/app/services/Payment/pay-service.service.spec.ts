import { TestBed } from '@angular/core/testing';

import { PayServiceService } from './pay-service.service';

describe('PayServiceService', () => {
  let service: PayServiceService;

  beforeEach(() => {
    TestBed.configureTestingModule({});
    service = TestBed.inject(PayServiceService);
  });

  it('should be created', () => {
    expect(service).toBeTruthy();
  });
});
