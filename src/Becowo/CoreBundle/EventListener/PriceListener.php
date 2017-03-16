<?php

namespace Becowo\CoreBundle\EventListener;

use Symfony\Component\HttpFoundation\Response;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Becowo\CoreBundle\Entity\Price;
use Symfony\Component\DependencyInjection\Container;
use Doctrine\ORM\Mapping as ORM;

class PriceListener
{
  protected $container;
    
    public function __construct(Container $container)
    {
        $this->container = $container;
    }

// Le nom de la methode definit sont moment d'execution
  public function postUpdate(Price $price, LifecycleEventArgs $event) 
  {

    $em = $event->getEntityManager();
    $ws = $price->getWorkspaceHasOffice()->getWorkspace();

    $repo = $em->getRepository('BecowoCoreBundle:Price');
    $prices = $repo->findPricesByWorkspace($ws);

    $minPrice = 0;
    $allWsMinPrices = array();
    $i = 0;

    foreach ($prices as $p) {
        if($p->getPriceHour() == null && $p->getPriceHalfDay() == null && $p->getPriceDay() == null && $p->getPriceMonth() == null)
        {
            //
        }else{
            // on round le prix, sinon ca pose problème pour min() qui exclue les valeurs NULL
            $a = array('heure' => intval($p->getPriceHour()), 
                        '1/2 journée' => intval($p->getPriceHalfDay()),
                        'jour' => intval($p->getPriceDay()),
                        'mois' => intval($p->getPriceMonth()));
           
            // renvoi le plus petit prix en excluant les valeurs NULL tout en gardant le nom de la Key
            $minPriceLabel = array_search(min(array_diff(array_map('intval', $a), array(0))), $a);
            $minPrice = min(array_diff(array_map('intval', $a), array(0)));

        array_push($allWsMinPrices, [$minPriceLabel, $minPrice]);
        }

    }

    if(count($allWsMinPrices) > 0)
      $lowestPrice = round(min(array_column($allWsMinPrices, 1))) . '<sup>€</sup> / ' . $allWsMinPrices[array_search(min(array_column($allWsMinPrices, 1)), $allWsMinPrices)][0];
    else
      $lowestPrice = 0;

    $ws->setLowestPrice($lowestPrice);

    $em->persist($ws);
    $em->flush();
  }
}
