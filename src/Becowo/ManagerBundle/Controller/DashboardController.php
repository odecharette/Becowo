<?php

namespace Becowo\ManagerBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;


class DashboardController extends Controller
{
  public function viewAction()
  {
  	$WsService = $this->get('app.workspace');

  	$NbBookings = count($WsService->getReservationsByWorkspace($this->getUser()->getWorkspace()));
  	$TotInclTax = $WsService->getTotalInclTaxReservationsByWorkspace($this->getUser()->getWorkspace());

  	$DashboardService = $this->get('app.manager.dashboard');

  	$ageChart = $DashboardService->getAgeChart();
  	$sexChart = $DashboardService->getSexChart();
  	$bookingByOfficeChart = $DashboardService->getBookingByOfficeChart();
  	$bookingByDurationChart = $DashboardService->getBookingByDurationChart();

  	return $this->render('Manager/dashboard.html.twig', array(
  		'NbBookings' => $NbBookings,
  		'TotInclTax' => $TotInclTax,
  		'ageChart' => $ageChart,
  		'sexChart' => $sexChart,
  		'bookingByOfficeChart' => $bookingByOfficeChart,
  		'bookingByDurationChart' => $bookingByDurationChart));
  }


}
