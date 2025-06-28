<?php
declare(strict_types=1);

namespace Plaisio\Login\Test\Plaisio;

use Plaisio\CompanyResolver\CompanyResolver;
use Plaisio\C;

/**
 * Mock framework for testing purposes.
 */
class TestCompanyResolver implements CompanyResolver
{
  //--------------------------------------------------------------------------------------------------------------------
  /**
   * @var int
   */
  public int $cmpId = C::CMP_ID_SYS;

  //--------------------------------------------------------------------------------------------------------------------
}

//----------------------------------------------------------------------------------------------------------------------
