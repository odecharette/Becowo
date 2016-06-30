<?php

namespace Becowo\MemberBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Becowo\MemberBundle\Entity\Member;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;

class LoadMemberIsManager extends Controller implements FixtureInterface, OrderedFixtureInterface
{
    
  public function load(ObjectManager $manager)
  {
    $userManager = $this->container->get('fos_user.user_manager');

    // setup a link between Member and WS so the Member have access to manage the WS

  	$repo = $this->getDoctrine()->getManager()->getRepository('BecowoMemberBundle:Member');
    $member = $repo->findOneByFirstname('olivia');

    $repo = $this->getDoctrine()->getManager()->getRepository('BecowoCoreBundle:Workspace');
    $ws = $repo->findOneByName('Mutualab');

    $member->setWorkspace($ws);

    $manager->persist($member);
    $manager->flush();
  }

  public function getOrder()
    {
        // the order in which fixtures will be loaded
        // the lower the number, the sooner that this fixture is loaded
        return 4;
    }
}