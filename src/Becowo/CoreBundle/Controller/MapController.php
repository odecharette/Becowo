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


    // Add Workspaces
    foreach ($workspaces as $workspaces) {
      $itemNode = $rootNode->addChild('marker');
      $itemNode->addAttribute( 'name', $workspaces->getName() );
      $itemNode->addAttribute( 'lat', $workspaces->getLatitude() );
      $itemNode->addAttribute( 'lng', $workspaces->getLongitude() );
      $itemNode->addAttribute( 'category', "coworking" ); // TO DO : getCategory ?
      $itemNode->addAttribute( 'address', $workspaces->getStreet() );
      $itemNode->addAttribute( 'city', $workspaces->getCity() );
      $itemNode->addAttribute( 'postal', $workspaces->getPostCode() );
      $itemNode->addAttribute( 'country', "FR" );
      $itemNode->addAttribute( 'listed', "true" ); // Pour que seuls les espaces soient affichés dans la liste
      $itemNode->addAttribute( 'featured', "true" );

      $amenities = $workspaces->getAmenities();

      $listeAmenities = "";
      foreach ($amenities as $amenity) {
        $listeAmenities = $amenity->getName() . ", " . $listeAmenities ;
      }
      $itemNode->addAttribute( 'features', $listeAmenities );
      
      $itemNode->addAttribute( 'description', $workspaces->getDescription() );

      $UrlLogo = $WsService->getLogoUrlByWorkspace($workspaces->getName());
      $itemNode->addAttribute( 'logo', $UrlLogo["url"] );

      $pictureFavorite = $WsService->getFavoritePictureUrlByWorkspace($workspaces->getName());
      $itemNode->addAttribute( 'favoritePicture', $pictureFavorite["url"] );
    }


    // Add POI
    $poi = $this->getDoctrine()->getManager()->getRepository('BecowoCoreBundle:Poi')->findPoiWithCategory();

    foreach ($poi as $poi) {
      $itemNode = $rootNode->addChild('marker');
      $itemNode->addAttribute( 'name', str_replace("'"," ",$poi->getName()) );
      $itemNode->addAttribute( 'lat', $poi->getLatitude() );
      $itemNode->addAttribute( 'lng', $poi->getLongitude() );
      $itemNode->addAttribute( 'category', $poi->getPoiCategory()->getName() );
      $itemNode->addAttribute( 'address', $poi->getStreet() );
      $itemNode->addAttribute( 'city', $poi->getCity() );
      $itemNode->addAttribute( 'postal', $poi->getPostCode() );
      $itemNode->addAttribute( 'country', "FR" );
      $itemNode->addAttribute( 'featured', "true" );
      $itemNode->addAttribute( 'features', "" );
    }


  $xml = $rootNode->asXML();

   $xml = trim(preg_replace('~[\r\n]+~', '', $xml));
   
// $xml = json_encode($xml);

dump($xml);
    return $this->render('Home/map.html.twig', array('xml_locations' => $xml));
  }
}
