<?php

namespace Becowo\CoreBundle\EventListener;

use Symfony\Component\HttpFoundation\Response;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Becowo\CoreBundle\Entity\Picture;
use Symfony\Component\DependencyInjection\Container;
use Doctrine\ORM\Mapping as ORM;

class PictureListener
{
  protected $container;
    
    public function __construct(Container $container)
    {
        $this->container = $container;
    }

// Le nom de la methode definit sont moment d'execution
  public function postUpdate(Picture $picture, LifecycleEventArgs $event) 
  {
dump('test'); 
    $em = $event->getEntityManager();
    $ws = $picture->getWorkspace();



    $repo = $em->getRepository('BecowoCoreBundle:Picture');
    $favoriteUrl = $repo->findByWsFavoriteUrl($ws);
    
    $ws->setFavoritePictureUrl($favoriteUrl);

    $em->persist($ws);
    $em->flush();
  }
}
