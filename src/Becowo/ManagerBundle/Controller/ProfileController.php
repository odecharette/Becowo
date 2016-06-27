<?php

namespace Becowo\ManagerBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Becowo\CoreBundle\Entity\Workspace;
use Becowo\CoreBundle\Form\WorkspaceType;

class ProfileController extends Controller
{
  public function viewAction(Request $request)
  {

  	$workspace = $this->getUser()->getWorkspace();	// current WS of connected manager
  	$form = $this->get('form.factory')->create(WorkspaceType::class, $workspace);

  	if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
      $em = $this->getDoctrine()->getManager();
      $em->persist($workspace);
      $em->flush();

      $request->getSession()->getFlashBag()->add('success', 'Modification bien enregistrée.');

      return $this->redirectToRoute('becowo_manager_profile');
    }

  	return $this->render('Manager/workspace_profile.html.twig', array('form' => $form->createView()));
  }


}