<?php

namespace Becowo\CoreBundle\Services;

use Doctrine\ORM\EntityManager;
use Becowo\CoreBundle\Entity\Comment;
use Doctrine\ORM\NoResultException;

class CommentService
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
