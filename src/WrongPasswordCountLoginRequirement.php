<?php
declare(strict_types=1);

namespace Plaisio\Login;

use Plaisio\C;
use Plaisio\PlaisioInterface;
use Plaisio\PlaisioObject;

/**
 * Login requirement: Maximum number of failed login attempts cause by a wrong password.
 */
class WrongPasswordCountLoginRequirement extends PlaisioObject implements LoginRequirement
{
  //--------------------------------------------------------------------------------------------------------------------
  /**
   * The length of the interval in minutes.
   *
   * @var int
   */
  private $interval;

  /**
   * The ID of the login response for to many wrong passwords.
   *
   * @var int
   */
  private $lgrIdToManyWrongPassword;

  /**
   * The ID of the login response for a wrong password.
   *
   * @var int
   */
  private $lgrIdWrongPassword;

  /**
   * The maximum number of allowed failed login attempts due to a wrong password.
   *
   * @var int
   */
  private $maxFailedAttempts;

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * WrongPasswordCountLoginRequirement constructor.
   *
   * @param PlaisioInterface $object                   The parent PhpPlaisio object.
   * @param int              $lgrIdWrongPassword       The ID of the login response for a wrong password.
   * @param int              $lgrIdToManyWrongPassword The ID of the login response for to many wrong passwords.
   * @param int              $maxFailedAttempts        The maximum number of allowed failed login attempts due to a
   *                                                   wrong password.
   * @param int              $minutes                  The length of the interval in minutes.
   *
   * @since 1.0.0
   * @api
   */
  public function __construct(PlaisioInterface $object,
                              int $lgrIdWrongPassword,
                              int $lgrIdToManyWrongPassword,
                              int $maxFailedAttempts,
                              int $minutes)
  {
    parent::__construct($object);

    $this->lgrIdWrongPassword       = $lgrIdWrongPassword;
    $this->lgrIdToManyWrongPassword = $lgrIdToManyWrongPassword;
    $this->maxFailedAttempts        = $maxFailedAttempts;
    $this->interval                 = $minutes;
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Validates the number of failed login attempts caused by a wrong password is within limits.
   *
   * @param array $data The data for validating the login requirement.
   *
   * @return int
   *
   * @since 1.0.0
   * @api
   */
  public function validate(array &$data): int
  {
    $count = $this->nub->DL->abcLoginHandlerCoreWrongPasswordByUsrIdCount($this->nub->company->cmpId,
                                                                          $data['usr_id'],
                                                                          $this->lgrIdWrongPassword,
                                                                          $this->interval);

    return ($count<=$this->maxFailedAttempts) ? C::LGR_ID_GRANTED : $this->lgrIdToManyWrongPassword;
  }

  //--------------------------------------------------------------------------------------------------------------------
}

//----------------------------------------------------------------------------------------------------------------------
