<?php

namespace Becowo\ManagerBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Becowo\CoreBundle\Entity\Workspace;
use Becowo\CoreBundle\Entity\WorkspaceHasOffice;
use Becowo\CoreBundle\Entity\Event;
use Becowo\CoreBundle\Entity\TeamMember;
use Becowo\CoreBundle\Form\Type\WorkspaceType;
use Becowo\CoreBundle\Form\Type\PictureType;
use Becowo\CoreBundle\Form\Type\WorkspaceHasOfficeType;
use Becowo\CoreBundle\Form\Type\EventType;
use Becowo\CoreBundle\Form\Type\TeamMemberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

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

  public function identiteAction(Request $request)
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

      return $this->redirectToRoute('becowo_manager_profile_identite');
    }

  	return $this->render('Manager/profile/identite.html.twig', array(
  		'form' => $form->createView()));
  }

  public function logoAction(Request $request)
  {
  	$WsService = $this->get('app.workspace');
  	$logo = $WsService->getLogoByWorkspace($this->getUser()->getWorkspace()->getName());
    $logo = $logo[0];
  
  	$form = $this->get('form.factory')->create(PictureType::class, $logo);

    
  	if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
      $logo->upload($this->getUser()->getWorkspace()->getName());

      $em = $this->getDoctrine()->getManager();
      $em->persist($logo);
      $em->flush();

      $request->getSession()->getFlashBag()->add('success', 'Modifications bien enregistrées.');

      return $this->redirectToRoute('becowo_manager_profile_logo');
    }
  	return $this->render('Manager/profile/logo.html.twig', array(
  		'form' => $form->createView(),
  		'logo' => $logo));
  }

  public function picturesAction(Request $request)
  {
    $WsService = $this->get('app.workspace');
    $pics = $WsService->getPicturesByWorkspace($this->getUser()->getWorkspace()->getName());
    //$pics = $pics[0];
  
    $form = $this->get('form.factory')->create(PictureType::class, $pics[0]);

    
    if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
      $pics[0]->upload($this->getUser()->getWorkspace()->getName());

      $em = $this->getDoctrine()->getManager();
      $em->persist($pics[0]);
      $em->flush();

      $request->getSession()->getFlashBag()->add('success', 'Modifications bien enregistrées.');

      return $this->redirectToRoute('becowo_manager_profile_pictures');
    }
    return $this->render('Manager/profile/pictures.html.twig', array(
      'form' => $form->createView(),
      'pics' => $pics));
  }

  public function amenitiesAction(Request $request)
  {
  	$workspace = $this->getUser()->getWorkspace();
  	$formBuilder = $this->get('form.factory')->createBuilder(FormType::class, $workspace);
  	$formBuilder
        ->add('amenities', EntityType::class, array(
            'class' => 'BecowoCoreBundle:Amenities',
            'multiple' => true,
            'expanded' => true));
    $form = $formBuilder->getForm();

  	if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
      $em = $this->getDoctrine()->getManager();
      $em->persist($workspace);
      $em->flush();

      $request->getSession()->getFlashBag()->add('success', 'Modifications bien enregistrées.');

      return $this->redirectToRoute('becowo_manager_profile_amenities');
    }

  	return $this->render('Manager/profile/amenities.html.twig', array(
  		'form' => $form->createView()));
  }

  	public function officesAction(Request $request)
  	{
  		$WsService = $this->get('app.workspace');
  		$offices = $WsService->getOfficesByWorkspace($this->getUser()->getWorkspace());

  		$office = new WorkspaceHasOffice();
  		$office->setWorkspace($this->getUser()->getWorkspace());
  		$form = $this->get('form.factory')->create(WorkspaceHasOfficeType::class, $office);

  		if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
	      $em = $this->getDoctrine()->getManager();
	      $em->persist($office);
	      $em->flush();

	      $request->getSession()->getFlashBag()->add('success', 'Modifications bien enregistrées.');

	      return $this->redirectToRoute('becowo_manager_profile_offices');
	    }

  		return $this->render('Manager/profile/offices.html.twig', array(
  		'form' => $form->createView(),
  		'offices' => $offices));

  	}

  	public function eventsAction(Request $request)
  	{
  		$WsService = $this->get('app.workspace');
  		$events = $WsService->getEventsByWorkspace($this->getUser()->getWorkspace());

  		$event = new Event();
  		$event->setWorkspace($this->getUser()->getWorkspace());
  		$form = $this->get('form.factory')->create(EventType::class, $event);

  		if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
	      $em = $this->getDoctrine()->getManager();
	      $em->persist($event);
	      $em->flush();

	      $request->getSession()->getFlashBag()->add('success', 'Modifications bien enregistrées.');

	      return $this->redirectToRoute('becowo_manager_profile_events');
	    }

	    return $this->render('Manager/profile/events.html.twig', array(
  		'form' => $form->createView(),
  		'events' => $events));
  	}

  	public function teamAction(Request $request)
  	{
  		$teamMember = new TeamMember();
  		$teamMember->addWorkspace($this->getUser()->getWorkspace());
  		$form = $this->get('form.factory')->create(TeamMemberType::class, $teamMember);

  		if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {

        $teamMember->upload($this->getUser()->getWorkspace()->getName());

	      $em = $this->getDoctrine()->getManager();
	      $em->persist($teamMember);
	      $this->getUser()->getWorkspace()->addTeamMember($teamMember);	// pour la relation Many-to-many
	      $em->flush();

	      $request->getSession()->getFlashBag()->add('success', 'Modifications bien enregistrées.');

	      return $this->redirectToRoute('becowo_manager_profile_team');
	    }

	    return $this->render('Manager/profile/team.html.twig', array(
  		'form' => $form->createView()));
  	}


}
