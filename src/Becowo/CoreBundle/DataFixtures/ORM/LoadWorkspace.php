<?php

namespace Becowo\CoreBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Becowo\CoreBundle\Entity\Workspace;
use Becowo\CoreBundle\Entity\WorkspaceCategory;
use Becowo\CoreBundle\Entity\Country;
use Becowo\CoreBundle\Entity\Amenities;
use Becowo\CoreBundle\Entity\workspaceHasOffice;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;

class LoadWorkspace extends Controller implements FixtureInterface, OrderedFixtureInterface
{
  public function load(ObjectManager $manager)
  {
  	/************************** Yello working **************************************/
    $workspace = new Workspace();
    $workspace->setName('YellowWorking');
    $workspace->setDescription('L’espace de coworking oeuvre en ce sens afin de proposer une atmosphère professionnelle propice à l’échange et à la rencontre. Yelloworking, c’est aussi du sport sur son lieu de travail, des conférences, des formations et des moments conviviaux.');
    $workspace->setDescriptionBonus('Venez profiter de notre Annexe. Un van équipé pour travailler et surfer ;-)');
    $workspace->setWebsite('http://yelloworking.com/');
    $workspace->setIsAlwaysOpen(false);
    $workspace->setStreet('7 BIS AVENUE SAINT-JÉRÔME');
    $workspace->setPostCode('13100');
    $workspace->setCity('Aix en Provence');
    $workspace->setLongitude(5.450794599999995);
    $workspace->setLatitude(43.5227347);
    $workspace->setFirstBookingFree(false);
    $workspace->setFacebookLink('https://www.facebook.com/yelloworking');
    $workspace->setTwitterLink('https://twitter.com/yelloworking');
    $workspace->setInstagramLink('');
    $workspace->setIsVisible(true);

    // Category
    $category = new WorkspaceCategory();
    $category->setName('coworking');
    $manager->persist($category);
    $workspace->setCategory($category);

    //country
    $country = new Country();
    $country->setName('France');
    $manager->persist($country);
    $workspace->setCountry($country);

    // Amenities
    $repo = $this->getDoctrine()->getManager()->getRepository('BecowoCoreBundle:Amenities');
    $amenities = $repo->findAll();

    foreach ($amenities as $amenity) {
        $workspace->addAmenity($amenity);
    }

    //Offices
    $repo = $this->getDoctrine()->getManager()->getRepository('BecowoCoreBundle:Office');
    $offices = $repo->findAll();

    foreach ($offices as $office) {
        $workspaceHasOffice = new workspaceHasOffice();
        $workspaceHasOffice->setWorkspace($workspace);
        $workspaceHasOffice->setOffice($office);
        $workspaceHasOffice->setDeskQty(2);
        $manager->persist($workspaceHasOffice);
    }

    //TeamMembers
    $repo = $this->getDoctrine()->getManager()->getRepository('BecowoCoreBundle:TeamMember');
    $members = $repo->findAll();

    foreach ($members as $member) {
        $workspace->addTeamMember($member);
    }


    //addPoi
    //addOffer

    // On la persiste
    $manager->persist($workspace);

	/************************** Mutualab **************************************/
    $workspace = new Workspace();
    $workspace->setName('Mutualab');
    $workspace->setDescription('CoworkingLille est une communauté de gens, de talents, d\'indépendants, de tous bords, de tous horizons, qui se rassemblent autour d\'un lieu (Mutualab) pour travailler, collaborer, échanger et innover.');
    $workspace->setDescriptionBonus('Ceci est la phrase bonus !!!');
    $workspace->setWebsite('http://www.mutualab.org/');
    $workspace->setIsAlwaysOpen(false);
    $workspace->setStreet('19 rue Nicolas Leblanc');
    $workspace->setPostCode('59000');
    $workspace->setCity('Lille');
    $workspace->setLongitude(3.061799800000017);
    $workspace->setLatitude(50.6296016);
    $workspace->setFirstBookingFree(false);
    $workspace->setFacebookLink('https://www.facebook.com/Mutualab');
    $workspace->setTwitterLink('https://twitter.com/mutualab');
    $workspace->setInstagramLink('');
    $workspace->setIsVisible(true);

    // Category
    $category = new WorkspaceCategory();
    $category->setName('coworking');
    $manager->persist($category);
    $workspace->setCategory($category);

    //country
    $country = new Country();
    $country->setName('France');
    $manager->persist($country);
    $workspace->setCountry($country);

    // Amenities
    $repo = $this->getDoctrine()->getManager()->getRepository('BecowoCoreBundle:Amenities');
    $amenities = $repo->findAll();

    foreach ($amenities as $amenity) {
        $workspace->addAmenity($amenity);
    }

    //Offices
    $repo = $this->getDoctrine()->getManager()->getRepository('BecowoCoreBundle:Office');
    $offices = $repo->findAll();

    foreach ($offices as $office) {
        $workspaceHasOffice = new workspaceHasOffice();
        $workspaceHasOffice->setWorkspace($workspace);
        $workspaceHasOffice->setOffice($office);
        $workspaceHasOffice->setDeskQty(3);
        $manager->persist($workspaceHasOffice);
    }

    //TeamMembers
    $repo = $this->getDoctrine()->getManager()->getRepository('BecowoCoreBundle:TeamMember');
    $members = $repo->findAll();

    foreach ($members as $member) {
        $workspace->addTeamMember($member);
    }

    //addPoi
    //addOffer

    // On la persiste
    $manager->persist($workspace);
    

    // On flush tout ce qu'on vient de créer
    $manager->flush();
  }

  public function getOrder()
    {
        // the order in which fixtures will be loaded
        // the lower the number, the sooner that this fixture is loaded
        return 1;
    }
}