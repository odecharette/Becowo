<?php

namespace Becowo\CoreBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Becowo\CoreBundle\Entity\Origin;

class LoadOrigin implements FixtureInterface
{
  public function load(ObjectManager $manager)
  {
    $origin = new Origin();
    $origin->setName('Manuel');
    // On la persiste
    $manager->persist($origin);

    

    // On flush tout ce qu'on vient de créer
    $manager->flush();
  }

}