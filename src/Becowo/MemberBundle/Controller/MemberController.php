<?php

namespace Becowo\MemberBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class MemberController extends Controller
{
  public function viewPublicProfileAction($username)
  {
  	$em = $this->getDoctrine()->getManager();
  	$repo = $em->getRepository('BecowoMemberBundle:Member');
  	$member = $repo->findOneByUsername($username);

  	return $this->render('BecowoMemberBundle::publicProfile.html.twig', array('member' => $member));
  }


}