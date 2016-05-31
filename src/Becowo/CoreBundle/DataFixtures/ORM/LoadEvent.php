<?php

namespace Becowo\CoreBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Becowo\CoreBundle\Entity\Event;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;

class LoadEvent extends Controller implements FixtureInterface, OrderedFixtureInterface
{
  public function load(ObjectManager $manager)
  {
    $event = new Event();
    $event->setTitle('Rencontre avec Mr T');
    $event->setDescription('description de cette rencontre fabuleuse a venir.');
    $event->setStartDate(new \DateTime('2016-07-14 12:00:00'));
    $event->setEndDate(new \DateTime('2016-07-14 16:00:00'));

    $repo = $this->getDoctrine()->getManager()->getRepository('BecowoCoreBundle:Workspace');
    $ws = $repo->findOneBy(array('name' => 'Mutualab'));

    $event->setWorkspace($ws);

    $manager->persist($event);

    $event = new Event();
    $event->setTitle('Rencontre avec Mr T');
    $event->setDescription('description de cette rencontre fabuleuse a venir.');
    $event->setStartDate(new \DateTime('2016-07-14 12:00:00'));
    $event->setEndDate(new \DateTime('2016-07-14 16:00:00'));

    $repo = $this->getDoctrine()->getManager()->getRepository('BecowoCoreBundle:Workspace');
    $ws = $repo->findOneBy(array('name' => 'YellowWorking'));

    $event->setWorkspace($ws);

    $manager->persist($event);

    $event = new Event();
    $event->setTitle('Journée portes ouvertes');
    $event->setDescription('description de cette rencontre fabuleuse a venir.');
    $event->setStartDate(new \DateTime('2016-09-10 09:00:00'));
    $event->setEndDate(new \DateTime('2016-09-10 17:00:00'));

    $repo = $this->getDoctrine()->getManager()->getRepository('BecowoCoreBundle:Workspace');
    $ws = $repo->findOneBy(array('name' => 'Mutualab'));

    $event->setWorkspace($ws);

    $manager->persist($event);

   

    // On flush tout ce qu'on vient de créer
    $manager->flush();
  }

  public function getOrder()
    {
        return 3;
    }
}