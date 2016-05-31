<?php

namespace Becowo\CoreBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Becowo\CoreBundle\Entity\TeamMember;

class LoadTeamMember implements FixtureInterface
{
  public function load(ObjectManager $manager)
  {
    $teamMember = new TeamMember();
    $teamMember->setFirstname('Sophie');
    $teamMember->setName('Toutatoi');
    $teamMember->setEmail('toutatoi@gmail.com');
    $teamMember->setUrlProfilePicture('');
    $teamMember->setDescription('');
    $teamMember->setPhone('0000000000');
    $teamMember->setJob('Manager');
    $manager->persist($teamMember);

    

    // On flush tout ce qu'on vient de créer
    $manager->flush();
  }


}