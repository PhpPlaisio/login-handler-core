<?php
declare(strict_types=1);

namespace Plaisio\Login\Test;

use PHPUnit\Framework\TestCase;
use Plaisio\C;
use Plaisio\Login\StaticLoginRequirement;
use Plaisio\Login\Test\Plaisio\TestCoreLoginHandler;
use Plaisio\Login\Test\Plaisio\TestKernel;
use Plaisio\Login\WrongPasswordCountLoginRequirement;
use Plaisio\PlaisioKernel;

/**
 * Test cases for class WrongPasswordCountLoginRequirement.
 */
class WrongPasswordCountLoginRequirementTest extends TestCase
{
  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Our concrete instance of Abc.
   *
   * @var PlaisioKernel
   */
  private PlaisioKernel $kernel;

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Test for method validate with successful login.
   */
  public function testValidate1(): void
  {
    $requirements   = [];
    $requirements[] = new WrongPasswordCountLoginRequirement($this->kernel,
                                                             C::LGR_ID_WRONG_PASSWORD,
                                                             C::LGR_ID_TO_MANY_WRONG_PASSWORD,
                                                             3,
                                                             60);

    $handler = new TestCoreLoginHandler($this->kernel, $requirements, ['usr_id' => 3, 'usr_name' => 'abc']);
    $granted = $handler->validate();

    self::assertTrue($granted);
    self::assertSame(3, $this->kernel->session->usrId);
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Test for method validate with to many failed password.
   */
  public function testValidate2(): void
  {
    $requirements   = [];
    $requirements[] = new StaticLoginRequirement(C::LGR_ID_WRONG_PASSWORD);
    $requirements[] = new WrongPasswordCountLoginRequirement($this->kernel,
                                                             C::LGR_ID_WRONG_PASSWORD,
                                                             C::LGR_ID_TO_MANY_WRONG_PASSWORD,
                                                             3,
                                                             60);

    $handler = new TestCoreLoginHandler($this->kernel, $requirements, ['usr_id' => 3, 'usr_name' => 'abc']);
    $handler->validate();
    $handler->validate();
    $handler->validate();
    $handler->validate();

    $requirements   = [];
    $requirements[] = new StaticLoginRequirement(C::LGR_ID_GRANTED);
    $requirements[] = new WrongPasswordCountLoginRequirement($this->kernel,
                                                             C::LGR_ID_WRONG_PASSWORD,
                                                             C::LGR_ID_TO_MANY_WRONG_PASSWORD,
                                                             3,
                                                             60);
    $handler        = new TestCoreLoginHandler($this->kernel, $requirements, ['usr_id' => 3, 'usr_name' => 'abc']);
    $granted        = $handler->validate();

    self::assertFalse($granted);
    self::assertNull($this->kernel->session->usrId);
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Connects to the MySQL server and cleans the BLOB tables.
   */
  protected function setUp(): void
  {
    $this->kernel = new TestKernel();
    $this->kernel->DL->connect();
    $this->kernel->DL->begin();
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Disconnects from the MySQL server.
   */
  protected function tearDown(): void
  {
    $this->kernel->DL->commit();
    $this->kernel->DL->disconnect();
  }

  //--------------------------------------------------------------------------------------------------------------------
}

//----------------------------------------------------------------------------------------------------------------------
