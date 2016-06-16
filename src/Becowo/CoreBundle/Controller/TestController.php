<?php

namespace Becowo\CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;

class TestController extends Controller
{
  public function testAction()
  {
    $em = $this->getDoctrine()->getManager();

    // Tous les workspaces
    $repo = $em->getRepository('BecowoCoreBundle:Workspace');
    $workspaces = $repo->findActiveWorkspaces();

    $geojson = array( 'type' => 'FeatureCollection', 'features' => array());

    foreach ($workspaces as $w) {
      $feature = array(
        'id' => $w->getId(),
        'type' => 'Feature', 
        'geometry' => array(
            'type' => 'Point',
            # Pass Longitude and Latitude Columns here
            'coordinates' => array($w->getLongitude(), $w->getLatitude())
        ),
        # Pass other attribute columns here
        'properties' => array(
            'address' => $w->getStreet(),
            'city' => $w->getCity()
            )
        );
    # Add feature arrays to feature collection array
    array_push($geojson['features'], $feature);
    }

 $workspacesInJson = json_encode($geojson);
  	
  	return $this->render('Test/test.html.twig', array('workspacesInJson' => $workspacesInJson, 'geojson' => $geojson));
  }

}