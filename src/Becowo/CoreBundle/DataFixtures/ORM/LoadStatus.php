<?php

namespace Becowo\CoreBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Becowo\CoreBundle\Entity\Status;

class LoadStatus implements FixtureInterface
{
  public function load(ObjectManager $manager)
  {
    $status = new Status();
    $status->setName('En cours');
    $manager->persist($status);

    $status = new Status();
    $status->setName('Confirmée');
    $manager->persist($status);

    $status = new Status();
    $status->setName('Terminée');
    $manager->persist($status);

    $status = new Status();
    $status->setName('Annulée');
    $manager->persist($status);

    // On flush tout ce qu'on vient de créer
    $manager->flush();
  }

}