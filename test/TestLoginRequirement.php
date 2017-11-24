<?php
//----------------------------------------------------------------------------------------------------------------------
namespace SetBased\Abc\Login\Test;

use SetBased\Abc\Login\LoginRequirement;

/**
 * Mock framework for testing purposes.
 */
class TestLoginRequirement implements LoginRequirement
{
  //--------------------------------------------------------------------------------------------------------------------
  /**
   * The ID of the login response.
   *
   * @var int
   */
  private $lgrId;

  //--------------------------------------------------------------------------------------------------------------------

  /**
   * Object constructor.
   *
   * @param int $lgrId The ID of the login response.
   */
  public function __construct($lgrId)
  {
    $this->lgrId = $lgrId;
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Validates a requirement to a login request.
   *
   * @param array $data The data for validating the requirement to the login request. This method might enhance this
   *                    array with new elements.
   *
   * @return int
   */
  public function validate(&$data)
  {
    return $this->lgrId;
  }

  //--------------------------------------------------------------------------------------------------------------------
}

//----------------------------------------------------------------------------------------------------------------------
