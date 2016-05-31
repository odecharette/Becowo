<?php

namespace Becowo\CoreBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Becowo\CoreBundle\Entity\Amenities;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;

class LoadAmenities implements FixtureInterface, OrderedFixtureInterface
{
  public function load(ObjectManager $manager)
  {
    $amenities = new Amenities();
    $amenities->setName('Wifi');
    $manager->persist($amenities);

    $amenities = new Amenities();
    $amenities->setName('Imprimante');
    $manager->persist($amenities);

    $amenities = new Amenities();
    $amenities->setName('Thé, Café');
    $manager->persist($amenities);

    $amenities = new Amenities();
    $amenities->setName('Casier sécurisé');
    $manager->persist($amenities);

    $amenities = new Amenities();
    $amenities->setName('Espace cuisine');
    $manager->persist($amenities);
    

    // On flush tout ce qu'on vient de créer
    $manager->flush();
  }

  public function getOrder()
    {
        return 2;
    }
}