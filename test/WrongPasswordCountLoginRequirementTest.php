<?php
//----------------------------------------------------------------------------------------------------------------------
namespace SetBased\Abc\Login\Test;

use PHPUnit\Framework\TestCase;
use SetBased\Abc\Abc;
use SetBased\Abc\C;
use SetBased\Abc\Login\StaticLoginRequirement;
use SetBased\Abc\Login\WrongPasswordCountLoginRequirement;

/**
 * Test cases for class WrongPasswordCountLoginRequirement.
 */
class WrongPasswordCountLoginRequirementTest extends TestCase
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
    $requirements[] = new WrongPasswordCountLoginRequirement(C::LGR_ID_TO_MANY_WRONG_PASSWORD, 3, 60);

    $handler = new TestCoreLoginHandler($requirements, ['usr_id' => '3', 'usr_name' => 'abc']);
    $granted = $handler->validate();

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
    $requirements[] = new StaticLoginRequirement(C::LGR_ID_WRONG_PASSWORD);
    $requirements[] = new WrongPasswordCountLoginRequirement(C::LGR_ID_TO_MANY_WRONG_PASSWORD, 3, 60);

    $handler = new TestCoreLoginHandler($requirements, ['usr_id' => '3', 'usr_name' => 'abc']);
    $handler->validate();
    $handler->validate();
    $handler->validate();
    $handler->validate();

    $requirements   = [];
    $requirements[] = new StaticLoginRequirement(C::LGR_ID_GRANTED);
    $requirements[] = new WrongPasswordCountLoginRequirement(C::LGR_ID_WRONG_PASSWORD, 3, 60);
    $handler        = new TestCoreLoginHandler($requirements, ['usr_id' => '3', 'usr_name' => 'abc']);
    $granted        = $handler->validate();

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
