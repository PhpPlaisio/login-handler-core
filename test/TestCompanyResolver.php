<?php
declare(strict_types=1);

namespace Plaisio\Login\Test;

use Plaisio\C;
use Plaisio\CompanyResolver\CompanyResolver;

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
