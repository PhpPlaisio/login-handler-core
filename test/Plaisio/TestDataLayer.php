<?php
declare(strict_types=1);

namespace Plaisio\Login\Test\Plaisio;

use SetBased\Stratum\Middle\Exception\ResultException;
use SetBased\Stratum\MySql\Exception\MySqlDataLayerException;
use SetBased\Stratum\MySql\Exception\MySqlQueryErrorException;
use SetBased\Stratum\MySql\MySqlDataLayer;

/**
 * The data layer.
 */
class TestDataLayer extends MySqlDataLayer
{
  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Logs a login attempt.
   *
   * @param int|null    $pCmpId       The ID of the company.
   *                                  smallint(5) unsigned
   * @param int|null    $pSesId       The ID of the session.
   *                                  int(10) unsigned
   * @param int|null    $pUsrId       The ID of the user.
   *                                  int(10) unsigned
   * @param int|null    $pLgrId       The ID of the login response.
   *                                  tinyint(3) unsigned
   * @param string|null $pLlgUserName The username under which the user agent want to log in.
   *                                  varchar(64) character set utf8mb3 collation utf8mb3_general_ci
   * @param string|null $pLlgIp       The packed IP address of the user agent.
   *                                  binary(16)
   *
   * @return int
   *
   * @throws MySqlQueryErrorException
   */
  public function abcLoginHandlerCoreLogLogin(?int $pCmpId, ?int $pSesId, ?int $pUsrId, ?int $pLgrId, ?string $pLlgUserName, ?string $pLlgIp): int
  {
    return $this->executeNone('call abc_login_handler_core_log_login('.$this->quoteInt($pCmpId).','.$this->quoteInt($pSesId).','.$this->quoteInt($pUsrId).','.$this->quoteInt($pLgrId).','.$this->quoteString($pLlgUserName).','.$this->quoteBinary($pLlgIp).')');
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Selects the number failed login attempts due to wrong password.
   *
   * @param int|null $pCmpId    The ID of the company (safeguard).
   *                            smallint(5) unsigned
   * @param int|null $pUsrId    The ID of the user.
   *                            int(10) unsigned
   * @param int|null $pLgrId    The ID the login response for a wrong password.
   *                            tinyint(3) unsigned
   * @param int|null $pInterval The length of the interval in minutes.
   *                            int(11)
   *
   * @return int
   *
   * @throws MySqlDataLayerException
   * @throws ResultException
   */
  public function abcLoginHandlerCoreWrongPasswordByUsrIdCount(?int $pCmpId, ?int $pUsrId, ?int $pLgrId, ?int $pInterval): int
  {
    return $this->executeSingleton1('call abc_login_handler_core_wrong_password_by_usr_id_count('.$this->quoteInt($pCmpId).','.$this->quoteInt($pUsrId).','.$this->quoteInt($pLgrId).','.$this->quoteInt($pInterval).')');
  }

  //--------------------------------------------------------------------------------------------------------------------
}

//----------------------------------------------------------------------------------------------------------------------
