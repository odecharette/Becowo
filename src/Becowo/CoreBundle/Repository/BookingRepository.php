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

	public function getBookingByDuration()
	{
		$rsm = new ResultSetMapping();
		$sql = "SELECT (case when duration < 5 then 'Journée' 
				when duration >=5 and duration <= 9 then 'Semaine' 
				else 'Mois' end) bucket, 
				count(*) AS count 
				FROM(SELECT  ABS(CEIL(DATEDIFF(b.end_date, b.start_date)))+1 AS duration 
					FROM Booking b
					WHERE b.status_id IN (SELECT id FROM status WHERE name = 'Confirmée')) request 
				GROUP BY (case when duration < 5 then 'Journée' 
				when duration >=5 and duration <= 9 then 'Semaine' 
				else 'Mois' end)";

		$rsm->addScalarResult('bucket', 'bucket');
		$rsm->addScalarResult('count', 'count');

		return $this->getEntityManager()->createNativeQuery($sql, $rsm)->getScalarResult();
	}
	
}
