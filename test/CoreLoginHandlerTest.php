<?php
//----------------------------------------------------------------------------------------------------------------------
namespace SetBased\Abc\Login\Test;

use PHPUnit\Framework\TestCase;
use SetBased\Abc\Abc;
use SetBased\Abc\C;

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
  public function testValidate1()
  {
    $requirements   = [];
    $requirements[] = new TestLoginRequirement(C::LGR_ID_GRANTED);

    $handler = new TestCoreLoginHandler($requirements);
    $data    = ['usr_id'   => '3',
                'usr_name' => 'abc'];
    $granted = $handler->validate($data);

    self::assertTrue($granted);
    self::assertSame('3', TestSession::$usrId);
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Test for method validate with unsuccessful login.
   */
  public function testValidate2()
  {
    $requirements   = [];
    $requirements[] = new TestLoginRequirement(C::LGR_ID_NOT_GRANTED);

    $handler = new TestCoreLoginHandler($requirements);
    $data    = ['usr_id'   => '3',
                'usr_name' => 'abc'];
    $granted = $handler->validate($data);

    self::assertFalse($granted);
    self::assertNull(TestSession::$usrId);
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Test for method validate with unsuccessful login. Testing requirements must stop after first failed requirement.
   */
  public function testValidate3()
  {
    $requirements   = [];
    $requirements[] = new TestLoginRequirement(C::LGR_ID_GRANTED);
    $requirements[] = new TestLoginRequirement(C::LGR_ID_NOT_GRANTED);
    $requirements[] = new TestLoginRequirement(C::LGR_ID_GRANTED);

    $handler = new TestCoreLoginHandler($requirements);
    $data    = ['usr_id'   => '3',
                'usr_name' => 'abc'];
    $granted = $handler->validate($data);

    self::assertFalse($granted);
    self::assertNull(TestSession::$usrId);
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Connects to the MySQL server and cleans the BLOB tables.
   */
  protected function setUp()
  {
    self::$abc = new TestAbc();

    Abc::$DL->connect('localhost', 'test', 'test', 'test');
    Abc::$DL->begin();
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Disconnects from the MySQL server.
   */
  protected function tearDown()
  {
    Abc::$DL->commit();
    Abc::$DL->disconnect();
  }

  //--------------------------------------------------------------------------------------------------------------------
}

//----------------------------------------------------------------------------------------------------------------------
