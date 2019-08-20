<?php
declare(strict_types=1);

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
   * @param array              $data         The data provided to the login requirements.
   */
  public function __construct($requirements, $data)
  {
    $this->data         = $data;
    $this->requirements = $requirements;
  }

  //--------------------------------------------------------------------------------------------------------------------
}

//----------------------------------------------------------------------------------------------------------------------
