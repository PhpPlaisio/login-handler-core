<?php
//----------------------------------------------------------------------------------------------------------------------
namespace SetBased\Abc\Login;

/**
 * Login requirement: Always returns the  ID of the same login response.
 */
class StaticLoginRequirement implements LoginRequirement
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
   * Validates nothing.
   *
   * @param array $data Not used.
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
