<?php
//----------------------------------------------------------------------------------------------------------------------
namespace SetBased\Abc\Login\Test;

use SetBased\Abc\Login\CoreLoginHandler;
use SetBased\Abc\Login\LoginRequirement;

/**
 * Mock framework for testing purposes.
 */
class TestCoreLoginHandler extends CoreLoginHandler
{
  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Object constructor.
   *
   * @param LoginRequirement[] $requirements The list of login requirements.
   */
  public function __construct($requirements)
  {
    $this->requirements = $requirements;
  }

  //--------------------------------------------------------------------------------------------------------------------
}

//----------------------------------------------------------------------------------------------------------------------
