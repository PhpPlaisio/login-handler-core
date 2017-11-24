<?php
//----------------------------------------------------------------------------------------------------------------------
namespace SetBased\Abc\Login\Test;

use SetBased\Abc\Abc;

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

    TestSession::$usrId = null;
  }

  //--------------------------------------------------------------------------------------------------------------------
}

//----------------------------------------------------------------------------------------------------------------------
