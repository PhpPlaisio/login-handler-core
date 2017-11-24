<?php
//----------------------------------------------------------------------------------------------------------------------
namespace SetBased\Abc\Login\Test;

use SetBased\Abc\Session\Session;

/**
 * Mock framework for testing purposes.
 */
class TestSession implements Session
{
  //--------------------------------------------------------------------------------------------------------------------
  /**
   * The ID of the logged in user.
   *
   * @var int
   */
  public static $usrId;

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Returns the ID of company of the current session.
   *
   * @return int
   *
   * @deprecated Use Abc::$companyResolver->getCmpId() instead.
   */
  public function getCmpId()
  {
    throw new \LogicException('Not implemented');
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Returns stateful double submit token to prevent CSRF attacks.
   *
   * @return string
   */
  public function getCsrfToken()
  {
    throw new \LogicException('Not implemented');
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Returns the ID of preferred language of the user of the current session.
   *
   * @return int
   */
  public function getLanId()
  {
    throw new \LogicException('Not implemented');
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Returns the ID of the profile of the user of the current session.
   *
   * @return int
   */
  public function getProId()
  {
    throw new \LogicException('Not implemented');
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Returns the ID of the current session.
   *
   * @return int|null
   */
  public function getSesId()
  {
    return null;
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Returns the session token.
   *
   * @return string
   */
  public function getSessionToken()
  {
    throw new \LogicException('Not implemented');
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Returns the ID of the user of the current session.
   *
   * @return int
   */
  public function getUsrId()
  {
    throw new \LogicException('Not implemented');
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Returns true if the user is anonymous (i.e. not a user who has logged in). Otherwise, returns false.
   *
   * @return bool
   */
  public function isAnonymous()
  {
    throw new \LogicException('Not implemented');
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Updates the session that an user has successfully logged in.
   *
   * @param int $usrId The ID the user.
   *
   * @return void
   */
  public function login($usrId)
  {
    self::$usrId = $usrId;
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Terminates the current session.
   *
   * @return void
   */
  public function logout()
  {
    throw new \LogicException('Not implemented');
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Saves the current state op the session.
   *
   * @return void
   */
  public function save()
  {
    throw new \LogicException('Not implemented');
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Changes the language of the current session.
   *
   * @param int $lanId The ID of the new language.
   */
  public function setLanId($lanId)
  {
    throw new \LogicException('Not implemented');
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Creates a session or resumes the current session based on the session cookie.
   *
   * @return void
   */
  public function start()
  {
    throw new \LogicException('Not implemented');
  }

  //--------------------------------------------------------------------------------------------------------------------
}

//----------------------------------------------------------------------------------------------------------------------
