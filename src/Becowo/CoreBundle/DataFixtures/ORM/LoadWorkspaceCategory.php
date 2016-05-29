<?php

namespace Becowo\CoreBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Becowo\CoreBundle\Entity\WorkspaceCategory;

class LoadWorkspaceCategory implements FixtureInterface
{
  public function load(ObjectManager $manager)
  {
    $category = new WorkspaceCategory();
    $category->setName('Coworking');
    // On la persiste
    $manager->persist($category);

    $category = new WorkspaceCategory();
    $category->setName('Coffice');
    // On la persiste
    $manager->persist($category);

    $category = new WorkspaceCategory();
    $category->setName('Café Wifi');
    // On la persiste
    $manager->persist($category);

    // On flush tout ce qu'on vient de créer
    $manager->flush();
  }
}