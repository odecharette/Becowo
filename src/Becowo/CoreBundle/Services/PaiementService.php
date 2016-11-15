<?php

namespace Becowo\CoreBundle\Services;

use Doctrine\ORM\EntityManager;
// use Becowo\CoreBundle\Entity\Comment;
use Doctrine\ORM\NoResultException;

class PaiementService
{
    private $em = null;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    public function getPaiementInfos()
    {
        $repo = $this->em->getRepository('BecowoCoreBundle:PaiementConfig');
        return $repo->findPaiementInfos();
        
    }

 
}
