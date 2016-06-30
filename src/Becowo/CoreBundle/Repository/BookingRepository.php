<?php

namespace Becowo\CoreBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query\ResultSetMapping;


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

	public function getBookingByOfficeType()
	{
		$rsm = new ResultSetMapping();
		$sql = "SELECT o.name AS office, count(b.id) AS count
				FROM booking b, office o 
				WHERE b.office_id = o.id 
				AND b.status_id IN (SELECT id FROM status WHERE name = 'Confirmée')
				GROUP BY o.name";

		$rsm->addScalarResult('office', 'office');
		$rsm->addScalarResult('count', 'count');

		return $this->getEntityManager()->createNativeQuery($sql, $rsm)->getScalarResult();
	}
	
}
