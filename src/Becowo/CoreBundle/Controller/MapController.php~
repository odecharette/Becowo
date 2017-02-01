<?php

namespace Becowo\CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class MapController extends Controller
{
  public function viewAction(Request $request)
  {
    $WsService = $this->get('app.workspace');
    $WswithVote = $WsService->getActiveWorkspacesOrderByVoteAvg(); 
    $AllActiveWs = $WsService->getActiveWorkspaces();

    // En queryBuilder impossible de faire une requet en Union donc on récup 
    // 1/ Tous les WS qui ont un vote, trié sur socreAVg en Desc
    // 2/ Tous les WS
    // 3/ On merge les 2 résultats
    // 4/ On enlève les doublons
    $workspaces = array_merge($WswithVote, $AllActiveWs);
    $workspaces = array_unique($workspaces);

    $rootNode = new \SimpleXMLElement( "<?xml version='1.0' encoding='UTF-8'?><markers></markers>" );

    // Add Workspaces
    foreach ($workspaces as $workspaces) {
      $itemNode = $rootNode->addChild('marker');
      $itemNode->addAttribute( 'id', $workspaces->getId() );
      $itemNode->addAttribute( 'name', $workspaces->getName() );
      $itemNode->addAttribute( 'lat', $workspaces->getLatitude() );
      $itemNode->addAttribute( 'lng', $workspaces->getLongitude() );
      $itemNode->addAttribute( 'category', utf8_encode($workspaces->getCategory()) );
      $itemNode->addAttribute( 'address', ucfirst($workspaces->getStreet()));
      $itemNode->addAttribute( 'city', ucfirst($workspaces->getCity()) );
      $itemNode->addAttribute( 'postal', $workspaces->getPostCode() );
      $itemNode->addAttribute( 'country', "FR" );
      $itemNode->addAttribute( 'listed', "true" ); // Pour que seuls les espaces soient affichés dans la liste
      $itemNode->addAttribute( 'featured', "true" );
      $itemNode->addAttribute( 'region', utf8_encode($workspaces->getRegion()) );
      $itemNode->addAttribute( 'lowestPrice', $WsService->getLowestPriceByWorkspace($workspaces) );

      $amenities = $WsService->getAmenitiesByWorkspace($workspaces);
      $listeAmenities = "";
      $i = 0;
      foreach ($amenities as $amenity) {
        $listeAmenities = $amenity->getAmenities()->getName() . ", " . $listeAmenities ;
        $itemNode->addAttribute( 'featuresUrl' . $i, substr($amenity->getAmenities()->getUrlLogo(), 0,-4));
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
      $averageVote == 0 ? $averageVote = "" : "";
      $itemNode->addAttribute( 'averageVote', $averageVote );

      $WsHasoffers = $WsService->getOffersByWorkspace($workspaces);
      $i = 0;
      foreach ($WsHasoffers as $WsHasoffer) {
        if($WsHasoffer->getOffer()->getName() == 'Zen')
        {
          $itemNode->addAttribute( 'offerZen', "true" );
        }else if($WsHasoffer->getOffer()->getName() == 'Link')
        {
          $itemNode->addAttribute( 'offerLink', "true" );
        }
        $i++;
      }
      
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

    return $this->render('Home/map.html.twig', array('xml_locations' => $xml));
  }
}
