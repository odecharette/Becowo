<?php

namespace Becowo\MemberBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Becowo\MemberBundle\Entity\Member;
use Becowo\CoreBundle\Entity\Origin;            // TO DO : deplacer vers MemberBundle
use Becowo\CoreBundle\Entity\Country;
use Becowo\CoreBundle\Entity\ProfilePicture;    // TO DO : deplacer vers MemberBundle

class LoadMember implements FixtureInterface
{
  public function load(ObjectManager $manager)
  {
  	/******************************** Olivia ****************************/

    $member = new Member();
    $member->setEmail('odecharette@gmail.com');
    $member->setUsername('Olivia');
    $member->setPassword('olivia');	// TO DO : a changer par un pwd en hash
    $member->setSalt('');
    $member->setRoles(array('ROLE_ADMIN'));
    $member->setFirstName('Olivia');
    $member->setName('de Charette');
    $member->setSex(1);
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
    $origin = new Origin();
    $origin->setName('Manuel');
    $manager->persist($origin);
    $member->setOrigin($origin);

    //Country
    $country = new Country();
    $country->setName('France');
    $manager->persist($country);
    $member->setCountry($country);

    //Profile Picture
    $profile_picture = new ProfilePicture();
    $profile_picture->setUrl('olivia.png');
    $profile_picture->setAlt('Olivia');
    $manager->persist($profile_picture);
    $member->setProfilePicture($profile_picture);
   

    // On la persiste
    $manager->persist($member);

    /********************** Fiona *************************/

    $member = new Member();
    $member->setEmail('fiona_delannoy@hotmail.fr');
    $member->setUsername('Fiona');
    $member->setPassword('fiona');	// TO DO : a changer par un pwd en hash
    $member->setSalt('');
    $member->setRoles(array('ROLE_USER'));
    $member->setFirstName('Fiona');
    $member->setName('Delannoy');
    $member->setSex(1);
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
    $origin = new Origin();
    $origin->setName('Manuel');
    $manager->persist($origin);
    $member->setOrigin($origin);

    //Country
    $country = new Country();
    $country->setName('France');
    $manager->persist($country);
    $member->setCountry($country);

    //Profile Picture
    $profile_picture = new ProfilePicture();
    $profile_picture->setUrl('fiona.png');
    $profile_picture->setAlt('Fiona');
    $manager->persist($profile_picture);
    $member->setProfilePicture($profile_picture);
   

    // On la persiste
    $manager->persist($member);

    // On flush tout ce qu'on vient de créer
    $manager->flush();
  }
}