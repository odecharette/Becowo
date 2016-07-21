<?php

namespace Becowo\CoreBundle\Repository;

use Doctrine\ORM\EntityRepository;


class VoteRepository extends EntityRepository
{
	public function getAverage($ws)
	{
		$qb = $this->createQueryBuilder('v');
		$qb->select('AVG(v.scoreAvg) AS Average')
			->where('v.workspace = :ws')
			->setParameter('ws', $ws);

		return $qb->getQuery()->getSingleScalarResult();
	}
}
