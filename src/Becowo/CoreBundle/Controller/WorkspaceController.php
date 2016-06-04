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
  	$em = $this->getDoctrine()->getManager();

  	// on récupère le WS selon le name passé en paramètres dans l'URL
  	$repo = $em->getRepository('BecowoCoreBundle:Workspace');
  	$ws = $repo->findOneByName($name);

    //On récupère les pictures liées au WS, sauf le logo
    $repo = $em->getRepository('BecowoCoreBundle:Picture');
    $pictures = $repo->findByWsNoLogo($name);

    // on récupère la photo favorite liée au WS
    $pictureFavorite = $repo->findByWsFavorite($name);

    // on récupère le logo du WS
    $pictureLogo = $repo->findByWsLogo($name);

    //On récupère les events liés à ce WS
    $repo = $em->getRepository('BecowoCoreBundle:Event');
    $listEvents = $repo->findBy(array('workspace' => $ws));

    // On récupère les offices et leur quantité
    $repo = $em->getRepository('BecowoCoreBundle:WorkspaceHasOffice');
    $listOffices = $repo->findBy(array('workspace' => $ws));

    // Création du formulaire de commentaires
    $comment = new Comment();
    $comment->setWorkspace($ws);
    $comment->setMember($this->getUser());
    $form = $this->get('form.factory')->create(CommentType::class, $comment);

    //on récupère les commentaires existants
    $repo = $em->getRepository('BecowoCoreBundle:Comment');
    $listComments = $repo->findBy(
      array('workspace' => $ws),
      array('postedOn' => 'DESC'),
      null,
      null);

    if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
        $em->persist($comment);
        $em->flush();

        $request->getSession()->getFlashBag()->add('success', 'Commentaire bien enregistré.');

        // On redirige vers la page de visualisation de l'annonce nouvellement créée
        return $this->redirectToRoute('becowo_core_workspace', array('name' => $name));
    }

  	return $this->render('BecowoCoreBundle:Workspace:view.html.twig', 
      array('ws' => $ws, 
        'listEvents' => $listEvents, 
        'pictures' => $pictures, 
        'pictureFavorite' => $pictureFavorite, 
        'pictureLogo' => $pictureLogo,
        'listOffices' => $listOffices,
        'form' => $form->createView(),
        'listComments' => $listComments));
  }

  public function voteAction($vote, $name, $member)
  {
    // TO DO IMPORTANT : revoir tout car ici je charge en dur le vote pour un WS et un membre
    $em = $this->getDoctrine()->getManager();
    $repo = $em->getRepository('BecowoCoreBundle:Workspace');
    $w = $repo->findOneByName('Mutualab');

    $repo = $em->getRepository('BecowoMemberBundle:Member');
    $m = $repo->findOneByFirstname('Olivia');


    $newVote = new Vote();
    $newVote->setScore1($vote);
    $newVote->setWorkspace($w);
    $newVote->setMember($m);

    $em->persist($newVote);
    $em->flush();

    

    return $this->redirectToRoute('becowo_core_workspace', array('name' => $name));
  }

}