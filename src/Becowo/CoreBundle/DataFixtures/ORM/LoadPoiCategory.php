<?php

namespace Becowo\CoreBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Becowo\CoreBundle\Entity\PoiCategory;

class LoadPoiCategory implements FixtureInterface
{
  public function load(ObjectManager $manager)
  {
    $category = new PoiCategory();
    $category->setName('Creche');
    $manager->persist($category);

    $category = new PoiCategory();
    $category->setName('Salle de musculation');
    $manager->persist($category);

    // On flush tout ce qu'on vient de créer
    $manager->flush();
  }

}