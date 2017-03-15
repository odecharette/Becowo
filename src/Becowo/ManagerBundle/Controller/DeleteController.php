<?php

namespace Becowo\ManagerBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DeleteController extends Controller
{
  public function deleteWsHasOfficeAction(Request $request, $id, $wsId)
  {
    $em = $this->getDoctrine()->getEntityManager();
    $office = $em->getRepository('BecowoCoreBundle:WorkspaceHasOffice')->find($id);

    if (!$office) {
        throw $this->createNotFoundException('No office found for id '.$id);
    }

    $em->remove($office);
    $em->flush();

    $request->getSession()->getFlashBag()->add('success', 'L\'élément a bien été supprimé');

    return $this->redirectToRoute('becowo_manager_profile_offices', array('id' => $wsId));
  }

  public function deleteEventAction(Request $request, $id, $wsId)
  {
    $em = $this->getDoctrine()->getEntityManager();
    $event = $em->getRepository('BecowoCoreBundle:Event')->find($id);

    if (!$event) {
        throw $this->createNotFoundException('No event found for id '.$id);
    }

    $em->remove($event);
    $em->flush();

    $request->getSession()->getFlashBag()->add('success', 'L\'élément a bien été supprimé');
    

    return $this->redirectToRoute('becowo_manager_profile_events', array('id' => $wsId));
  }

  public function deletePricesAction(Request $request, $id, $wsId)
  {
    $em = $this->getDoctrine()->getEntityManager();
    $price = $em->getRepository('BecowoCoreBundle:Price')->find($id);

    if (!$price) {
        throw $this->createNotFoundException('No price found for id '.$id);
    }

    $em->remove($price);
    $em->flush();

    $request->getSession()->getFlashBag()->add('success', 'L\'élément a bien été supprimé');
    

    return $this->redirectToRoute('becowo_manager_profile_events', array('id' => $wsId));
  }

  public function deleteWorkspaceHasAmenitiesAction(Request $request, $id, $wsId)
  {
    $em = $this->getDoctrine()->getEntityManager();
    $wha = $em->getRepository('BecowoCoreBundle:WorkspaceHasAmenities')->find($id);

    if (!$wha) {
        throw $this->createNotFoundException('No wha found for id '.$id);
    }

    $em->remove($wha);
    $em->flush();

    $request->getSession()->getFlashBag()->add('success', 'L\'élément a bien été supprimé');

    return $this->redirectToRoute('becowo_manager_profile_amenities', array('id' => $wsId));
  }

  public function deleteTeamAction(Request $request, $id, $wsId)
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

    $request->getSession()->getFlashBag()->add('success', 'L\'élément a bien été supprimé');
    

    return $this->redirectToRoute('becowo_manager_profile_team', array('id' => $wsId));
  }

  public function deletePictureAction(Request $request, $id, $wsId)
  {
    $em = $this->getDoctrine()->getEntityManager();
    $pic = $em->getRepository('BecowoCoreBundle:Picture')->find($id);

    if (!$pic) {
        throw $this->createNotFoundException('No picture found for id '.$id);
    }
    // TO DO : supprimer le fichier de l'image

    $em->remove($pic);
    $em->flush();

    $request->getSession()->getFlashBag()->add('success', 'L\'élément a bien été supprimé');
    
    return $this->redirectToRoute('becowo_manager_profile_pictures', array('id' => $wsId));
    
  }

}
