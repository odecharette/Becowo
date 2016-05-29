<?php

namespace Becowo\CoreBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Becowo\CoreBundle\Entity\WeekDay;

class LoadWeekDay implements FixtureInterface
{
  public function load(ObjectManager $manager)
  {
    $day = new WeekDay();
    $day->setName('Lundi');
    $day->setIsWeekend(false);
    // On la persiste
    $manager->persist($day);

    $day = new WeekDay();
    $day->setName('Mardi');
    $day->setIsWeekend(false);
    // On la persiste
    $manager->persist($day);

    $day = new WeekDay();
    $day->setName('Mercredi');
    $day->setIsWeekend(false);
    // On la persiste
    $manager->persist($day);

    $day = new WeekDay();
    $day->setName('Jeudi');
    $day->setIsWeekend(false);
    // On la persiste
    $manager->persist($day);

    $day = new WeekDay();
    $day->setName('Vendredi');
    $day->setIsWeekend(false);
    // On la persiste
    $manager->persist($day);

    $day = new WeekDay();
    $day->setName('Samedi');
    $day->setIsWeekend(true);
    // On la persiste
    $manager->persist($day);

    $day = new WeekDay();
    $day->setName('Dimanche');
    $day->setIsWeekend(true);
    // On la persiste
    $manager->persist($day);

    

    // On flush tout ce qu'on vient de créer
    $manager->flush();
  }
}