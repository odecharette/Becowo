<?php

namespace Becowo\CoreBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Becowo\CoreBundle\Entity\Workspace;
use Becowo\CoreBundle\Entity\Picture;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;

class LoadPictures extends Controller implements FixtureInterface, OrderedFixtureInterface
{
  public function load(ObjectManager $manager)
  {
  	$repo = $this->getDoctrine()->getManager()->getRepository('BecowoCoreBundle:Workspace');
    $ws = $repo->findOneByName('YellowWorking');

  	$pic = new Picture();
  	$pic->setUrl('01.jpg');
  	$pic->setAlt('01');
  	$pic->setIsfavorite(true);
  	$pic->setIslogo(false);
    $pic->setWorkspace($ws);

  	$manager->persist($pic);

  	$pic = new Picture();
  	$pic->setUrl('02.jpg');
  	$pic->setAlt('02');
  	$pic->setIsfavorite(false);
  	$pic->setIslogo(false);
    $pic->setWorkspace($ws);

  	$manager->persist($pic);

  	$pic = new Picture();
  	$pic->setUrl('03.jpg');
  	$pic->setAlt('03');
  	$pic->setIsfavorite(false);
  	$pic->setIslogo(false);
    $pic->setWorkspace($ws);

  	$manager->persist($pic);

  	$pic = new Picture();
  	$pic->setUrl('logo.png');
  	$pic->setAlt('Logo YelloWorking');
  	$pic->setIsfavorite(false);
  	$pic->setIslogo(true);
    $pic->setWorkspace($ws);

  	$manager->persist($pic);

  	//***************************************

  	$repo = $this->getDoctrine()->getManager()->getRepository('BecowoCoreBundle:Workspace');
    $ws = $repo->findOneByName('Mutualab');

  	$pic = new Picture();
  	$pic->setUrl('01.jpg');
  	$pic->setAlt('01');
  	$pic->setIsfavorite(true);
  	$pic->setIslogo(false);
    $pic->setWorkspace($ws);

  	$manager->persist($pic);

  	$pic = new Picture();
  	$pic->setUrl('02.jpg');
  	$pic->setAlt('02');
  	$pic->setIsfavorite(false);
  	$pic->setIslogo(false);
    $pic->setWorkspace($ws);

  	$manager->persist($pic);

  	$pic = new Picture();
  	$pic->setUrl('03.jpg');
  	$pic->setAlt('03');
  	$pic->setIsfavorite(false);
  	$pic->setIslogo(false);
    $pic->setWorkspace($ws);

  	$manager->persist($pic);

  	$pic = new Picture();
  	$pic->setUrl('04.jpg');
  	$pic->setAlt('04');
  	$pic->setIsfavorite(false);
  	$pic->setIslogo(false);
    $pic->setWorkspace($ws);

  	$manager->persist($pic);

  	$pic = new Picture();
  	$pic->setUrl('05.jpg');
  	$pic->setAlt('05');
  	$pic->setIsfavorite(false);
  	$pic->setIslogo(false);
    $pic->setWorkspace($ws);

  	$manager->persist($pic);

  	$pic = new Picture();
  	$pic->setUrl('logo.png');
  	$pic->setAlt('Logo Mutualab');
  	$pic->setIsfavorite(false);
  	$pic->setIslogo(true);
    $pic->setWorkspace($ws);

  	$manager->persist($pic);

  	$manager->flush();

  }

  public function getOrder()
    {
        // the order in which fixtures will be loaded
        // the lower the number, the sooner that this fixture is loaded
        return 3;
    }
}