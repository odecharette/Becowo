<?php

namespace Becowo\CoreBundle\Services;

use Doctrine\ORM\EntityManager;
use Becowo\CoreBundle\Entity\ErrorCodes;
use Doctrine\ORM\NoResultException;

class ErrorService
{
    private $em = null;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    public function getErrorByCode($code)
    {
        $repo = $this->em->getRepository('BecowoCoreBundle:ErrorCodes');
        return $repo->findErrorByCode($code);
    }

    
}
