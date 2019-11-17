<?php
declare(strict_types=1);

namespace Plaisio\Login\Test;

use Plaisio\Kernel\Nub;
use Plaisio\Request\CoreRequest;

/**
 * Mock framework for testing purposes.
 */
class TestNub extends Nub
{
  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Object constructor.
   */
  public function __construct()
  {
    parent::__construct();

    self::$companyResolver = new TestCompanyResolver();
    self::$DL              = new TestDataLayer();
    self::$session         = new TestSession();
    self::$request         = new CoreRequest();

    TestSession::$usrId = null;
  }

  //--------------------------------------------------------------------------------------------------------------------
}

//----------------------------------------------------------------------------------------------------------------------