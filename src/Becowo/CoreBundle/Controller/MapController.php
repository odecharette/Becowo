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
      $itemNode->addAttribute( 'name', utf8_encode($workspaces->getName()) );
      $itemNode->addAttribute( 'lat', $workspaces->getLatitude() );
      $itemNode->addAttribute( 'lng', $workspaces->getLongitude() );
      $itemNode->addAttribute( 'category', utf8_encode($workspaces->getCategory()) );
      $itemNode->addAttribute( 'address', utf8_encode(ucfirst(strtolower($workspaces->getStreet()))) );
      $itemNode->addAttribute( 'city', utf8_encode($workspaces->getCity()) );
      $itemNode->addAttribute( 'postal', $workspaces->getPostCode() );
      $itemNode->addAttribute( 'country', "FR" );
      $itemNode->addAttribute( 'listed', "true" ); // Pour que seuls les espaces soient affichés dans la liste
      $itemNode->addAttribute( 'featured', "true" );
      $itemNode->addAttribute( 'region', utf8_encode($workspaces->getRegion()) );

      $amenities = $workspaces->getAmenities();
      $listeAmenities = "";
      $i = 0;
      foreach ($amenities as $amenity) {
        $listeAmenities = $amenity->getName() . ", " . $listeAmenities ;
        $itemNode->addAttribute( 'featuresUrl' . $i, substr($amenity->getUrlLogo(), 0,-4));
        $i++;
      }
      $itemNode->addAttribute( 'features', $listeAmenities );
      
      
      $itemNode->addAttribute( 'description', $workspaces->getDescription() );
      $itemNode->addAttribute( 'descriptionBonus', $workspaces->getDescriptionBonus() );

      $UrlLogo = $WsService->getLogoUrlByWorkspace($workspaces->getName());
      $itemNode->addAttribute( 'logo', $UrlLogo["url"] );

      $pictureFavorite = $WsService->getFavoritePictureUrlByWorkspace($workspaces->getName());
      $itemNode->addAttribute( 'favoritePicture', $pictureFavorite["url"] );

      $averageVote = $WsService->getAverageVoteByWorkspace($workspaces);
      $averageVote = round($averageVote, 0);
      $itemNode->addAttribute( 'averageVote', $averageVote );

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


    // prepare XML
  // $xml = trim(preg_replace('~[\r\n]+~', '', $xml));
  $xml = $rootNode->asXML("js/StoreLocator/locations.xml");

    // Save XML into file

  // header('HTTP/1.1 200 OK');
  // header("Pragma: no-cache");
  // header('Cache-Control: no-cache, no-store, max-age=0, must-revalidate');
  // header('Content-type', 'text/xml');
  // header('Content-Disposition: attachment; filename="dirname(__DIR__)/web/js/StoreLocator/locations.xml"');
 
  // echo $xml;
// $xml = json_encode($xml);

dump($xml);
    return $this->render('Home/map.html.twig', array('xml_locations' => $xml));
  }
}
