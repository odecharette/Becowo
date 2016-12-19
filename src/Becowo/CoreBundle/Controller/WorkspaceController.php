<?php

namespace Becowo\CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class WorkspaceController extends Controller
{
  public function viewAction($name, Request $request)
  {

    $WsService = $this->get('app.workspace');

    $ws = $WsService->getWorkspaceByName($name);
    $pictures = $WsService->getPicturesByWorkspace($name);
    // $pictureFavorite = $WsService->getFavoritePictureByWorkspace($name);
    $pictureLogo = $WsService->getLogoByWorkspace($name);
    $listEvents = $WsService->getEventsByWorkspace($ws);
    //$listOffices = $WsService->getOfficesByWorkspace($ws);
    // $prices = $WsService->getPricesByWorkspace($ws);
    $averageVote = $WsService->getAverageVoteByWorkspace($ws);
    // $times = $WsService->getTimesByWorkspace($ws);
    // $closedDates = $WsService->getClosedDatesByWorkspace($ws);
    $pricesAndOffices = $WsService->getPricesByWorkspace($ws);
    $WsHasTeamMembers = $WsService->getWsHasTeamMemberByWorkspace($ws);
dump($WsHasTeamMembers);
  	return $this->render('Workspace/view.html.twig', 
      array('ws' => $ws, 
        'listEvents' => $listEvents, 
        'pictures' => $pictures, 
        // 'pictureFavorite' => $pictureFavorite, 
        'pictureLogo' => $pictureLogo,
        //'listOffices' => $listOffices,
        // 'prices' => $prices,
        'pricesAndOffices' => $pricesAndOffices,
        'averageVote' => $averageVote,
        'WsHasTeamMembers' => $WsHasTeamMembers
        // 'times' => $times,
        // 'closedDates' => $closedDates
        ));
  }

  public function visitAction($name, Request $request)
  {
    $WsService = $this->get('app.workspace');
    $ws = $WsService->getWorkspaceByName($name);

    return $this->render('Workspace/visit360.html.twig', array('ws' => $ws));
  }


}
