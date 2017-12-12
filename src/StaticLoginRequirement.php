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
   * @param int|null $lgrId The ID of the login response.
   *
   * @since 1.0.0
   * @api
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
   * @return int|null
   *
   * @since 1.0.0
   * @api
   */
  public function validate(&$data)
  {
    return $this->lgrId;
  }

  //--------------------------------------------------------------------------------------------------------------------
}

//----------------------------------------------------------------------------------------------------------------------
