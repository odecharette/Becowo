<?php

namespace Becowo\CoreBundle\Services;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\NoResultException;

class StatService
{
    private $em = null;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    public function getCountActiveWorkspaces()
    {
        $repo = $this->em->getRepository('BecowoCoreBundle:Workspace');
     
        return $repo->createQueryBuilder('w')
            ->select('count(w.id)')
            ->andWhere('w.isDeleted = false')
            ->andWhere('w.isVisible = true')
            ->getQuery()
            ->getSingleScalarResult(); 
    }

    public function getCountActiveWorkspacesByOffer()
    {
        $repo = $this->em->getRepository('BecowoCoreBundle:Workspace');
     
        return $repo->createQueryBuilder('w')
            ->select('o.name, count(w.id) AS nb')
            ->leftJoin('w.offer', 'o')
            ->andWhere('w.isDeleted = false')
            ->andWhere('w.isVisible = true')
            ->groupBy('o.name')
            ->orderBy('nb', 'DESC')
            ->getQuery()
            ->getResult(); 
    }

    public function getCountActiveMembers()
    {
        $repo = $this->em->getRepository('BecowoMemberBundle:Member');
     
        return $repo->createQueryBuilder('m')
            ->select('count(m.id)')
            ->andWhere('m.isDeleted = false')
            ->getQuery()
            ->getSingleScalarResult(); 
    }

    public function getCountActiveMembersBySignedUpWith()
    {
        $repo = $this->em->getRepository('BecowoMemberBundle:Member');
     
        return $repo->createQueryBuilder('m')
            ->select('m.signedUpWith, count(m.id) AS nb')
            ->andWhere('m.isDeleted = false')
            ->groupBy('m.signedUpWith')
            ->orderBy('nb', 'DESC')
            ->getQuery()
            ->getResult(); 
    }

    public function getCountEvents()
    {
        $repo = $this->em->getRepository('BecowoCoreBundle:Event');
     
        return $repo->createQueryBuilder('e')
            ->select('count(e.id)')
            ->getQuery()
            ->getSingleScalarResult(); 
    }

    public function getCountEventsByWorkspace()
    {
        $repo = $this->em->getRepository('BecowoCoreBundle:Event');
     
        return $repo->createQueryBuilder('e')
            ->select('w.name, count(e.id) AS nb')
            ->leftJoin('e.workspace', 'w')
            ->groupBy('w.name')
            ->orderBy('nb', 'DESC')
            ->getQuery()
            ->getResult(); 
    }

}
