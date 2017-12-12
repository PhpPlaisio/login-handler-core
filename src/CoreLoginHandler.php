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
   *
   * @since 1.0.0
   * @api
   */
  protected $data = [];

  /**
   * The ID of the login response.
   *
   * @var int
   *
   * @since 1.0.0
   * @api
   */
  protected $lgrId;

  /**
   * The list of login requirements.
   *
   * @var LoginRequirement[]
   *
   * @since 1.0.0
   * @api
   */
  protected $requirements = [];

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Sets the (initial) data for validating the login request.
   *
   * @param array $data The data for validating the login request.
   *
   * @since 1.0.0
   * @api
   */
  public function setData($data)
  {
    $this->data = $data;
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * {@inheritdoc}
   *
   * @since 1.0.0
   * @api
   */
  public function validate()
  {
    $continue = $this->preValidation();
    if (!$continue) return null;

    $granted = $this->validateRequirements();
    if ($granted===null) return null;

    $continue = $this->postValidation($granted);
    if (!$continue) return null;

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
   * @return true
   *
   * @since 1.0.0
   * @api
   */
  protected function postValidation($granted)
  {
    unset($granted);

    return true;
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * This method will be called before validating the login requirements. Must return false when the pre-validation was
   * preparation only (e.g. showing a login form only). When returns true the login requirements will be validated.
   *
   * @return true
   *
   * @since 1.0.0
   * @api
   */
  protected function preValidation()
  {
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
   * @return bool|null
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

      if ($this->lgrId===null) return null;
      if ($this->lgrId!=C::LGR_ID_GRANTED) return false;
    }

    return true;
  }

  //--------------------------------------------------------------------------------------------------------------------
}

//----------------------------------------------------------------------------------------------------------------------
