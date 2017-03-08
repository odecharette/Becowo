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

    public function getAllActiveMembers()
    {
        $repo = $this->em->getRepository('BecowoMemberBundle:Member');
        return $repo->findAllActiveMembers();
    }

    public function getMemberById($id)
    {
        $repo = $this->em->getRepository('BecowoMemberBundle:Member');
        return $repo->findOneById($id);
    }

    public function getAllActiveMembersWithWsBooked()
    {
        $repo = $this->em->getRepository('BecowoMemberBundle:Member');
        return $repo->findAllActiveMembersWithWsBooked();
    }

    public function getMembersHasNotReceivedMailNewUser()
    {
        $repo = $this->em->getRepository('BecowoMemberBundle:Member');
        return $repo->findMembersHasNotReceivedMailNewUser();
    }

     public function getActiveMembersByFillRate($rate)
    {
        $repo = $this->em->getRepository('BecowoMemberBundle:Member');
        return $repo->findActiveMembersByFillRate($rate);
    }

}
