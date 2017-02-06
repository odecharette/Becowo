<?php

namespace Becowo\CoreBundle\EventListener;

use Symfony\Component\HttpFoundation\Response;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Becowo\CoreBundle\Entity\Comment;
use Symfony\Component\DependencyInjection\Container;
use Doctrine\ORM\Mapping as ORM;

class CommentListener
{
  protected $container;
    
    public function __construct(Container $container)
    {
        $this->container = $container;
    }

// Le nom de la methode definit sont moment d'execution
  public function postPersist(Comment $comment, LifecycleEventArgs $event) 
  {
 
    $em = $event->getEntityManager();
    $ws = $comment->getWorkspace();

    $repo = $em->getRepository('BecowoCoreBundle:Comment');
    $voteAvg = $repo->getAverage($ws);
    
    $ws->setVoteAverage($voteAvg);

    $em->persist($ws);
    $em->flush();
  }
}
