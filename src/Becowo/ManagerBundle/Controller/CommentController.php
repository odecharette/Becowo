<?php

namespace Becowo\ManagerBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class CommentController extends Controller
{
  public function viewAction($id)
  {
  	$WsService = $this->get('app.workspace');
    $workspace = $WsService->getWorkspaceById($id);

  	$comments = $WsService->getVotesByWorkspace($workspace);

  	return $this->render('Manager/comment/comment.html.twig', array('comments' => $comments, 'workspace' => $workspace));
  }

  public function voteAction($id)
  {
    $WsService = $this->get('app.workspace');
    $workspace = $WsService->getWorkspaceById($id);

    $comments = $WsService->getVotesByWorkspace($workspace);
    $voteAvg = $WsService->getAverageVoteByWorkspace($workspace);
    $score1Avg = $WsService->getAverageScore1ByWorkspace($workspace);
    $score2Avg = $WsService->getAverageScore2ByWorkspace($workspace);
    $score3Avg = $WsService->getAverageScore3ByWorkspace($workspace);
    $score4Avg = $WsService->getAverageScore4ByWorkspace($workspace);

    return $this->render('Manager/comment/vote.html.twig', array(
      'comments' => $comments,
      'voteAvg' => $voteAvg,
      'score1Avg' => $score1Avg,
      'score2Avg' => $score2Avg,
      'score3Avg' => $score3Avg,
      'score4Avg' => $score4Avg,
      'workspace' => $workspace));
  }

}
