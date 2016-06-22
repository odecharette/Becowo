<?php

namespace Becowo\CoreBundle\Services;

use Doctrine\ORM\EntityManager;
use Becowo\CoreBundle\Entity\Workspace;

class Workspace
{
    private $em = null;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    public function getActiveWorkspaces()
    {
        $repo = $this->em->getRepository('BecowoCoreBundle:Workspace');
     
        try {
            return $repo->findActiveWorkspaces();
        } catch (DoctrineORMNoResultException $e) {
            return false;
        }
        
    }

    public function getPicturesByWorkspaces(array $Workspaces)
    {
        $picturesByWs = array();
        $repo = $this->em->getRepository('BecowoCoreBundle:Picture');
        foreach ($Workspaces as $ws) {
          $picturesByWs[$ws->getName()] = $repo->findByWsNoLogo($ws->getName());
        }
        return $picturesByWs;

    }

    public function getOfficesByWorkspaces(array $Workspaces)
    {
        $OfficesByWs = array();
        $repo = $this->em->getRepository('BecowoCoreBundle:WorkspaceHasOffice');
        foreach ($Workspaces as $ws) {
          $OfficesByWs[$ws->getName()] = $repo->findBy(array('workspace' => $ws));
        }
        return $OfficesByWs;
    }

    public function getFavoriteWorkspace()
    {
        $repo = $this->em->getRepository('BecowoCoreBundle:WorkspaceFavorite');
     
        try {
            return $repo->findOneBy(array(), array('createdOn' => 'desc'));
        } catch (DoctrineORMNoResultException $e) {
            return false;
        }
        
    }


}