<?php

namespace Becowo\CoreBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Becowo\CoreBundle\Entity\Poi;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;

class LoadPoi extends Controller implements FixtureInterface, OrderedFixtureInterface
{
  public function load(ObjectManager $manager)
  {
    ///////////////////////////// Creches

    $csv = fopen(dirname(__FILE__).'/paris - creches.csv', 'r');

    $i = 0;

    while (!feof($csv)) {
        $line = fgetcsv($csv, 300, ';');
        if(!empty($line)){
        $poi = new Poi();

        //country
        $repo = $this->getDoctrine()->getManager()->getRepository('BecowoCoreBundle:Country');
        $poi->setCountry($repo->findOneByName('France'));
        
        // POI Category
        $repo = $this->getDoctrine()->getManager()->getRepository('BecowoCoreBundle:PoiCategory');
        $poi->setPoiCategory($repo->findOneByName('Creche'));
        
        $poi->setName($line[0]);
        $poi->setLongitude($line[1]);
        $poi->setLatitude($line[2]);
        $poi->setStreet($line[3]);
        $poi->setpostCode($line[4]);
        $poi->setCity($line[5]);
        $poi->setMarkerSymbol('marker');

        $manager->persist($poi);

        $i = $i + 1;
        }
    }

    fclose($csv);
  $manager->flush();
  

  ///////////////////////////// Salle de muscu
    
    $csv = fopen(dirname(__FILE__).'/paris - salles muscu.csv', 'r');

    $i = 0;

    while (!feof($csv)) {
        $line = fgetcsv($csv, 300, ';');
        if(!empty($line)){
        $poi = new Poi();

        //country
        $repo = $this->getDoctrine()->getManager()->getRepository('BecowoCoreBundle:Country');
        $poi->setCountry($repo->findOneByName('France'));
        
        // POI Category
        $repo = $this->getDoctrine()->getManager()->getRepository('BecowoCoreBundle:PoiCategory');
        $poi->setPoiCategory($repo->findOneByName('Salle de musculation'));
        
        $poi->setName($line[0]);
        $poi->setLongitude($line[1]);
        $poi->setLatitude($line[2]);
        $poi->setStreet($line[3]);
        $poi->setpostCode($line[4]);
        $poi->setCity($line[5]);
        $poi->setMarkerSymbol('circle');

        $manager->persist($poi);

        $i = $i + 1;
        }
    };

    fclose($csv);
  $manager->flush();

  }

  public function getOrder()
    {
        return 1;
    }
}
