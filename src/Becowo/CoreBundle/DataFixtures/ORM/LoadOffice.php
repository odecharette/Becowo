<?php

namespace Becowo\CoreBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Becowo\CoreBundle\Entity\Office;

class LoadOffice implements FixtureInterface
{
  public function load(ObjectManager $manager)
  {
    $office = new Office();
    $office->setName('Open space');
    $office->setIsPublic(true);
    $office->setDescription('');
    // On la persiste
    $manager->persist($office);

    $office = new Office();
    $office->setName('Bureau');
    $office->setIsPublic(false);
    $office->setDescription('');
    // On la persiste
    $manager->persist($office);

    $office = new Office();
    $office->setName('Salle de réunion');
    $office->setIsPublic(false);
    $office->setDescription('');
    // On la persiste
    $manager->persist($office);

    $office = new Office();
    $office->setName('Salle de conférence');
    $office->setIsPublic(false);
    $office->setDescription('');
    // On la persiste
    $manager->persist($office);

    $office = new Office();
    $office->setName('Canapé');
    $office->setIsPublic(true);
    $office->setDescription('');
    // On la persiste
    $manager->persist($office);


    $office = new Office();
    $office->setName('Hamac');
    $office->setIsPublic(true);
    $office->setDescription('');
    // On la persiste
    $manager->persist($office);

    // On flush tout ce qu'on vient de créer
    $manager->flush();
  }
}