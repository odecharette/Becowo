<?php

namespace Becowo\CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Becowo\CoreBundle\Entity\Vote;
use Becowo\CoreBundle\Entity\Comment;
use Becowo\CoreBundle\Form\CommentType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;

class WorkspaceController extends Controller
{
  public function viewAction($name, Request $request)
  {

    $WsService = $this->get('app.workspace');

    $ws = $WsService->getWorkspaceByName($name);
    $pictures = $WsService->getPicturesByWorkspace($name);
    $pictureFavorite = $WsService->getFavoritePictureByWorkspace($name);
    $pictureLogo = $WsService->getLogoByWorkspace($name);
    $listEvents = $WsService->getEventsByWorkspace($ws);
    $listOffices = $WsService->getOfficesByWorkspace($ws);
    $prices = $WsService->getPricesByWorkspace($ws);
    $averageVote = $WsService->getAverageVoteByWorkspace($ws);

  	return $this->render('Workspace/view.html.twig', 
      array('ws' => $ws, 
        'listEvents' => $listEvents, 
        'pictures' => $pictures, 
        'pictureFavorite' => $pictureFavorite, 
        'pictureLogo' => $pictureLogo,
        'listOffices' => $listOffices,
        'prices' => $prices,
        'averageVote' => $averageVote));
  }

 
}