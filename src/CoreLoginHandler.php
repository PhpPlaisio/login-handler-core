<?php
//----------------------------------------------------------------------------------------------------------------------
namespace SetBased\Abc\Login;

use SetBased\Abc\Abc;
use SetBased\Abc\C;

/**
 * The core login handler using a list of login requirements.
 */
abstract class CoreLoginHandler implements LoginHandler
{
  //--------------------------------------------------------------------------------------------------------------------
  /**
   * The data provided to the login requirements.
   *
   * @var array
   */
  protected $data = [];

  /**
   * The ID of the login response.
   *
   * @var int
   */
  protected $lgrId;

  /**
   * The list of login requirements.
   *
   * @var LoginRequirement[]
   */
  protected $requirements = [];

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Sets the (initial) data for validating the login request.
   *
   * @param array $data The data for validating the login request.
   */
  public function setData($data)
  {
    $this->data = $data;
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * {@inheritdoc}
   */
  public function validate()
  {
    $continue = $this->preValidation();
    if (!$continue) return null;

    $granted = $this->validateRequirements();

    $this->postValidation($granted);
    $this->login();
    $this->logLoginAttempt();

    return $granted;
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Will be called only and only after all login requirements are successfully validated.
   *
   * @param bool $granted True if login is granted, false otherwise.
   *
   * @return void
   */
  protected function postValidation($granted)
  {
    unset($granted);
    // Nothing to do.
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * This method will be called before validating the login requirements. Must return false when the pre-validation was
   * preparation only (e.g. generation a login form only). When returns true the login requirements will be validated.
   *
   * @return bool
   */
  protected function preValidation()
  {
    // Nothing to do.
    return true;
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Logs the login attempt.
   */
  private function logLoginAttempt()
  {
    Abc::$DL->abcLoginHandlerCoreLogLogin(Abc::$companyResolver->getCmpId(),
                                          Abc::$session->getSesId(),
                                          $this->data['usr_id'],
                                          $this->lgrId,
                                          $this->data['usr_name'],
                                          $_SERVER['REMOTE_ADDR'] ?? null);
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Updates the session with the proper ID of the user if and only if login is granted.
   */
  private function login()
  {
    if ($this->lgrId==C::LGR_ID_GRANTED)
    {
      Abc::$session->login($this->data['usr_id']);
    }
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Validates the login attempt against the login requirements.
   *
   * @return bool
   */
  private function validateRequirements()
  {
    if (empty($this->requirements))
    {
      throw new \LogicException('One or more login requirements are required');
    }

    foreach ($this->requirements as $requirement)
    {
      $this->lgrId = $requirement->validate($this->data);

      if ($this->lgrId!=C::LGR_ID_GRANTED) return false;
    }

    return true;
  }

  //--------------------------------------------------------------------------------------------------------------------
}

//----------------------------------------------------------------------------------------------------------------------
