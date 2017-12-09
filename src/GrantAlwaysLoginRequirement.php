<?php
//----------------------------------------------------------------------------------------------------------------------
namespace SetBased\Abc\Login;

use SetBased\Abc\C;

/**
 * Login requirement: Grant always - always grants login.
 */
class GrantAlwaysLoginRequirement implements LoginRequirement
{
  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Validates nothing.
   *
   * @param array $data Not used.
   *
   * @return int
   */
  public function validate(&$data)
  {
    return C::LGR_ID_GRANTED;
  }

  //--------------------------------------------------------------------------------------------------------------------
}

//----------------------------------------------------------------------------------------------------------------------
