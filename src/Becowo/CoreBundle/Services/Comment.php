<?php

namespace Becowo\CoreBundle\Services;

use Doctrine\ORM\EntityManager;
use Becowo\CoreBundle\Entity\Comment;
use Doctrine\ORM\NoResultException;

class Comment
{
    private $em = null;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    public function getLastCommentsAndAuthor($nb)
    {
        $repo = $this->em->getRepository('BecowoCoreBundle:Comment');
     
        try {
            return $repo->findLastCommentsAndAuthor($nb);
        } catch (NoResultException $e) {
            return false;
        }
        
    }

 
}
