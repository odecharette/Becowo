<?php

namespace Becowo\CoreBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Becowo\CoreBundle\Entity\DistanceSearch;

class LoadDistanceSearch implements FixtureInterface
{
  public function load(ObjectManager $manager)
  {
    $ds = new DistanceSearch();
    $ds->setDistance(5);
    $ds->setUnit('Km');
    // On la persiste
    $manager->persist($ds);

    $ds = new DistanceSearch();
    $ds->setDistance(10);
    $ds->setUnit('Km');
    // On la persiste
    $manager->persist($ds);

    $ds = new DistanceSearch();
    $ds->setDistance(20);
    $ds->setUnit('Km');
    // On la persiste
    $manager->persist($ds);

    $ds = new DistanceSearch();
    $ds->setDistance(50);
    $ds->setUnit('Km');
    // On la persiste
    $manager->persist($ds);

    // On flush tout ce qu'on vient de créer
    $manager->flush();
  }


}