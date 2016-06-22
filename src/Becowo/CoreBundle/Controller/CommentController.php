<?php

namespace Becowo\CoreBundle\Controller;

use Becowo\CoreBundle\Entity\Comment;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Becowo\CoreBundle\Form\CommentType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

class CommentController extends Controller
{

  public function viewAction(Request $request)
  {
    $WsService = $this->get('app.workspace');
    $ws = $WsService->getWorkspaceByName('YellowWorking');
    $listComments = $WsService->getCommentsByWorkspace($ws);

    // Création du formulaire de commentaires
    $comment = new Comment($ws, $this->getUser());
    $form = $this->get('form.factory')->create(CommentType::class, $comment);

    if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
        $em = $this->getDoctrine()->getManager();
        $em->persist($comment);
        $em->flush();

        $this->addFlash('success', 'Commentaire bien enregistré.');

        return new JsonResponse(array('message' => 'Success!'), 200);
     }

    return $this->render('Workspace/comments.html.twig', array('form' => $form->createView(), 'listComments' => $listComments));
  }
}