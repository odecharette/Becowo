<?php

namespace Becowo\MemberBundle\Services;

use Doctrine\ORM\EntityManager;

class Member
{
    private $em = null;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    public function getLastActiveMembers($nb)
    {
        $repo = $this->em->getRepository('BecowoMemberBundle:Member');
     
        try {
            return $repo->findNewMembers($nb);
        } catch (DoctrineORMNoResultException $e) {
            return false;
        }
    }

}
