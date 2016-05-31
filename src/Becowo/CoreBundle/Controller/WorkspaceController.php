<?php

namespace Becowo\CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Becowo\CoreBundle\Entity\Workspace;

class WorkspaceController extends Controller
{
  public function viewAction($name)
  {
  	$em = $this->getDoctrine()->getManager();

  	// on récupère le WS selon le name passé en paramètres dans l'URL
  	$repo = $em->getRepository('BecowoCoreBundle:Workspace');
  	$ws = $repo->findOneByName($name);

  	return $this->render('BecowoCoreBundle:Workspace:view.html.twig', array('ws' => $ws));
  }

}