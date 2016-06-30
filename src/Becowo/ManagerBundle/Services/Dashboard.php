<?php

namespace Becowo\ManagerBundle\Services;

use Doctrine\ORM\EntityManager;
use CMEN\GoogleChartsBundle\GoogleCharts\Charts\PieChart;

class Dashboard
{
	private $em = null;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    public function getAgeChart()
    {
    	$pieChart = new PieChart();
    	$pieChart->getData()->setArrayToDataTable(
        [['Age', 'Nb de coworkers'],
         ['18-24 ans', 60],
         ['25-34 ans', 20],
         ['35-44 ans', 10],
         ['Plus de 45 ans', 10]
        ]
	    );
	    $pieChart->getOptions()->setTitle('Répartition des coworkers par âge');
	    $pieChart->getOptions()->setIs3D(true);

	    return $pieChart;

    }

}
