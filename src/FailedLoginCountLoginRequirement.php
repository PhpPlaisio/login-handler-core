<?php
//----------------------------------------------------------------------------------------------------------------------
namespace SetBased\Abc\Login;

use SetBased\Abc\Abc;
use SetBased\Abc\C;

/**
 * Login requirement: Maximum number of failed of login attempts.
 */
class FailedLoginCountLoginRequirement implements LoginRequirement
{
  //--------------------------------------------------------------------------------------------------------------------
  /**
   * The length of the interval in minutes.
   *
   * @var int
   */
  private $interval;

  /**
   * The ID of the login response for a wrong password.
   *
   * @var int
   */
  private $lgrId;

  /**
   * The maximum number of allowed failed login attempts due to a wrong password.
   *
   * @var int
   */
  private $maxFailedAttempts;

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * FailedLoginCountLoginRequirement constructor.
   *
   * @param int $lgrId             The ID of the login response for a wrong password.
   * @param int $maxFailedAttempts The maximum number of allowed failed login attempts due to a wrong password.
   * @param int $minutes           The length of the interval in minutes.
   */
  public function __construct($lgrId, $maxFailedAttempts, $minutes)
  {
    $this->lgrId             = $lgrId;
    $this->maxFailedAttempts = $maxFailedAttempts;
    $this->interval          = $minutes;
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Validates the user exists.
   *
   * @param array $data The data for validating the login requirement.
   *
   * @return int
   */
  public function validate(&$data)
  {
    $count = Abc::$DL->abcLoginHandlerCoreWrongPasswordByUsrIdCount(Abc::$companyResolver->getCmpId(),
                                                                    $data['usr_id'],
                                                                    $this->lgrId,
                                                                    $this->interval);

    return ($count<=$this->maxFailedAttempts) ? C::LGR_ID_GRANTED : C::LGR_ID_TO_MANY_WRONG_PASSWORD;
  }

  //--------------------------------------------------------------------------------------------------------------------
}

//----------------------------------------------------------------------------------------------------------------------