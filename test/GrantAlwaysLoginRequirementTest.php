<?php
//----------------------------------------------------------------------------------------------------------------------
namespace SetBased\Abc\Login\Test;

use PHPUnit\Framework\TestCase;
use SetBased\Abc\C;
use SetBased\Abc\Login\GrantAlwaysLoginRequirement;

/**
 * Test cases for class GrantAlwaysLoginRequirement.
 */
class GrantAlwaysLoginRequirementTest extends TestCase
{
  //--------------------------------------------------------------------------------------------------------------------
  public function testValidate()
  {
    $requirement = new GrantAlwaysLoginRequirement();

    $data  = [];
    $lgrId = $requirement->validate($data);
    self::assertSame(C::LGR_ID_GRANTED, $lgrId);

    $data  = ['usr_id' => '3', 'usr_name' => 'abc'];
    $lgrId = $requirement->validate($data);
    self::assertSame(C::LGR_ID_GRANTED, $lgrId);
  }

  //--------------------------------------------------------------------------------------------------------------------
}

//----------------------------------------------------------------------------------------------------------------------
