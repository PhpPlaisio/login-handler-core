<?php
declare(strict_types=1);

namespace Plaisio\Login\Test;

use PHPUnit\Framework\TestCase;
use Plaisio\C;
use Plaisio\Login\StaticLoginRequirement;
use Plaisio\PlaisioKernel;

/**
 * Test cases for class CoreLoginHandlerTest.
 */
class CoreLoginHandlerTest extends TestCase
{
  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Our concrete instance of Abc.
   *
   * @var PlaisioKernel
   */
  private $kernel;

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Test for method validate with successful login.
   */
  public function testValidate1(): void
  {
    $requirements   = [];
    $requirements[] = new StaticLoginRequirement(C::LGR_ID_GRANTED);

    $handler = new TestCoreLoginHandler($this->kernel, $requirements, ['usr_id' => 3, 'usr_name' => 'abc']);
    $granted = $handler->validate();

    self::assertTrue($granted);
    self::assertSame(3, $this->kernel->session->usrId);
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Test for method validate with unsuccessful login.
   */
  public function testValidate2(): void
  {
    $requirements   = [];
    $requirements[] = new StaticLoginRequirement(C::LGR_ID_NOT_GRANTED);

    $handler = new TestCoreLoginHandler($this->kernel, $requirements, ['usr_id' => 3, 'usr_name' => 'abc']);
    $granted = $handler->validate();

    self::assertFalse($granted);
    self::assertNull($this->kernel->session->usrId);
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Test for method validate with unsuccessful login. Testing requirements must stop after first failed requirement.
   */
  public function testValidate3(): void
  {
    $requirements   = [];
    $requirements[] = new StaticLoginRequirement(C::LGR_ID_GRANTED);
    $requirements[] = new StaticLoginRequirement(C::LGR_ID_NOT_GRANTED);
    $requirements[] = new StaticLoginRequirement(C::LGR_ID_GRANTED);

    $handler = new TestCoreLoginHandler($this->kernel, $requirements, ['usr_id' => 3, 'usr_name' => 'abc']);
    $granted = $handler->validate();

    self::assertFalse($granted);
    self::assertNull($this->kernel->session->usrId);
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Test for method validate with unsuccessful login.
   */
  public function testValidate4(): void
  {
    $requirements   = [];
    $requirements[] = new StaticLoginRequirement(C::LGR_ID_GRANTED);
    $requirements[] = new StaticLoginRequirement(C::LGR_ID_GRANTED);
    $requirements[] = new StaticLoginRequirement(null);
    $requirements[] = new StaticLoginRequirement(C::LGR_ID_GRANTED);

    $handler = new TestCoreLoginHandler($this->kernel, $requirements, ['usr_id' => 3, 'usr_name' => 'abc']);
    $granted = $handler->validate();

    self::assertNull($granted);
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
