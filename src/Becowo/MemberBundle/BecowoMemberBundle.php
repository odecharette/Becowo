<?php

namespace Becowo\MemberBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class BecowoMemberBundle extends Bundle
{
	public function getParent()
  {
    return 'FOSUserBundle';
  }
}
