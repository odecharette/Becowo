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

    public function getAllPicturesByWorkspace(Workspace $ws)
    {
        $repo = $this->em->getRepository('BecowoCoreBundle:Picture');
        return $repo->findBy(array('workspace' => $ws));

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

    public function getWorkspaceByName($name)
    {
        $repo = $this->em->getRepository('BecowoCoreBundle:Workspace');
        return $repo->findOneByName($name);
    }

    public function getPicturesByWorkspace($name)
    {
        $repo = $this->em->getRepository('BecowoCoreBundle:Picture');
        return $repo->findByWsNoLogo($name);
    }

    public function getFavoritePictureByWorkspace($name)
    {
        $repo = $this->em->getRepository('BecowoCoreBundle:Picture');
        return $repo->findByWsFavorite($name);
    }

    public function getLogoByWorkspace($name)
    {
        $repo = $this->em->getRepository('BecowoCoreBundle:Picture');
        return $repo->findByWsLogo($name);
    }

    public function getEventsByWorkspace(Workspace $ws)
    {
        $repo = $this->em->getRepository('BecowoCoreBundle:Event');
        return $repo->findBy(array('workspace' => $ws));
    }

    public function getOfficesByWorkspace(Workspace $ws)
    {
        $repo = $this->em->getRepository('BecowoCoreBundle:WorkspaceHasOffice');
        return $repo->findBy(array('workspace' => $ws));
    }

    public function getCommentsByWorkspace(Workspace $ws)
    {
        $repo = $this->em->getRepository('BecowoCoreBundle:Comment');
        return $repo->findBy(
          array('workspace' => $ws),
          array('postedOn' => 'DESC'),
          null,
          null);
    }

    public function getReservationsByWorkspace(Workspace $ws)
    {
        $repo = $this->em->getRepository('BecowoCoreBundle:Booking');
        return $repo->findBy(array('workspace' => $ws));
    }

    public function getTotalInclTaxReservationsByWorkspace(Workspace $ws)
    {
        $repo = $this->em->getRepository('BecowoCoreBundle:Booking');
        return  $repo->getTotInclTaxReservationsByWorkspace($ws->getId());
    }



}
