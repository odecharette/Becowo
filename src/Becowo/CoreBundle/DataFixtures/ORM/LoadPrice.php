<?php

namespace Becowo\CoreBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Becowo\CoreBundle\Entity\Price;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;

class LoadPrice implements FixtureInterface, OrderedFixtureInterface
{
  public function load(ObjectManager $manager)
  {

  	$repo = $manager->getRepository('BecowoCoreBundle:Workspace');
  	$ws = $repo->findOneByName('Mutualab');

  	$repo = $manager->getRepository('BecowoCoreBundle:Office');
  	$office = $repo->findOneByName('Open space');

  	$prix = new Price();
  	$prix->setWorkspace($ws);
  	$prix->setOffice($office);
  	$prix->setPriceHour(20);
  	$prix->setPriceHalfDay(30);
  	$prix->setPriceDay(50);
  	$prix->setPriceWeek(200);
  	$prix->setPriceMonth(350);
    $manager->persist($prix);

  	$office = $repo->findOneByName('Bureau');

  	$prix = new Price();
  	$prix->setWorkspace($ws);
  	$prix->setOffice($office);
  	$prix->setPriceHour(25);
  	$prix->setPriceHalfDay(35);
  	$prix->setPriceDay(55);
  	$prix->setPriceWeek(205);
  	$prix->setPriceMonth(355);
    $manager->persist($prix);

  	$office = $repo->findOneByName('Salle de réunion');

  	$prix = new Price();
  	$prix->setWorkspace($ws);
  	$prix->setOffice($office);
  	$prix->setPriceHour(20);
  	$prix->setPriceHalfDay(30);
  	$prix->setPriceDay(50);
  	$prix->setPriceWeek(200);
  	$prix->setPriceMonth(350);
    $manager->persist($prix);

  	$office = $repo->findOneByName('Salle de conférence');

  	$prix = new Price();
  	$prix->setWorkspace($ws);
  	$prix->setOffice($office);
  	$prix->setPriceHour(50);
    $manager->persist($prix);

    $office = $repo->findOneByName('Canapé');

  	$prix = new Price();
  	$prix->setWorkspace($ws);
  	$prix->setOffice($office);
  	$prix->setPriceHour(10);
  	$prix->setPriceHalfDay(20);
    $manager->persist($prix);

    $office = $repo->findOneByName('Hamac');

  	$prix = new Price();
  	$prix->setWorkspace($ws);
  	$prix->setOffice($office);
  	$prix->setPriceHour(10);
  	$prix->setPriceHalfDay(20);
    $manager->persist($prix);
   

    $manager->flush();
  }

	public function getOrder()
    {
        // the order in which fixtures will be loaded
        // the lower the number, the sooner that this fixture is loaded
        return 4;
    }
}