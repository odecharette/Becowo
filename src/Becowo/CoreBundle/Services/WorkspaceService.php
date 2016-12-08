<?php

namespace Becowo\CoreBundle\Services;

use Doctrine\ORM\EntityManager;
use Becowo\CoreBundle\Entity\Workspace;
use Becowo\CoreBundle\Entity\Office;
use Doctrine\ORM\NoResultException;

class WorkspaceService
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
        } catch (NoResultException $e) {
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

    public function getWorkspaceById($id)
    {
        $repo = $this->em->getRepository('BecowoCoreBundle:Workspace');
        return $repo->findOneById($id);
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

    public function getFavoritePictureUrlByWorkspace($name)
    {
        $repo = $this->em->getRepository('BecowoCoreBundle:Picture');
        return $repo->findByWsFavoriteUrl($name);
    }

    public function getLogoByWorkspace($name)
    {
        $repo = $this->em->getRepository('BecowoCoreBundle:Picture');
        return $repo->findByWsLogo($name);
    }

    public function getLogoUrlByWorkspace($name)
    {
        $repo = $this->em->getRepository('BecowoCoreBundle:Picture');
        return $repo->findByWsUrlLogo($name);
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

    public function getBookingByRef($ref)
    {
        $repo = $this->em->getRepository('BecowoCoreBundle:Booking');
        return $repo->getBookingByRef($ref);
    }

    public function getTotalInclTaxReservationsByWorkspace(Workspace $ws)
    {
        $repo = $this->em->getRepository('BecowoCoreBundle:Booking');
        return  $repo->getTotInclTaxReservationsByWorkspace($ws->getId());
    }

    public function getPricesByWorkspace(Workspace $ws)
    {
        $repo = $this->em->getRepository('BecowoCoreBundle:Price');
        return $repo->findPricesByWorkspace($ws);
    }

    public function getAverageVoteByWorkspace(Workspace $ws)
    {
        $repo = $this->em->getRepository('BecowoCoreBundle:Vote');
        return $repo->getAverage($ws);
    }

    public function getVotesByWorkspace(Workspace $ws)
    {
        $repo = $this->em->getRepository('BecowoCoreBundle:Vote');
        return $repo->getVotesByWorkspace($ws);
    }

    public function memberAlreadyVoteAndCommentForWorkspace(Workspace $ws, $member)
    {
        $repo = $this->em->getRepository('BecowoCoreBundle:Vote');
        $vote = $repo->getMemberVoteForWorkspace($ws, $member);

        $repo = $this->em->getRepository('BecowoCoreBundle:Comment');
        $comment = $repo->getMemberCommentForWorkspace($ws, $member);

        if(empty($vote) && empty($Comment))
        {
            return false;
        }
        else
        {
            return true;
        }
        
    }

    public function getTimesByWorkspace(Workspace $ws)
    {
        $repo = $this->em->getRepository('BecowoCoreBundle:Timetable');
        return $repo->findOpenCloseHoursByWorkspaces($ws);
    }

    public function getClosedDatesByWorkspace(Workspace $ws)
    {
        $repo = $this->em->getRepository('BecowoCoreBundle:WorkspaceIsClosed');
        return $repo->findClosedDatesByWorkspaces($ws);
    }

    public function getOfficeByName($name)
    {
        //Récup l'objet Office de la table office
        $repo = $this->em->getRepository('BecowoCoreBundle:Office');
        return $repo->findOfficeByName($name);
    }

    public function getOfficeOfWorkspaceByWsOfficeName(Workspace $ws, Office $office, $name)
    {
        //Récup l'objet de la table office Workspace_has_office
        $repo = $this->em->getRepository('BecowoCoreBundle:WorkspaceHasOffice');
        return $repo->findOfficeOfWorkspaceByWsOfficeName($ws, $office, $name);
    }

    public function getStatusById($id)
    {
        $repo = $this->em->getRepository('BecowoCoreBundle:Status');
        return $repo->findStatusById($id);
    }

    public function getWsHasOfficeById($id)
    {
        $repo = $this->em->getRepository('BecowoCoreBundle:WorkspaceHasOffice');
        return $repo->findWsHasOfficeById($id);
    }

    public function getBookingByWsHasOfficeId($id)
    {
        $repo = $this->em->getRepository('BecowoCoreBundle:Booking');
        return $repo->findBookingByWsHasOfficeId($id);
    }

    public function getOffersByWorkspace($ws)
    {
        $repo = $this->em->getRepository('BecowoCoreBundle:WorkspaceHasOffer');
        return $repo->findOffersByWorkspace($ws);
    }
}
