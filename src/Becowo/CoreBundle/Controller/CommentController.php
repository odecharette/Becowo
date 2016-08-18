<?php

namespace Becowo\CoreBundle\Controller;

use Becowo\CoreBundle\Entity\Comment;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Becowo\CoreBundle\Form\Type\CommentType;
use Symfony\Component\HttpFoundation\Request;

class CommentController extends Controller
{

  public function viewAction(Request $request)
  {
    $WsService = $this->get('app.workspace');
    $ws = $WsService->getWorkspaceByName($request->get('name'));
    $listComments = $WsService->getCommentsByWorkspace($ws);
    $votes = $WsService->getVotesByWorkspace($ws);

    // Création du formulaire de commentaires
    $comment = new Comment($ws, $this->getUser());
    $form = $this->get('form.factory')->create(CommentType::class, $comment);

    if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
      $em = $this->getDoctrine()->getManager();
      $em->persist($comment);
      $em->flush();

      $this->addFlash('success', 'Commentaire bien enregistré.');

      return $this->redirectToRoute('becowo_comment', array('name' => $request->get('name')));
    }

    return $this->render('Workspace/comments.html.twig', array('form' => $form->createView(), 'listComments' => $listComments, 'ws' =>$ws, 'votes' =>$votes));
  }
}
