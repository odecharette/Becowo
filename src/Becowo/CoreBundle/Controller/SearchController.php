<?php

namespace Becowo\CoreBundle\Controller;

use Becowo\CoreBundle\Services\SearchEngine;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class SearchController extends Controller
{
/***
  public function searchAction($query)
  {
    
    $finder = $this->container->get('fos_elastica.finder.becowo.workspace');
    $query = new \Elastica\Query\Match();
    $query->setField('name', 'Mutualab');
    $ws = $finder->find($query);

    $nbresults = $this->container->get('fos_elastica.index.becowo.workspace')->count($query);

  	return $this->render('Search/results.html.twig', array(
  		'ws' => $ws, 
      'nbresults' => $nbresults));
  }
   **/

  public function searchAction(Request $request)
  {
    $moteurRecherche = $this->get('app.search');  // déclaré dans services.yml
    $recherche = $request->query->get('recherche', '');
    $WS = [];

    if ($request->isMethod('GET')) {
      
        if (strlen($recherche) >= SearchEngine::MIN_CHAR_MDR_CATEGORIE) {
            $resultats = $moteurRecherche->rechercheWorkspace($recherche);
            //$WS[] = ['result' => 'Workspaces', 'url' => null]; // titre au dessus des résultats

            foreach ($resultats as $result) {
                $WS[] = ['result' => $result->getName(),
                    'url' => $this->get('router')->generate('becowo_core_workspace', array('name' => $result->getName()))
                ];
            }
      
        } else {
            $WS = [];
        }            

    } else {
        $WS = [];
    }

    return new JsonResponse($WS);
  }

}