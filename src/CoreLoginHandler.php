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
  protected $data = ['usr_id' => null, 'usr_name' => null];

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
   * {@inheritdoc}
   */
  public function validate()
  {
    $continue = $this->preValidation();
    if (!$continue) return null;

    $granted = $this->validateRequirements();

    if ($granted)
    {
      $this->postValidation();
      $this->login();
    }

    $this->logLoginAttempt();

    return $granted;
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Logs the login attempt.
   */
  protected function logLoginAttempt()
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
   * Updates the session with the proper ID of the user.
   */
  protected function login()
  {
    Abc::$session->login($this->data['usr_id']);
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Will be called only and only after all login requirements are successfully validated.
   *
   * @return void
   */
  abstract protected function postValidation();

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * This method will be called before validating the login requirements. Must return false when the pre-validation was
   * preparation only (e.g. generation a login form only). When returns true the login requirements will be validated.
   *
   * @return bool
   */
  abstract protected function preValidation();

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
