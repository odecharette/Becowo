<?php

namespace Becowo\ManagerBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Becowo\CoreBundle\Entity\Workspace;
use Becowo\CoreBundle\Form\WorkspaceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\FormType;

class ProfileController extends Controller
{
  public function viewAction(Request $request)
  {
  	//////////// TO DO : DELETE
  	$workspace = $this->getUser()->getWorkspace();	// current WS of connected manager

  	$WsService = $this->get('app.workspace');
  	$pictureLogo = $WsService->getLogoByWorkspace($workspace->getName());
  	$listOffices = $WsService->getOfficesByWorkspace($workspace);
  	
  	$form = $this->get('form.factory')->create(WorkspaceType::class, $workspace);

  	if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
      $em = $this->getDoctrine()->getManager();
      $em->persist($workspace);
      $em->flush();

      $request->getSession()->getFlashBag()->add('success', 'Modifications bien enregistrées.');

      return $this->redirectToRoute('becowo_manager_profile');
    }

  	return $this->render('Manager/workspace_profile.html.twig', array(
  		'form' => $form->createView(),
  		'pictureLogo' => $pictureLogo,
  		'listOffices' => $listOffices));
  }

  public function descAction(Request $request)
  {
  	$workspace = $this->getUser()->getWorkspace();
  	$formBuilder = $this->get('form.factory')->createBuilder(FormType::class, $workspace);
  	$formBuilder
        ->add('name',   TextType::class)
    	->add('description',   TextareaType::class)
        ->add('descriptionBonus',   TextType::class)
        ->add('street',   TextType::class)
        ->add('postCode',   TextType::class)
        ->add('city',   TextType::class)
        ->add('longitude')
        ->add('latitude')
    ;
    $form = $formBuilder->getForm();

  	if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
      $em = $this->getDoctrine()->getManager();
      $em->persist($workspace);
      $em->flush();

      $request->getSession()->getFlashBag()->add('success', 'Modifications bien enregistrées.');

      return $this->redirectToRoute('becowo_manager_profile_desc');
    }

  	return $this->render('Manager/profile/desc.html.twig', array(
  		'form' => $form->createView()));
  }

  public function picturesAction()
  {
  	return $this->render('Manager/profile/picture.html.twig');
  }


}