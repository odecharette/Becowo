<?php

namespace Becowo\CoreBundle\Controller;

use Becowo\CoreBundle\Entity\Comment;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Becowo\CoreBundle\Form\Type\CommentType;
use Symfony\Component\HttpFoundation\Request;

class CommentController extends Controller
{

  // public function viewAction(Request $request)
  // {
  //   $WsService = $this->get('app.workspace');
  //   $ws = $WsService->getWorkspaceByName($request->get('name'));
  //   $listComments = $WsService->getCommentsByWorkspace($ws);
  //   $voteAlreadyDone = $WsService->memberAlreadyVoteAndCommentForWorkspace($ws, $this->getUser());

  //   // Création du formulaire de commentaires
  //   $comment = new Comment($ws, $this->getUser());
  //   // Important : il faut utiliser createNamedBuilder si plusieurs form dans la meme page !!!!
  //   $formComment = $this->get('form.factory')->createNamedBuilder('comment', CommentType::class, $comment)->getForm();


  //   if ($request->isMethod('POST') && $formComment->handleRequest($request)->isValid() && $request->request->has('comment'))
  //   { 
  //     $em = $this->getDoctrine()->getManager();
  //     $em->persist($comment);
  //     $em->flush();

  //     $this->addFlash('success', 'Merci ! Commentaire et vote bien enregistrés.');

  //     return $this->redirectToRoute('becowo_comment', array('name' => $request->get('name')));
  //   }

  //   return $this->render('Workspace/comments.html.twig', array('formComment' => $formComment->createView(), 'listComments' => $listComments, 'ws' =>$ws, 'voteAlreadyDone' => $voteAlreadyDone));
  // }
}
