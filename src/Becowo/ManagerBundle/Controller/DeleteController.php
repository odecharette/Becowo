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


}