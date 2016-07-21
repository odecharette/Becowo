<?php

namespace Becowo\MemberBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class MemberController extends Controller
{
  public function viewPublicProfileAction($username)
  {
  	$em = $this->getDoctrine()->getManager();
  	$repo = $em->getRepository('BecowoMemberBundle:Member');
  	$member = $repo->findOneByUsername($username);

  	return $this->render('Member/ViewPublicProfile.html.twig', array('member' => $member));
  }


}
