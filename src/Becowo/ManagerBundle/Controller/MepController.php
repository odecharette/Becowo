<?php

namespace Becowo\ManagerBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Becowo\CoreBundle\Entity\Workspace;
use Becowo\CoreBundle\Entity\WorkspaceHasOffice;
use Becowo\CoreBundle\Entity\Event;
use Becowo\CoreBundle\Entity\TeamMember;
use Becowo\CoreBundle\Entity\WorkspaceHasAmenities;
use Becowo\CoreBundle\Entity\WorkspaceHasTeamMember;
use Becowo\CoreBundle\Entity\Price;
use Becowo\CoreBundle\Entity\WorkspaceIsClosed;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class MepController extends Controller
{

  public function copyWSAction(Request $request)
  {
    $WsService = $this->get('app.workspace');
    $ws = $WsService->getActiveWorkspaces();

    $data = array();
    $form = $this->createFormBuilder($data)
      ->add('Workspace', EntityType::class, array(
            'class' => 'BecowoCoreBundle:Workspace',
            'multiple' => false,
            'expanded' => false))
      ->add('From', ChoiceType::class, array('choices' => array(
            'local' => 'local',
            'demo' => 'demo',
            'prod' => 'prod')))
      ->add('To', ChoiceType::class, array('choices' => array(
            'local' => 'local',
            'demo' => 'demo',
            'prod' => 'prod')))
      ->add('Submit', SubmitType::class)
      ->getForm();

    if ($request->isMethod('POST')) {
      $form->handleRequest($request);
      $data = $form->getData();

      $fromWS = $data['Workspace'];
      $fromWho = $WsService->getOfficesByWorkspace($fromWS);

      // $ToEm = $this->get('doctrine')->getManager($data['To']);

      // // Copy Workspace
      // $ToEm->persist($fromWS);
      // $ToEm->flush();

     

      dump($data);

       $this->addFlash('success', 'Bravo ! ' . $fromWS->getName() . ' a bien été copié de ' . $data['From'] . ' vers ' . $data['To']);
    }
  	

  	return $this->render('Manager/mep/mep.html.twig', array('form' => $form->createView()));
  }


}
