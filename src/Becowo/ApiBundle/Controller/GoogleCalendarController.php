<?php

namespace Becowo\ApiBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class GoogleCalendarController extends Controller
{
   
	public function viewAction(Request $request)
  	{
    	$googleCalendarService = $this->get('app.googleCalendar');

    	$userCalendarID = "calendartestbecowo%40gmail.com";

    	$jwt = $googleCalendarService->createJWT();
    	$access_token = $googleCalendarService->createAccessToken($jwt);
    	
    	$googleCalendarService->createEventInCalendar($userCalendarID, $access_token);
    	$events = $googleCalendarService->getGoogleCalendarEvents($userCalendarID, $access_token);


    	return $this->render('Api/googleCalendar.html.twig', array('events' => $events));
	}
}
