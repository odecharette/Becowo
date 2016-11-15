<?php

namespace Becowo\CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class WorkspaceController extends Controller
{
  public function viewAction($name, Request $request)
  {

    $WsService = $this->get('app.workspace');
    $PaiementService = $this->get('app.paiement');

    $ws = $WsService->getWorkspaceByName($name);
    $pictures = $WsService->getPicturesByWorkspace($name);
    // $pictureFavorite = $WsService->getFavoritePictureByWorkspace($name);
    $pictureLogo = $WsService->getLogoByWorkspace($name);
    $listEvents = $WsService->getEventsByWorkspace($ws);
    $listOffices = $WsService->getOfficesByWorkspace($ws);
    $prices = $WsService->getPricesByWorkspace($ws);
    $averageVote = $WsService->getAverageVoteByWorkspace($ws);
    $times = $WsService->getTimesByWorkspace($ws);
    $closedDates = $WsService->getClosedDatesByWorkspace($ws);
    $paiementInfos = $PaiementService->getPaiementInfos();

  	return $this->render('Workspace/view.html.twig', 
      array('ws' => $ws, 
        'listEvents' => $listEvents, 
        'pictures' => $pictures, 
        // 'pictureFavorite' => $pictureFavorite, 
        'pictureLogo' => $pictureLogo,
        'listOffices' => $listOffices,
        'prices' => $prices,
        'averageVote' => $averageVote,
        'times' => $times,
        'closedDates' => $closedDates,
        'paiementInfos' => $paiementInfos));
  }

}
