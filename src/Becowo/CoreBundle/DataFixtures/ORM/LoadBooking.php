<?php

namespace Becowo\CoreBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Becowo\CoreBundle\Entity\Booking;
use Becowo\CoreBundle\Entity\Status;
use Becowo\CoreBundle\Entity\Office;
use Becowo\MemberBundle\Entity\Member;
use Becowo\CoreBundle\Entity\Workspace;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;

class LoadBooking extends Controller implements FixtureInterface, OrderedFixtureInterface
{
  public function load(ObjectManager $manager)
  {
    $booking = new Booking();
    $booking->setStartDate(new \DateTime('2016-01-01 09:00:00'));
    $booking->setEndDate(new \DateTime('2016-01-01 19:00:00'));
    $booking->setIsFirstBook(true);
    $booking->setPriceInclTax(150.00);
    $booking->setPriceExclTax(130.00);

    $booking->setStatus($this->getDoctrine()
                            ->getManager()
                            ->getRepository('BecowoCoreBundle:Status')
                            ->findOneBy(array('name' => 'Confirmée')));

    $booking->setOffice($this->getDoctrine()
                            ->getManager()
                            ->getRepository('BecowoCoreBundle:Office')
                            ->findOneBy(array('name' => 'Bureau')));

    $booking->setMember($this->getDoctrine()
                            ->getManager()
                            ->getRepository('BecowoMemberBundle:Member')
                            ->findOneBy(array('username' => 'olivia')));

    $booking->setWorkspace($this->getDoctrine()
                            ->getManager()
                            ->getRepository('BecowoCoreBundle:Workspace')
                            ->findOneBy(array('name' => 'Mutualab')));


    $manager->persist($booking);


    $manager->flush();
  }

    public function getOrder()
    {
        return 3;
    }
}