<?php
//----------------------------------------------------------------------------------------------------------------------
namespace SetBased\Abc\Login\Test;

use PHPUnit\Framework\TestCase;
use SetBased\Abc\C;
use SetBased\Abc\Login\StaticLoginRequirement;

/**
 * Test cases for class StaticLoginRequirement.
 */
class StaticLoginRequirementTest extends TestCase
{
  //--------------------------------------------------------------------------------------------------------------------
  public function testValidate01()
  {
    $requirement = new StaticLoginRequirement(C::LGR_ID_GRANTED);

    $data  = [];
    $lgrId = $requirement->validate($data);
    self::assertSame(C::LGR_ID_GRANTED, $lgrId);

    $data  = ['usr_id' => '3', 'usr_name' => 'abc'];
    $lgrId = $requirement->validate($data);
    self::assertSame(C::LGR_ID_GRANTED, $lgrId);
  }

  //--------------------------------------------------------------------------------------------------------------------
  public function testValidate02()
  {
    $requirement = new StaticLoginRequirement(C::LGR_ID_NOT_GRANTED);

    $data  = [];
    $lgrId = $requirement->validate($data);
    self::assertSame(C::LGR_ID_NOT_GRANTED, $lgrId);

    $data  = ['usr_id' => '3', 'usr_name' => 'abc'];
    $lgrId = $requirement->validate($data);
    self::assertSame(C::LGR_ID_NOT_GRANTED, $lgrId);
  }

  //--------------------------------------------------------------------------------------------------------------------
  public function testValidate03()
  {
    $requirement = new StaticLoginRequirement(null);

    $data  = [];
    $lgrId = $requirement->validate($data);
    self::assertNull($lgrId);

    $data  = ['usr_id' => '3', 'usr_name' => 'abc'];
    $lgrId = $requirement->validate($data);
    self::assertNull($lgrId);
  }

  //--------------------------------------------------------------------------------------------------------------------
}

//----------------------------------------------------------------------------------------------------------------------
