<?php

namespace Becowo\ManagerBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class CommentController extends Controller
{
  public function viewAction()
  {
  	$WsService = $this->get('app.workspace');

  	$comments = $WsService->getVotesByWorkspace($this->getUser()->getWorkspace());

  	return $this->render('Manager/comment/comment.html.twig', array('comments' => $comments));
  }

  public function voteAction()
  {
    $WsService = $this->get('app.workspace');

    $comments = $WsService->getVotesByWorkspace($this->getUser()->getWorkspace());
    $voteAvg = $WsService->getAverageVoteByWorkspace($this->getUser()->getWorkspace());
    $score1Avg = $WsService->getAverageScore1ByWorkspace($this->getUser()->getWorkspace());
    $score2Avg = $WsService->getAverageScore2ByWorkspace($this->getUser()->getWorkspace());
    $score3Avg = $WsService->getAverageScore3ByWorkspace($this->getUser()->getWorkspace());
    $score4Avg = $WsService->getAverageScore4ByWorkspace($this->getUser()->getWorkspace());

    return $this->render('Manager/comment/vote.html.twig', array(
      'comments' => $comments,
      'voteAvg' => $voteAvg,
      'score1Avg' => $score1Avg,
      'score2Avg' => $score2Avg,
      'score3Avg' => $score3Avg,
      'score4Avg' => $score4Avg,));
  }

}
