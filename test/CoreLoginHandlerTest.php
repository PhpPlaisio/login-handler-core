<?php
declare(strict_types=1);

namespace Plaisio\Login\Test;

use PHPUnit\Framework\TestCase;
use Plaisio\C;
use Plaisio\Kernel\Nub;
use Plaisio\Login\StaticLoginRequirement;

/**
 * Test cases for class CoreLoginHandlerTest.
 */
class CoreLoginHandlerTest extends TestCase
{
  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Our concrete instance of Abc.
   *
   * @var Nub
   */
  private static $nub;

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Test for method validate with successful login.
   */
  public function testValidate1(): void
  {
    $requirements   = [];
    $requirements[] = new StaticLoginRequirement(C::LGR_ID_GRANTED);

    $handler = new TestCoreLoginHandler($requirements, ['usr_id' => 3, 'usr_name' => 'abc']);
    $granted = $handler->validate();

    self::assertTrue($granted);
    self::assertSame(3, TestSession::$usrId);
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Test for method validate with unsuccessful login.
   */
  public function testValidate2(): void
  {
    $requirements   = [];
    $requirements[] = new StaticLoginRequirement(C::LGR_ID_NOT_GRANTED);

    $handler = new TestCoreLoginHandler($requirements, ['usr_id' => 3, 'usr_name' => 'abc']);
    $granted = $handler->validate();

    self::assertFalse($granted);
    self::assertNull(TestSession::$usrId);
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

    $handler = new TestCoreLoginHandler($requirements, ['usr_id' => 3, 'usr_name' => 'abc']);
    $granted = $handler->validate();

    self::assertFalse($granted);
    self::assertNull(TestSession::$usrId);
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

    $handler = new TestCoreLoginHandler($requirements, ['usr_id' => 3, 'usr_name' => 'abc']);
    $granted = $handler->validate();

    self::assertNull($granted);
    self::assertNull(TestSession::$usrId);
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Connects to the MySQL server and cleans the BLOB tables.
   */
  protected function setUp(): void
  {
    self::$nub = new TestKernel();

    Nub::$nub->DL->connect('localhost', 'test', 'test', 'test');
    Nub::$nub->DL->begin();
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Disconnects from the MySQL server.
   */
  protected function tearDown(): void
  {
    Nub::$nub->DL->commit();
    Nub::$nub->DL->disconnect();
  }

  //--------------------------------------------------------------------------------------------------------------------
}

//----------------------------------------------------------------------------------------------------------------------
