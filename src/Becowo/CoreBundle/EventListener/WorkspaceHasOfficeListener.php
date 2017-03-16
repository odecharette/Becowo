<?php

namespace Becowo\CoreBundle\EventListener;

use Symfony\Component\HttpFoundation\Response;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Becowo\CoreBundle\Entity\WorkspaceHasOffice;
use Symfony\Component\DependencyInjection\Container;
use Doctrine\ORM\Mapping as ORM;

class WorkspaceHasOfficeListener
{
  protected $container;
  protected $WsService = null;
    
    public function __construct(Container $container, $WsService)
    {
        $this->container = $container;
        $this->WsService = $WsService;
    }

// Le nom de la methode definit sont moment d'execution
  public function postPersist(WorkspaceHasOffice $who, LifecycleEventArgs $event) 
  {
 
    $em = $event->getEntityManager();
    $ws = $who->getWorkspace();
    $office = $who->getOffice();

    $existingOffices = $ws->getFilterOffices();
    if(!in_array($office, (array) $existingOffices))
    {
      $ws->addFilterOffices($office);
    }

    $em->persist($ws);
    $em->flush();
  }

  public function postUpdate(WorkspaceHasOffice $who, LifecycleEventArgs $event) 
  {
    $this->refreshFilterOffices($who->getWorkspace(), $event);
  }

  public function postRemove(WorkspaceHasOffice $who, LifecycleEventArgs $event) 
  {
    $this->refreshFilterOffices($who->getWorkspace(), $event);
  }

  public function refreshFilterOffices($ws, LifecycleEventArgs $event)
  {
    $em = $event->getEntityManager();
    $whoList = $this->WsService->getOfficesByWorkspace($ws);
    $existingOffices = $ws->getFilterOffices();
    $whoListOffices = array();

    foreach ($whoList as $who) {
      if(!$existingOffices->contains($who->getOffice()))
      {
        $ws->addFilterOffices($who->getOffice());
      }
      array_push($whoListOffices, $who->getOffice());
    }
    //on refraichit la variable après les ajouts
    $existingOffices = $ws->getFilterOffices();

    foreach ($existingOffices as $existOffice) {
      if(!in_array($existOffice, $whoListOffices))
      {
        $ws->removeFilterOffices($existOffice);
      }
    }

    $em->persist($ws);
    $em->flush();
  }
}
