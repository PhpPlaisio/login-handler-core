<?php
//----------------------------------------------------------------------------------------------------------------------
namespace SetBased\Abc\Login\Test;

use PHPUnit\Framework\TestCase;
use SetBased\Abc\Abc;
use SetBased\Abc\C;
use SetBased\Abc\Login\FailedLoginCountLoginRequirement;

/**
 * Test cases for class FailedLoginCountLoginRequirement.
 */
class FailedLoginCountLoginRequirementTest extends TestCase
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
    $requirements[] = new FailedLoginCountLoginRequirement(C::LGR_ID_TO_MANY_WRONG_PASSWORD, 3, 60);

    $handler = new TestCoreLoginHandler($requirements);
    $data    = ['usr_id'   => '3',
                'usr_name' => 'abc'];
    $granted = $handler->validate($data);

    self::assertTrue($granted);
    self::assertSame('3', TestSession::$usrId);
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Test for method validate with to many failed password.
   */
  public function testValidate2()
  {
    $requirements   = [];
    $requirements[] = new TestLoginRequirement(C::LGR_ID_WRONG_PASSWORD);
    $requirements[] = new FailedLoginCountLoginRequirement(C::LGR_ID_TO_MANY_WRONG_PASSWORD, 3, 60);

    $data    = ['usr_id'   => '3',
                'usr_name' => 'abc'];
    $handler = new TestCoreLoginHandler($requirements);
    $handler->validate($data);
    $handler->validate($data);
    $handler->validate($data);
    $handler->validate($data);

    $requirements   = [];
    $requirements[] = new TestLoginRequirement(C::LGR_ID_GRANTED);
    $requirements[] = new FailedLoginCountLoginRequirement(C::LGR_ID_WRONG_PASSWORD, 3, 60);
    $handler        = new TestCoreLoginHandler($requirements);
    $granted        = $handler->validate($data);

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
