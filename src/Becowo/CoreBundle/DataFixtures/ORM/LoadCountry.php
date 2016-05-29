<?php

namespace Becowo\CoreBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Becowo\CoreBundle\Entity\Country;

class LoadCountry implements FixtureInterface
{
  public function load(ObjectManager $manager)
  {
    $country = new Country();
    $country->setName('France');
    // On la persiste
    $manager->persist($country);

    

    // On flush tout ce qu'on vient de créer
    $manager->flush();
  }
}