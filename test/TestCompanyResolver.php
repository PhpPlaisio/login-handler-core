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
   * @var int
   */
  public $cmpId = C::CMP_ID_SYS;

  //--------------------------------------------------------------------------------------------------------------------
}

//----------------------------------------------------------------------------------------------------------------------
