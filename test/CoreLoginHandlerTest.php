<?php
declare(strict_types=1);

namespace SetBased\Abc\Login\Test;

use PHPUnit\Framework\TestCase;
use SetBased\Abc\Abc;
use SetBased\Abc\C;
use SetBased\Abc\Login\StaticLoginRequirement;

/**
 * Test cases for class CoreLoginHandlerTest.
 */
class CoreLoginHandlerTest extends TestCase
{
  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Our concrete instance of Abc.
   *
   * @var Abc
   */
  private static $abc;

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
    self::$abc = new TestAbc();

    Abc::$DL->connect('localhost', 'test', 'test', 'test');
    Abc::$DL->begin();
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Disconnects from the MySQL server.
   */
  protected function tearDown(): void
  {
    Abc::$DL->commit();
    Abc::$DL->disconnect();
  }

  //--------------------------------------------------------------------------------------------------------------------
}

//----------------------------------------------------------------------------------------------------------------------
