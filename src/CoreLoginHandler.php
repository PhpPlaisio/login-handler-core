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
   * Returns the ID of the login response.
   *
   * @return int
   */
  public function getLgrId()
  {
    if ($this->lgrId)
    {
      throw new \LogicException('No login attempt made');
    }

    return $this->lgrId;
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Validates whether the user agent is allowed to login.
   *
   * @param array $data The data for validating the credentials.
   *
   * @return bool
   */
  public function validate(&$data)
  {
    foreach ($this->requirements as $requirement)
    {
      $this->lgrId = $requirement->validate($data);

      if ($this->lgrId!=C::LGR_ID_GRANTED) break;
    }

    $this->logLoginAttempt($data);
    $this->login($data);

    return ($this->lgrId==C::LGR_ID_GRANTED);
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Logs the login attempt.
   *
   * @param array $data The data for validating the credentials.
   */
  protected function logLoginAttempt($data)
  {
    Abc::$DL->abcLoginHandlerCoreLogLogin(Abc::$companyResolver->getCmpId(),
                                          Abc::$session->getSesId(),
                                          $data['usr_id'],
                                          $this->lgrId,
                                          $data['usr_name'],
                                          $_SERVER['REMOTE_ADDR'] ?? null);
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * On a successful login attempt updates the session with the proper ID of the user.
   *
   * @param array $data The data for validating the credentials.
   */
  protected function login($data)
  {
    if ($this->lgrId==C::LGR_ID_GRANTED)
    {
      // The user has logged on successfully.
      Abc::$session->login($data['usr_id']);
    }
  }

  //--------------------------------------------------------------------------------------------------------------------
}

//----------------------------------------------------------------------------------------------------------------------
