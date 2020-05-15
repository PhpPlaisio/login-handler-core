<?php
declare(strict_types=1);

namespace Plaisio\Login\Test;

use Plaisio\Login\CoreLoginHandler;
use Plaisio\Login\LoginRequirement;
use Plaisio\PlaisioObject;

/**
 * Mock framework for testing purposes.
 */
class TestCoreLoginHandler extends CoreLoginHandler
{
  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Object constructor.
   *
   * @param PlaisioObject      $object       The parent PhpPlaisio object.
   * @param LoginRequirement[] $requirements The list of login requirements.
   * @param array              $data         The data provided to the login requirements.
   */
  public function __construct(PlaisioObject $object, $requirements, $data)
  {
    parent::__construct($object);

    $this->data         = $data;
    $this->requirements = $requirements;
  }

  //--------------------------------------------------------------------------------------------------------------------
}

//----------------------------------------------------------------------------------------------------------------------
