<?php

namespace Becowo\MemberBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Becowo\MemberBundle\Entity\Member;
use Becowo\CoreBundle\Entity\Origin;
use Becowo\CoreBundle\Entity\Country;
use Becowo\CoreBundle\Entity\ProfilePicture;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;

class LoadMember extends Controller implements FixtureInterface, ContainerAwareInterface, OrderedFixtureInterface
{

    protected $container;
    
  public function load(ObjectManager $manager)
  {
    $userManager = $this->container->get('fos_user.user_manager');

  	/******************************** Olivia ****************************/

    $member = $userManager->createUser();
    $member->setEmail('odecharette@gmail.com');
    $member->setUsername('olivia');
    $member->setPlainPassword('olivia');
    $member->setRoles(array('ROLE_ADMIN'));
    $member->setFirstName('Olivia');
    $member->setName('de Charette');
    $member->setSex('F');
    $member->setBirthDate(new \DateTime('1985-10-01'));
    $member->setPhone('0650225827');
    $member->setStreet('10 rue de Prony');
    $member->setPostCode('92600');
    $member->setCity('Asnieres');
    $member->setJob('Co-founder of Becowo');
    $member->setSociety('Becowo');
    $member->setWebsite('http://www.becowo.com');
    $member->setDescription('');
    $member->setSignUpDate(new \DateTime('2016-05-28'));
    $member->setEnabled(true);

    //Origin
    $repo = $this->getDoctrine()->getManager()->getRepository('BecowoCoreBundle:Origin');
    $member->setOrigin($repo->findOneByName('Manuel'));

    //Country
    $repo = $this->getDoctrine()->getManager()->getRepository('BecowoCoreBundle:Country');
    $member->setCountry($repo->findOneByName('France'));

    //Profile Picture
    $profile_picture = new ProfilePicture();
    $profile_picture->setUrl('olivia.png');
    $profile_picture->setAlt('Olivia');
    $manager->persist($profile_picture);
    $member->setProfilePicture($profile_picture);
   
    $userManager->updateUser($member, true);

    /********************** Fiona *************************/

    $member = $userManager->createUser();
    $member->setEmail('fiona_delannoy@hotmail.fr');
    $member->setUsername('fiona');
    $member->setPlainPassword('fiona');
    $member->setRoles(array('ROLE_USER'));
    $member->setFirstName('Fiona');
    $member->setName('Delannoy');
    $member->setSex('F');
    $member->setBirthDate(new \DateTime('1985-10-01'));
    $member->setPhone('');
    $member->setStreet('');
    $member->setPostCode('');
    $member->setCity('Arras');
    $member->setJob('Founder of Becowo');
    $member->setSociety('Becowo');
    $member->setWebsite('http://www.becowo.com');
    $member->setDescription('');
    $member->setSignUpDate(new \DateTime('2016-05-28'));
    $member->setEnabled(true);

    //Origin
    $repo = $this->getDoctrine()->getManager()->getRepository('BecowoCoreBundle:Origin');
    $member->setOrigin($repo->findOneByName('Manuel'));

    //Country
    $repo = $this->getDoctrine()->getManager()->getRepository('BecowoCoreBundle:Country');
    $member->setCountry($repo->findOneByName('France'));

    //Profile Picture
    $profile_picture = new ProfilePicture();
    $profile_picture->setUrl('fiona.png');
    $profile_picture->setAlt('Fiona');
    $manager->persist($profile_picture);
    $member->setProfilePicture($profile_picture);
   

    $userManager->updateUser($member, true);

    // On flush tout ce qu'on vient de créer
    $manager->flush();
  }

  public function setContainer(ContainerInterface $container = null)
  {
    $this->container = $container;
  }

  public function getOrder()
    {
        // the order in which fixtures will be loaded
        // the lower the number, the sooner that this fixture is loaded
        return 1;
    }
}