<?php

namespace Becowo\CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class MapController extends Controller
{
  public function viewAction(Request $request)
  {
    $WsService = $this->get('app.workspace');
    $workspaces = $WsService->getActiveWorkspaces(); 

    $rootNode = new \SimpleXMLElement( "<?xml version='1.0' encoding='UTF-8'?><markers></markers>" );

    foreach ($workspaces as $workspaces) {
      $itemNode = $rootNode->addChild('marker');
      $itemNode->addAttribute( 'name', $workspaces->getName() );
      $itemNode->addAttribute( 'lat', $workspaces->getLatitude() );
      $itemNode->addAttribute( 'lng', $workspaces->getLongitude() );
      $itemNode->addAttribute( 'address', $workspaces->getStreet() );
      $itemNode->addAttribute( 'city', $workspaces->getCity() );
      $itemNode->addAttribute( 'postal', $workspaces->getPostCode() );
      $itemNode->addAttribute( 'country', "FR" );
    }


  $xml = $rootNode->asXML();

   $xml = trim(preg_replace('~[\r\n]+~', '', $xml));
   
// $xml = json_encode($xml);

dump($xml);
    return $this->render('Home/map.html.twig', array('xml_locations' => $xml));
  }
}
