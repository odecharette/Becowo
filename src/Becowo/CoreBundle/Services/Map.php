<?php

namespace Becowo\CoreBundle\Services;

use Doctrine\ORM\EntityManager;

class Map
{
    private $em = null;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    public function getWsAndPoiInGeoJson(array $workspaces)
    {
        $data = $this->prepareGeoJson();
        $data = $this->addWorkspaces($workspaces, $data);
        $data = $this->addPoi($data);
        $data = $this->createGeoJson($data);

        return $data;
    }

    private function prepareGeoJson()
    {
        return array( 'type' => 'FeatureCollection', 'features' => array());
    }


    private function addWorkspaces(array $Workspaces, $geojson)
    {
        //$geojson = array( 'type' => 'FeatureCollection', 'features' => array());

        foreach ($Workspaces as $w) {
          $feature = array(
            'type' => 'Feature', 
            'geometry' => array(
                'type' => 'Point',
                'coordinates' => array($w->getLongitude(), $w->getLatitude())
            ),
            'properties' => array(
                'type' => 'workspace',
                'id' => $w->getId(),
                'name' => $w->getName(),
                'street' => $w->getStreet(),
                'city' => $w->getCity(),
                'marker-symbol' => 'water',
                'marker-color' => '#3bb2d0'
                )
            );
            array_push($geojson['features'], $feature);
        }

        return $geojson;
        
    }

    private function addPoi(array $geojson)
    {
        $repo = $this->em->getRepository('BecowoCoreBundle:Poi');  
        $poi = $repo->findPoiWithCategory();

        foreach ($poi as $poi) {

            $feature = array(
              'type' => 'Feature', 
              'geometry' => array(
                  'type' => 'Point',
                  'coordinates' => array($poi->getLongitude(), $poi->getLatitude())
              ),
              'properties' => array(
                  'type' => $poi->getPoiCategory()->getName(),
                  'id' => $poi->getId(),
                  'name' => str_replace("'"," ",$poi->getName()), // enleve les apostrophes,
                  'street' => str_replace("'"," ",$poi->getStreet()),
                  'city' => str_replace("'"," ",$poi->getCity()),
                  'marker-symbol' => $poi->getMarkerSymbol(),
                  'marker-color' => '#FA9EEE'
                  )
              );
            array_push($geojson['features'], $feature);
        }

        return $geojson;
    }

    private function createGeoJson(array $data)
    {
        return json_encode($data);
    }

    
}
