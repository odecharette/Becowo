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
    	$ageChart = new PieChart();
     
     	$res = $this->em->getRepository('BecowoMemberBundle:Member')->getAgeByRangeFromMembers();

     	$data = $this->transformData($res, 'bucket', 'count');

		$ageChart->getData()->setArrayToDataTable($data);
	    $ageChart->getOptions()->setIs3D(true);

	    return $ageChart;

    }

    private function transformData($res, $col1, $col2)
    {
    	$data[] = array([$col1], [$col2]);
     	foreach ($res as $val)
        {
            $data[] = array($val[$col1], (int) $val[$col2]);
        }
        return $data;

    }

}
