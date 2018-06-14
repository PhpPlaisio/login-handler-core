<?php

namespace SetBased\Abc\Login\Test;

use SetBased\Abc\C;
use SetBased\Abc\CompanyResolver\CompanyResolver;

/**
 * Mock framework for testing purposes.
 */
class TestCompanyResolver implements CompanyResolver
{
  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Returns the ID of the company (a.k.a. domain).
   *
   * @return int
   */
  public function getCmpId(): int
  {
    return C::CMP_ID_SYS;
  }

  //--------------------------------------------------------------------------------------------------------------------
}

//----------------------------------------------------------------------------------------------------------------------
