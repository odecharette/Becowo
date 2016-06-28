<?php

namespace Becowo\ManagerBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DeleteController extends Controller
{
  public function deleteWsHasOfficeAction($id)
  {
    $em = $this->getDoctrine()->getEntityManager();
    $office = $em->getRepository('BecowoCoreBundle:WorkspaceHasOffice')->find($id);

    if (!$office) {
        throw $this->createNotFoundException('No office found for id '.$id);
    }

    $em->remove($office);
    $em->flush();

    return $this->redirectToRoute('becowo_manager_profile_offices');
  }

  public function deleteEventAction($id)
  {
    $em = $this->getDoctrine()->getEntityManager();
    $event = $em->getRepository('BecowoCoreBundle:Event')->find($id);

    if (!$event) {
        throw $this->createNotFoundException('No event found for id '.$id);
    }

    $em->remove($event);
    $em->flush();

    return $this->redirectToRoute('becowo_manager_profile_events');
  }

  public function deleteTeamAction($id)
  {
    $em = $this->getDoctrine()->getEntityManager();
    $team = $em->getRepository('BecowoCoreBundle:Team')->find($id);

    if (!$team) {
        throw $this->createNotFoundException('No team member found for id '.$id);
    }

    $em->remove($team);
    $em->flush();

    return $this->redirectToRoute('becowo_manager_profile_team');
  }



}