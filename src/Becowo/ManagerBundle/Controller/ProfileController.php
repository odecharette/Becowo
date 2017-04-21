<?php

namespace Becowo\ManagerBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Becowo\CoreBundle\Entity\Workspace;
use Becowo\CoreBundle\Entity\WorkspaceHasOffice;
use Becowo\CoreBundle\Entity\Event;
use Becowo\CoreBundle\Entity\TeamMember;
use Becowo\CoreBundle\Entity\WorkspaceHasAmenities;
use Becowo\CoreBundle\Entity\WorkspaceHasTeamMember;
use Becowo\CoreBundle\Entity\Price;
use Becowo\CoreBundle\Entity\WorkspaceIsClosed;
use Becowo\CoreBundle\Form\Type\WorkspaceType;
use Becowo\CoreBundle\Form\Type\PictureType;
use Becowo\CoreBundle\Form\Type\WorkspaceHasOfficeType;
use Becowo\CoreBundle\Form\Type\EventType;
use Becowo\CoreBundle\Form\Type\WorkspaceHasAmenitiesType;
use Becowo\CoreBundle\Form\Type\WorkspaceHasTeamMemberType;
use Becowo\CoreBundle\Form\Type\TeamMemberType;
use Becowo\CoreBundle\Form\Type\PriceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class ProfileController extends Controller
{
  public function viewAction(Request $request)
  {
  }

  public function identiteAction(Request $request, $id)
  {
    $WsService = $this->get('app.workspace');
    $workspace = $WsService->getWorkspaceById($id);
  	$formBuilder = $this->get('form.factory')->createBuilder(FormType::class, $workspace);
  	$formBuilder
        ->add('name',   TextType::class)
    	  // ->add('description',   TextareaType::class)
       //  ->add('descriptionBonus',   TextType::class)
        ->add('street',   TextType::class)
        ->add('postCode',   TextType::class)
        ->add('city',   TextType::class)
        ->add('region',   EntityType::class, array(
              'class' => 'BecowoCoreBundle:Region',
              'choice_label' => 'name',))
        ->add('country',   EntityType::class, array(
              'class' => 'BecowoCoreBundle:Country',
              'placeholder' => 'Choisir un pays',
              'empty_data'  => null,
              'choice_label' => 'name',))
        ->add('longitude')
        ->add('latitude')
        ->add('website',   TextType::class, array('required' => false))
        ->add('facebookLink',   TextType::class, array('required' => false))
        ->add('twitterLink',   TextType::class, array('required' => false))
        ->add('instagramLink',   TextType::class, array('required' => false))
        ->add('amenitiesDesc',   TextareaType::class, array('required' => false, 'label' => false))
        ->add('firstBookingFree',   CheckboxType::class, array('required' => false, 'label' => 'Réservation gratuite autorisée'))
        ->add('firstBookingFreeDesc',   TextareaType::class, array('required' => false, 'label' => 'Description de l\'offre gratuite (lieu, durée, etc)'))
        ->add('arrivalDesc',   TextareaType::class, array('required' => false, 'label' => false))
    ;
    $form = $formBuilder->getForm();

  	if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
      $em = $this->getDoctrine()->getManager();
      $em->persist($workspace);
      $em->flush();

      $request->getSession()->getFlashBag()->add('success', 'Modifications bien enregistrées.');

      return $this->redirectToRoute('becowo_manager_profile_identite', array('id' => $id));
    }

  	return $this->render('Manager/profile/identite.html.twig', array(
  		'form' => $form->createView(), 'workspace' => $workspace));
  }

  public function logoAction(Request $request, $id)
  {
  	$WsService = $this->get('app.workspace');
    $workspace = $WsService->getWorkspaceById($id);
  	$logo = $WsService->getLogoByWorkspace($workspace->getName());
    $logo = $logo[0];
  
  	$form = $this->get('form.factory')->create(PictureType::class, $logo);

    
  	if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
      $logo->upload($workspace->getName());

      $em = $this->getDoctrine()->getManager();
      $em->persist($logo);
      $em->flush();

      $request->getSession()->getFlashBag()->add('success', 'Modifications bien enregistrées.');

      return $this->redirectToRoute('becowo_manager_profile_logo', array('id' => $id));
    }
  	return $this->render('Manager/profile/logo.html.twig', array(
  		'form' => $form->createView(),
  		'logo' => $logo, 
      'workspace' => $workspace));
  }

  public function picturesAction(Request $request, $id)
  {
    $WsService = $this->get('app.workspace');
    $workspace = $WsService->getWorkspaceById($id);
    $pics = $WsService->getPicturesByWorkspace($workspace->getName());
  
    $form = $this->get('form.factory')->create(PictureType::class, $pics[0]);
    
    if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
      $pics[0]->upload($workspace->getName());

      $em = $this->getDoctrine()->getManager();
      $em->persist($pics[0]);
      $em->flush();

      $request->getSession()->getFlashBag()->add('success', 'Modifications bien enregistrées.');

      return $this->redirectToRoute('becowo_manager_profile_pictures', array('id' => $id));
    }
    return $this->render('Manager/profile/pictures.html.twig', array(
      'form' => $form->createView(),
      'pics' => $pics, 
      'workspace' => $workspace));
  }

  public function amenitiesAction(Request $request, $id)
  {
  	$WsService = $this->get('app.workspace');
    $workspace = $WsService->getWorkspaceById($id);
    $WsHasAmenities = $WsService->getAmenitiesByWorkspace($workspace);

    $WsHasAmenity = new WorkspaceHasAmenities();
    $WsHasAmenity->setWorkspace($workspace);
    $form = $this->get('form.factory')->create(WorkspaceHasAmenitiesType::class, $WsHasAmenity);

  	if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
      $em = $this->getDoctrine()->getManager();
      $em->persist($WsHasAmenity);
      $em->flush();

      $request->getSession()->getFlashBag()->add('success', 'Modifications bien enregistrées.');

      return $this->redirectToRoute('becowo_manager_profile_amenities', array('id' => $id));
    }

  	return $this->render('Manager/profile/amenities.html.twig', array(
  		'form' => $form->createView(),
      'WsHasAmenities' => $WsHasAmenities, 
      'workspace' => $workspace));
  }

	public function officesAction(Request $request, $id)
	{
		$WsService = $this->get('app.workspace');
    $workspace = $WsService->getWorkspaceById($id);
		$offices = $WsService->getOfficesByWorkspace($workspace);

		$office = new WorkspaceHasOffice();
		$office->setWorkspace($workspace);
		$form = $this->get('form.factory')->create(WorkspaceHasOfficeType::class, $office);

		if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {

      $file = $office->getFile();
      $filename =  $file->getClientOriginalName();
      $dir = $this->container->getParameter('kernel.root_dir') . '/../web/images/Workspaces/' .$workspace->getName() . '/';
      $file->move($dir, $filename);
      $office->setUrlProfilePicture($filename);

      $em = $this->getDoctrine()->getManager();
      $em->persist($office);
      $em->flush();

      $request->getSession()->getFlashBag()->add('success', 'Modifications bien enregistrées.');

      return $this->redirectToRoute('becowo_manager_profile_offices', array('id' => $id));
    }

		return $this->render('Manager/profile/offices.html.twig', array(
		'form' => $form->createView(),
		'offices' => $offices, 
    'workspace' => $workspace));

	}

  public function pricesAction(Request $request, $id)
  {
    $WsService = $this->get('app.workspace');
    $workspace = $WsService->getWorkspaceById($id);
    $prices = $WsService->getPricesByWorkspace($workspace);

    $price = new Price();
    $form = $this->get('form.factory')->create(PriceType::class, $price, array('idWs' => $workspace->getId()));

    if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
      $em = $this->getDoctrine()->getManager();
      $em->persist($price);
      $em->flush();

      $request->getSession()->getFlashBag()->add('success', 'Modifications bien enregistrées.');

      return $this->redirectToRoute('becowo_manager_profile_prices', array('id' => $id));
    }

    return $this->render('Manager/profile/prices.html.twig', array(
    'form' => $form->createView(),
    'prices' => $prices, 
    'workspace' => $workspace));

  }

	public function eventsAction(Request $request, $id)
	{
		$WsService = $this->get('app.workspace');
    $workspace = $WsService->getWorkspaceById($id);
		$events = $WsService->getEventsByWorkspace($workspace);

		$event = new Event();
		$event->setWorkspace($workspace);
		$form = $this->get('form.factory')->create(EventType::class, $event);

		if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
      $em = $this->getDoctrine()->getManager();
      $em->persist($event);
      $em->flush();

      $request->getSession()->getFlashBag()->add('success', 'Modifications bien enregistrées.');

      return $this->redirectToRoute('becowo_manager_profile_events', array('id' => $id));
    }

    return $this->render('Manager/profile/events.html.twig', array(
		'form' => $form->createView(),
		'events' => $events, 
    'workspace' => $workspace));
	}

	public function teamAction(Request $request, $id)
	{
    $WsService = $this->get('app.workspace');
    $workspace = $WsService->getWorkspaceById($id);
    $WsHasMembers = $WsService->getWsHasTeamMemberByWorkspace($workspace);


		$teamMember = new TeamMember();
    $WhTm = new WorkspaceHasTeamMember();
    $WhTm->setWorkspace($workspace);
    $WhTm->setTeamMember($teamMember);

		$form = $this->get('form.factory')->create(WorkspaceHasTeamMemberType::class, $WhTm);

		if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {

      $file = $teamMember->getFile();
      $filename =  $file->getClientOriginalName();
      $dir = $this->container->getParameter('kernel.root_dir') . '/../web/images/Workspaces/' . $workspace->getName() . '/';
      $file->move($dir, $filename);
      $teamMember->setUrlProfilePicture($filename);

      $em = $this->getDoctrine()->getManager();
      $em->persist($teamMember);
      $em->persist($WhTm);
      $em->flush();

      $request->getSession()->getFlashBag()->add('success', 'Modifications bien enregistrées.');

      return $this->redirectToRoute('becowo_manager_profile_team', array('id' => $id));
    }

    return $this->render('Manager/profile/team.html.twig', array(
		'form' => $form->createView(),
    'WsHasMembers' => $WsHasMembers, 
    'workspace' => $workspace));
	}

  public function calendarAction(Request $request, $id)
  {
    $WsService = $this->get('app.workspace');
    $workspace = $WsService->getWorkspaceById($id);

    ////// Horaire
    $formBuilder = $this->get('form.factory')->createNamedBuilder('formHours', FormType::class, $workspace);
    $formBuilder
      ->add('openHoursInfo',   TextareaType::class, array('required' => false))
      ->add('isAlwaysOpen',   CheckboxType::class, array('label' => 'Ouvert 24/7', 'required' => false))
      ;
    $form = $formBuilder->getForm();

    ///// Calendrier
    $closedDates = $WsService->getClosedDatesByWorkspace($workspace);

    $newClosedDate = new WorkspaceIsClosed();
    $newClosedDate->setWorkspace($workspace);
    $formBuilderCalendar = $this->get('form.factory')->createNamedBuilder('formCalendar', FormType::class, $newClosedDate);
    $formBuilderCalendar
      ->add('closedDate', DateType::class, array(
        'widget' => 'choice',
        'years' => range(date('Y'), date('Y')+4)));
    $formCalendar = $formBuilderCalendar->getForm();



    ///// Timetable

    $timetable = $WsService->getTimesByWorkspace($workspace);
    
    $formBuilderTime = $this->get('form.factory')->createNamedBuilder('formTimetable', FormType::class, $timetable[0]);
    $formBuilderTime
      ->add('openHour',   TimeType::class, array(
          'label' => 'Horaire d\'ouverture',
          'input'  => 'datetime',
          'widget' => 'choice'))
      ->add('closeHour',   TimeType::class, array(
          'label' => 'Horaire de fermeture',
          'input'  => 'datetime',
          'widget' => 'choice'))
      ->add('isOpenSaturday',   CheckboxType::class, array('label' => 'Ouvert le Samedi', 'required' => false))
      ->add('isOpenSunday',   CheckboxType::class, array('label' => 'Ouvert le Dimanche','required' => false))
      ;
    $formTime = $formBuilderTime->getForm();

    //Horaire
    if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
      $em = $this->getDoctrine()->getManager();
      $em->persist($workspace);
      $em->flush();

      $request->getSession()->getFlashBag()->add('success', 'Modifications bien enregistrées.');

      return $this->redirectToRoute('becowo_manager_profile_calendar', array('id' => $id));
    }

    //Calendar
    if ($request->isMethod('POST') && $formCalendar->handleRequest($request)->isValid()) {
      $em = $this->getDoctrine()->getManager();
      $em->persist($newClosedDate);
      $em->flush();

      $request->getSession()->getFlashBag()->add('success', 'Modifications bien enregistrées.');

      return $this->redirectToRoute('becowo_manager_profile_calendar', array('id' => $id));
    }

    // Timetable
    if ($request->isMethod('POST') && $formTime->handleRequest($request)->isValid()) {
      $em = $this->getDoctrine()->getManager();
      $em->persist($timetable[0]);
      $em->flush();

      $request->getSession()->getFlashBag()->add('success', 'Modifications bien enregistrées.');

      return $this->redirectToRoute('becowo_manager_profile_calendar', array('id' => $id));
    }

    return $this->render('Manager/profile/calendar.html.twig', array(
      'form' => $form->createView(),
      'formTime' => $formTime->createView(), 
      'workspace' => $workspace,
      'timetable' => $timetable[0],
      'closedDates' => $closedDates,
      'formCalendar' => $formCalendar->createView()));

  }


}
