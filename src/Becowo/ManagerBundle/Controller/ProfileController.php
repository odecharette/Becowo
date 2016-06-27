<?php

namespace Becowo\ManagerBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Becowo\CoreBundle\Entity\Workspace;
use Becowo\CoreBundle\Form\WorkspaceType;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class ProfileController extends Controller
{
  public function viewAction(Request $request)
  {

  	$workspace = $this->getUser()->getWorkspace();	// current WS of connected manager
  	$formBuilder = $this->get('form.factory')->createBuilder(FormType::class, $workspace);
	$formBuilder->add('description', TextAreaType::class);
	$formDesc = $formBuilder->getForm();

	$formBuilder2 = $this->get('form.factory')->createBuilder(FormType::class, $workspace);
	$formBuilder2->add('descriptionBonus', TextType::class);
	$formDescBonus = $formBuilder2->getForm();


  	if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
      $em = $this->getDoctrine()->getManager();
      $em->persist($workspace);
      $em->flush();

      $request->getSession()->getFlashBag()->add('success', 'Modification bien enregistrée.');

      return $this->redirectToRoute('becowo_manager_profile');
    }

  	return $this->render('Manager/workspace_profile.html.twig', array('formDesc' => $formDesc->createView(), 'formDescBonus' => $formDescBonus->createView()));
  }


}