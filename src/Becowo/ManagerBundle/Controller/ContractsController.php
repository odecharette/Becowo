<?php

namespace Becowo\ManagerBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Finder\Finder;

class ContractsController extends Controller
{
  public function viewAction()
  {
  	$wsName = $this->getUser()->getWorkspace()->getName();
	$finder = new Finder();
	$dir = $this->container->getParameter('kernel.root_dir');
	$finder->files()->in($dir.'/../web/documents/contracts/'.$wsName.'/');
	$finder->sortByName();
	$finder->files()->name('*.pdf');

  	return $this->render('Manager/contracts.html.twig', array('finder' => $finder));
  }


}
