<?php

namespace Becowo\ManagerBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Becowo\CoreBundle\Entity\Workspace;
use Becowo\CoreBundle\Entity\WorkspaceHasOffice;
use Becowo\CoreBundle\Entity\Event;
use Becowo\CoreBundle\Entity\TeamMember;
use Becowo\CoreBundle\Entity\WorkspaceHasAmenities;
use Becowo\CoreBundle\Entity\Price;
use Becowo\CoreBundle\Form\Type\WorkspaceType;
use Becowo\CoreBundle\Form\Type\PictureType;
use Becowo\CoreBundle\Form\Type\WorkspaceHasOfficeType;
use Becowo\CoreBundle\Form\Type\EventType;
use Becowo\CoreBundle\Form\Type\WorkspaceHasAmenitiesType;
use Becowo\CoreBundle\Form\Type\TeamMemberType;
use Becowo\CoreBundle\Form\Type\PriceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class ProfileController extends Controller
{
  public function viewAction(Request $request)
  {
  }

  public function identiteAction(Request $request)
  {
  	$workspace = $this->getUser()->getWorkspace();
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
              'choice_label' => 'name',))
        ->add('longitude')
        ->add('latitude')
        ->add('website',   TextType::class)
        ->add('facebookLink',   TextType::class)
        ->add('twitterLink',   TextType::class)
        ->add('instagramLink',   TextType::class)
        ->add('amenitiesDesc',   TextareaType::class)
        ->add('arrivalDesc',   TextareaType::class)
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
  	$WsService = $this->get('app.workspace');
    $WsHasAmenities = $WsService->getAmenitiesByWorkspace($this->getUser()->getWorkspace());

    $WsHasAmenity = new WorkspaceHasAmenities();
    $WsHasAmenity->setWorkspace($this->getUser()->getWorkspace());
    $form = $this->get('form.factory')->create(WorkspaceHasAmenitiesType::class, $WsHasAmenity);

  	if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
      $em = $this->getDoctrine()->getManager();
      $em->persist($WsHasAmenity);
      $em->flush();

      $request->getSession()->getFlashBag()->add('success', 'Modifications bien enregistrées.');

      return $this->redirectToRoute('becowo_manager_profile_amenities');
    }

  	return $this->render('Manager/profile/amenities.html.twig', array(
  		'form' => $form->createView(),
      'WsHasAmenities' => $WsHasAmenities));
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

  public function pricesAction(Request $request)
  {
    $WsService = $this->get('app.workspace');
    $prices = $WsService->getPricesByWorkspace($this->getUser()->getWorkspace());

    $price = new Price();
    $form = $this->get('form.factory')->create(PriceType::class, $price, array('idWs' => $this->getUser()->getWorkspace()->getId()));

    if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
      $em = $this->getDoctrine()->getManager();
      $em->persist($price);
      $em->flush();

      $request->getSession()->getFlashBag()->add('success', 'Modifications bien enregistrées.');

      return $this->redirectToRoute('becowo_manager_profile_prices');
    }

    return $this->render('Manager/profile/prices.html.twig', array(
    'form' => $form->createView(),
    'prices' => $prices));

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

    public function calendarAction(Request $request)
    {
      $workspace = $this->getUser()->getWorkspace();
      $formBuilder = $this->get('form.factory')->createBuilder(FormType::class, $workspace);
      $formBuilder
        ->add('openHoursInfo',   TextareaType::class)
        ->add('isAlwaysOpen',   CheckboxType::class, array('label' => 'Ouvert 24/7'))
        ;
      $form = $formBuilder->getForm();

      $WsService = $this->get('app.workspace');
      $timetable = $WsService->getTimesByWorkspace($workspace);
      $formBuilderTime = $this->get('form.factory')->createBuilder(FormType::class, $timetable);
      $formBuilderTime
        ->add('openHour',   TimeType::class, array(
            'label' => 'Horaire d\'ouverture',
            'input'  => 'datetime',
            'widget' => 'choice',
        ))
        ->add('closeHour',   TimeType::class, array(
            'label' => 'Horaire de fermeture',
            'input'  => 'datetime',
            'widget' => 'choice',
        ))
        ->add('isOpenSaturday',   CheckboxType::class, array('label' => 'Ouvert le Samedi'))
        ->add('isOpenSunday',   CheckboxType::class, array('label' => 'Ouvert le Dimanche'))
        ;
      $formTime = $formBuilderTime->getForm();

      if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
        $em = $this->getDoctrine()->getManager();
        $em->persist($workspace);
        $em->flush();

        $request->getSession()->getFlashBag()->add('success', 'Modifications bien enregistrées.');

        return $this->redirectToRoute('becowo_manager_profile_calendar');
      }

      if ($request->isMethod('POST') && $formTime->handleRequest($request)->isValid()) {
        $em = $this->getDoctrine()->getManager();
        $em->persist($timetable);
        $em->flush();

        $request->getSession()->getFlashBag()->add('success', 'Modifications bien enregistrées.');

        return $this->redirectToRoute('becowo_manager_profile_calendar');
      }

      return $this->render('Manager/profile/calendar.html.twig', array(
        'form' => $form->createView(),
        'formTime' => $formTime->createView()));

    }


}
