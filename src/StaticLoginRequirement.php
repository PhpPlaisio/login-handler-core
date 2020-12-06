<?php
declare(strict_types=1);

namespace Plaisio\Login;

/**
 * Login requirement: Always returns the  ID of the same login response.
 */
class StaticLoginRequirement implements LoginRequirement
{
  //--------------------------------------------------------------------------------------------------------------------
  /**
   * The ID of the login response.
   *
   * @var int|null
   */
  private ?int $lgrId;

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Object constructor.
   *
   * @param int|null $lgrId The ID of the login response.
   *
   * @since 1.0.0
   * @api
   */
  public function __construct(?int $lgrId)
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
  public function validate(array &$data): ?int
  {
    return $this->lgrId;
  }

  //--------------------------------------------------------------------------------------------------------------------
}

//----------------------------------------------------------------------------------------------------------------------
