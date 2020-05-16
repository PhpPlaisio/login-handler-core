<?php
declare(strict_types=1);

namespace Plaisio\Login\Test;

use Plaisio\Login\CoreLoginHandler;
use Plaisio\Login\LoginRequirement;
use Plaisio\PlaisioInterface;

/**
 * Mock framework for testing purposes.
 */
class TestCoreLoginHandler extends CoreLoginHandler
{
  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Object constructor.
   *
   * @param PlaisioInterface   $object       The parent PhpPlaisio object.
   * @param LoginRequirement[] $requirements The list of login requirements.
   * @param array              $data         The data provided to the login requirements.
   */
  public function __construct(PlaisioInterface $object, $requirements, $data)
  {
    parent::__construct($object);

    $this->data         = $data;
    $this->requirements = $requirements;
  }

  //--------------------------------------------------------------------------------------------------------------------
}

//----------------------------------------------------------------------------------------------------------------------
