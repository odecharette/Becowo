<?php

namespace Becowo\CoreBundle\Repository;

use Doctrine\ORM\EntityRepository;


class BookingRepository extends EntityRepository
{
	public function getTotInclTaxReservationsByWorkspace($ws)
	{
		$qb = $this->createQueryBuilder('b');
		$qb->select('SUM(b.priceInclTax) AS total')
			->where('b.workspace = :ws')
			->setParameter('ws', $ws);

		return $qb->getQuery()->getSingleScalarResult();
	}
	
}
