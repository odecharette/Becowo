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
            $a = array('Hour' => $p->getPriceHour(), 
                        'HalfDay' => $p->getPriceHalfDay(),
                        'Day' => $p->getPriceDay(),
                        'Month' => $p->getPriceMonth());
            $minPrice = min(array_diff(array_map('intval', $a), array(0))); // renvoi le plus petit prix en excluant les valeurs NULL
        $allWsMinPrices[$i] = $minPrice;
        $i++;
        }

    }

    if(count($allWsMinPrices) > 0)
      $lowestPrice = min($allWsMinPrices);
    else
      $lowestPrice = 0;
    
    $ws->setLowestPrice($lowestPrice);

    $em->persist($ws);
    $em->flush();
  }
}
