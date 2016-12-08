<?php

namespace Becowo\MemberBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class MemberController extends Controller
{
  public function viewPublicProfileAction($id)
  {
  	$em = $this->getDoctrine()->getManager();
  	$repo = $em->getRepository('BecowoMemberBundle:Member');
  	$member = $repo->findOneById($id);

  	return $this->render('Member/ViewPublicProfile.html.twig', array('member' => $member));
  }


}
