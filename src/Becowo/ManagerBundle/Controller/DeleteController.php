<?php

namespace Becowo\ManagerBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

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

  public function deletePricesAction($id)
  {
    $em = $this->getDoctrine()->getEntityManager();
    $price = $em->getRepository('BecowoCoreBundle:Price')->find($id);

    if (!$price) {
        throw $this->createNotFoundException('No price found for id '.$id);
    }

    $em->remove($price);
    $em->flush();

    return $this->redirectToRoute('becowo_manager_profile_events');
  }

  public function deleteWorkspaceHasAmenitiesAction($id)
  {
    $em = $this->getDoctrine()->getEntityManager();
    $wha = $em->getRepository('BecowoCoreBundle:WorkspaceHasAmenities')->find($id);

    if (!$wha) {
        throw $this->createNotFoundException('No wha found for id '.$id);
    }

    $em->remove($wha);
    $em->flush();

    return $this->redirectToRoute('becowo_manager_profile_amenities');
  }

  public function deleteTeamAction($id)
  {
    $em = $this->getDoctrine()->getEntityManager();
    $wht = $em->getRepository('BecowoCoreBundle:WorkspaceHasTeamMember')->find($id);
    $member = $wht->getTeamMember();

    if (!$wht) {
        throw $this->createNotFoundException('No ws has team member found for id '.$id);
    }

    if (!$member) {
        throw $this->createNotFoundException('No member found for ws has team member id '.$id);
    }

    $em->remove($member);
    $em->remove($wht);
    $em->flush();

    return $this->redirectToRoute('becowo_manager_profile_team');
  }

  public function deletePictureAction($id)
  {
    $em = $this->getDoctrine()->getEntityManager();
    $pic = $em->getRepository('BecowoCoreBundle:Picture')->find($id);

    if (!$pic) {
        throw $this->createNotFoundException('No picture found for id '.$id);
    }
    // TO DO : supprimer le fichier de l'image

    $em->remove($pic);
    $em->flush();

    return $this->redirectToRoute('becowo_manager_profile_pictures');
    
  }

}
