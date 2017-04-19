<?php

namespace Becowo\ApiBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class GoogleCalendarController extends Controller
{
   
	public function viewAction(Request $request)
  	{
    	$googleCalendarService = $this->get('app.googleCalendar');
    	$events = null;
    	$session = $request->getSession();
    	$userCalendarID = "calendartestbecowo%40gmail.com";

    	$session_access_token = $session->get('googleAccessToken');
    	if($session_access_token != null and $googleCalendarService->checkAccessTokenIsValid($session_access_token))
    	{
    		$access_token = $session_access_token;
    	}else
    	{
	    	$jwt = $googleCalendarService->createJWT();
	    	$access_token = $googleCalendarService->createAccessToken($jwt);
    		$session->set('googleAccessToken', $access_token);
    	}
   

    	$googleCalendarService->createEventInCalendar($userCalendarID, $access_token);
    	$events = $googleCalendarService->getGoogleCalendarEvents($userCalendarID, $access_token);

    	return $this->render('Api/googleCalendar.html.twig', array('events' => $events));
	}
}
