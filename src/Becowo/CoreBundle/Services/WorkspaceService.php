<?php

namespace Becowo\CoreBundle\Services;

use Doctrine\ORM\EntityManager;
use Becowo\CoreBundle\Entity\Workspace;
use Becowo\CoreBundle\Entity\Office;
use Doctrine\ORM\NoResultException;
use \DateTime;
use \DateInterval;

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

    public function getActiveWorkspacesOrderByVoteAvg()
    {
        $repo = $this->em->getRepository('BecowoCoreBundle:Workspace');
     
        try {
            return $repo->findActiveWorkspacesOrderByVoteAvg();
        } catch (NoResultException $e) {
            return false;
        }
        
    }

    // public function getActiveWorkspacesOrderByVoteAvgAndWithoutVote()
    // {
    //     $WswithVote = $this->getActiveWorkspacesOrderByVoteAvg(); 
    //     $AllActiveWs = $this->getActiveWorkspaces();

    //     // En queryBuilder impossible de faire une requet en Union donc on récup 
    //     // 1/ Tous les WS qui ont un vote, trié sur scoreAVg en Desc
    //     // 2/ Tous les WS
    //     // 3/ On merge les 2 résultats
    //     // 4/ On enlève les doublons
    //     $workspaces = array_merge($WswithVote, $AllActiveWs);
    //     $workspaces = array_unique($workspaces);

    //     return $workspaces;

    // }

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
        return $repo->findBy(array('workspace' => $ws), array('startDate' => 'DESC'));
    }

    public function getFuturEventsByWorkspaceOrderByDate(Workspace $ws)
    {
        $repo = $this->em->getRepository('BecowoCoreBundle:Event');
        return $repo->findFuturEventsByWorkspaceOrderByDate($ws);
    }

    public function getEventByFacebookId($facebook_id)
    {
        $repo = $this->em->getRepository('BecowoCoreBundle:Event');
        return $repo->findBy(array('facebookId' => $facebook_id));
    }

    public function getAllEvents()
    {
        $repo = $this->em->getRepository('BecowoCoreBundle:Event');
        return $repo->findAll();
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
        return $repo->findBookingByWs($ws);
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
    
    public function getPricesByWsHasOfficeId($id)
    {
        $repo = $this->em->getRepository('BecowoCoreBundle:Price');
        return $repo->findPricesByWsHasOfficeId($id);
    }

    public function getAverageVoteByWorkspace(Workspace $ws)
    {
        $repo = $this->em->getRepository('BecowoCoreBundle:Comment');
        return $repo->getAverage($ws);
    }


    public function getAverageScore1ByWorkspace(Workspace $ws)
    {
        $repo = $this->em->getRepository('BecowoCoreBundle:Comment');
        return $repo->getAverageScore1($ws);
    }


    public function getAverageScore2ByWorkspace(Workspace $ws)
    {
        $repo = $this->em->getRepository('BecowoCoreBundle:Comment');
        return $repo->getAverageScore2($ws);
    }


    public function getAverageScore3ByWorkspace(Workspace $ws)
    {
        $repo = $this->em->getRepository('BecowoCoreBundle:Comment');
        return $repo->getAverageScore3($ws);
    }


    public function getAverageScore4ByWorkspace(Workspace $ws)
    {
        $repo = $this->em->getRepository('BecowoCoreBundle:Comment');
        return $repo->getAverageScore4($ws);
    }

    public function getVotesByWorkspace(Workspace $ws)
    {
        $repo = $this->em->getRepository('BecowoCoreBundle:Comment');
        return $repo->getVotesByWorkspace($ws);
    }

    public function memberAlreadyVoteAndCommentForWorkspace(Workspace $ws, $member)
    {
        $repo = $this->em->getRepository('BecowoCoreBundle:Comment');
        $comment = $repo->getMemberCommentForWorkspace($ws, $member);
        if(sizeof($comment)>0)
        {
            return true;
        }
        else
        {
            return false;
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

    public function getWsBookedByMemberId($id)
    {
        $repo = $this->em->getRepository('BecowoCoreBundle:Booking');
        return $repo->findWsBookedByMemberId($id);
    }

    public function getWsByBooking($booking)
    {
        $repo = $this->em->getRepository('BecowoCoreBundle:Booking');
        return $repo->findWsByBooking($booking);
    }

    public function getWsHasTeamMemberByWorkspace($ws)
    {
        $repo = $this->em->getRepository('BecowoCoreBundle:WorkspaceHasTeamMember');
        return $repo->findWsHasTeamMemberByWorkspace($ws);
    }
    
    public function getWsHasTeamMemberForEmailBookingByWorkspace($ws)
    {
        $repo = $this->em->getRepository('BecowoCoreBundle:WorkspaceHasTeamMember');
        return $repo->findWsHasTeamMemberForEmailBookingByWorkspace($ws);
    }

    public function getBookingByMember($user)
    {
        $repo = $this->em->getRepository('BecowoCoreBundle:Booking');
        return $repo->findBookingByMember($user);
    }


    public function getWsByWsNetwork($network, $name)
    {
        $repo = $this->em->getRepository('BecowoCoreBundle:Workspace');
        return $repo->findWsByWsNetwork($network, $name);
    }

    public function getAmenitiesByWorkspace($ws)
    {
        $repo = $this->em->getRepository('BecowoCoreBundle:WorkspaceHasAmenities');
        return $repo->findAmenitiesByWorkspace($ws);
    }

    public function getAmenitiesByWorkspaceId($id)
    {
        $repo = $this->em->getRepository('BecowoCoreBundle:WorkspaceHasAmenities');
        return $repo->findAmenitiesByWorkspaceId($id);
    }

    public function getQuantityByOfficeType($ws)
    {
        $repo = $this->em->getRepository('BecowoCoreBundle:WorkspaceHasOffice');
        return $repo->findQuantityByOfficeType($ws);
    }

    public function getListOfActiveCities()
    {
        $repo = $this->em->getRepository('BecowoCoreBundle:Workspace');
        return $repo->findListOfActiveCities();
    }

    public function getListOfWsWithEvents()
    {
        $repo = $this->em->getRepository('BecowoCoreBundle:Event');
        return $repo->findListOfWsWithEvents();
    }

    public function getAllCommunityNetwork()
    {
        $repo = $this->em->getRepository('BecowoCoreBundle:CommunityNetwork');
        return $repo->findAll();
    }

    public function getCommunityNetworkById($id)
    {
        $repo = $this->em->getRepository('BecowoCoreBundle:CommunityNetwork');
        return $repo->findBy(array('id' => $id));
    }

    public function getCommunityNetworkByMember($member)
    {
        $repo = $this->em->getRepository('BecowoCoreBundle:CommunityNetworkHasMember');
        return $repo->findBy(array('member' => $member));
    }

    public function getMembersByNetworkId($idCommunity)
    {
        $repo = $this->em->getRepository('BecowoCoreBundle:CommunityNetworkHasMember');
        return $repo->findMembersByNetworkId($idCommunity);
    }

    public function getMembersByNetworkName($network)
    {
        $repo = $this->em->getRepository('BecowoCoreBundle:CommunityNetworkHasMember');
        return $repo->findMembersByNetworkName($network);
    }

    public function getNextOpenDateByWorkspace($ws)
    {
        
        $weekend = $this->getTimesByWorkspace($ws);
        $closed_dates = $this->getClosedDatesByWorkspace($ws);

        // on commence par tester si aujourd'hui est ouvré
        $resultat = $this->getNextDateOpen(new DateTime(date('d-m-Y')), $weekend, $closed_dates);

        //Pour simuler qu'on est le samedi 11 mars
        // $resultat = $this->getNextDateOpen(new DateTime(date('11-03-2017')), $weekend, $closed_dates);

        return $resultat;
    }

    public function getNextDateOpen(DateTime $date, $weekend, $closed_dates)
    {
        $weekDay = $date->format("w"); // 0 being sunday, and 6 being saturday
        $result = true;
        $finalDate = $date;

        switch ($weekDay) {
            case 6:
                // Saturday
                if($weekend[0]->getIsOpenSaturday())
                {
                    // dump('ouvert samedi test si samedi est in closed date');
                    foreach($closed_dates as $d)
                    {
                        if($d->getClosedDate() == $date)
                            $result = false;
                    }
                    if($result){
                        // dump('DONE samedi est ni WE fermé ni closed date');
                        $finalDate = $date;
                    }else{
                        // dump('date est fermée, test jour suivant');
                        $this->getNextDateOpen($date->add(new DateInterval('P1D')), $weekend, $closed_dates);
                    }
                }else{
                    // dump('fermé samedi, test jour suivant');
                    $this->getNextDateOpen($date->add(new DateInterval('P1D')), $weekend, $closed_dates);
                }

                break;
            case 0:
                // Sunday
                if($weekend[0]->getIsOpenSunday())
                {
                    // dump('ouvert dimanche test si dimanche est in closed date');
                    foreach($closed_dates as $d)
                    {
                        if($d->getClosedDate() == $date)
                            $result = false;
                    }
                    if($result){
                        // dump('DONE dimanche est ni WE fermé ni closed date');
                        $finalDate = $date;
                    }else{
                        // dump('date est fermée, test jour suivant');
                        $this->getNextDateOpen($date->add(new DateInterval('P1D')), $weekend, $closed_dates);
                    }
                }else{
                    // dump('fermé dimanche, test jour suivant');
                    $this->getNextDateOpen($date->add(new DateInterval('P1D')), $weekend, $closed_dates);
                }
                break;

            default:
                # Monday to friday
                // dump('test si jour est in closed date');
                foreach($closed_dates as $d)
                {
                    if($d->getClosedDate() == $date)
                        $result = false;
                }
                if($result){
                    // dump('DONE jour pas ds closed date');
                    $finalDate = $date;
                }else{
                    // dump('date est fermée, test jour suivant');
                    $this->getNextDateOpen($date->add(new DateInterval('P1D')), $weekend, $closed_dates);
                }
                break;
        }
        return $finalDate;
    }

    public function getReductionByCode($code)
    {
        $repo = $this->em->getRepository('BecowoCoreBundle:Reduction');
        return $repo->findOneBy(array('code' => $code));
    }
}
