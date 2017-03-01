<?php

namespace Becowo\ApiBundle\Repository;

use Doctrine\ORM\EntityRepository;


class ApiEventsRepository extends EntityRepository
{
	public function findApiEventsParam()
	{
		$qb = $this->createQueryBuilder('a');

		return $qb->getQuery()->getResult();
	}
}
