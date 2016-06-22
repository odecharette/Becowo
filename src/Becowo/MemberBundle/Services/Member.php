<?php

namespace Becowo\CoreBundle\Services;

use Doctrine\ORM\EntityManager;
use Becowo\MemberBundle\Entity\Member;

class Member
{
    private $em = null;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    


}