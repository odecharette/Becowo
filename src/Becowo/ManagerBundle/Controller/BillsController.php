<?php

namespace Becowo\ManagerBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Finder\Finder;

class BillsController extends Controller
{
  public function viewAction(Request $request, $id)
  {
    $WsService = $this->get('app.workspace');
    $workspace = $WsService->getWorkspaceById($id);

  	$wsName = $workspace->getName();
	$finder = new Finder();
	$dir = $this->container->getParameter('kernel.root_dir');
	$finder->files()->in($dir.'/../web/documents/bills/'.$wsName.'/');
	$finder->sortByName();
	$finder->files()->name('*.pdf');

  	return $this->render('Manager/bills.html.twig', array('finder' => $finder, 'workspace' => $workspace));
  }


}
