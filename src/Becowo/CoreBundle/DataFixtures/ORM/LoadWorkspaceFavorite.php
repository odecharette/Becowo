<?php

namespace Becowo\CoreBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Becowo\CoreBundle\Entity\WorkspaceFavorite;

class LoadWorkspaceFavorite implements FixtureInterface
{
  public function load(ObjectManager $manager)
  {
  	$repo = $manager->getRepository('BecowoCoreBundle:Workspace');
	$workspace = $repo->findOneByName('YellowWorking');

    $favorite = new WorkspaceFavorite();
    $favorite->setWorkspace($workspace);
    $favorite->setDescription('Il claque cet espace !');
    // On la persiste
    $manager->persist($favorite);

    

    // On flush tout ce qu'on vient de créer
    $manager->flush();
  }
}