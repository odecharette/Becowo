<?php

namespace Becowo\MemberBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class MemberController extends Controller
{
  public function viewPublicProfileAction($id)
  {
  	$MemberService = $this->get('app.member');
  	$member = $MemberService->getMemberById($id);

  	$WsService = $this->get('app.workspace');
  	$wsBooked = $WsService->getWsBookedByMemberId($id);

  	return $this->render('Member/ViewPublicProfile.html.twig', array('member' => $member, 'wsBooked' =>$wsBooked));
  }


}
