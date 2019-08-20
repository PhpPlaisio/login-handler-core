<?php
declare(strict_types=1);

namespace SetBased\Abc\Login\Test;

use SetBased\Abc\Abc;
use SetBased\Abc\Request\CoreRequest;

/**
 * Mock framework for testing purposes.
 */
class TestAbc extends Abc
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
