<?php

namespace Becowo\CoreBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query\ResultSetMapping;
use Symfony\Component\HttpFoundation\JsonResponse;

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
				else 'Mois' end) bucket, 
				count(*) AS count 
				FROM(SELECT  ABS(CEIL(DATEDIFF(b.end_date, b.start_date)))+1 AS duration 
					FROM Booking b
					WHERE b.status_id IN (SELECT id FROM status WHERE name = 'Confirmée')) request 
				GROUP BY (case when duration < 5 then 'Journée' 
				else 'Mois' end)";

		$rsm->addScalarResult('bucket', 'bucket');
		$rsm->addScalarResult('count', 'count');

		return $this->getEntityManager()->createNativeQuery($sql, $rsm)->getScalarResult();
	}

	public function getBookingByRef($ref)
	{
		$qb = $this->createQueryBuilder('b');
		$qb->where('b.bookingRef = :ref')
		   ->setParameter('ref', $ref);

		return $qb->getQuery()->getSingleResult();
		// on pourrais utiliser directement findBy(array...) mais ca renvoi un array et non un objet alors bon..
	}


	public function findBookingByWsHasOfficeId($id)
	{
		$qb = $this->createQueryBuilder('b');
		$qb->where('b.workspacehasoffice = :id')
		   ->setParameter('id', $id);

		return $qb->getQuery()->getSingleResult();
	}
	
	public function findWsBookedByMemberId($id)
	{
		$qb = $this->createQueryBuilder('b');
		$qb->select(['b', 'w.name', 'w.city', 'r.name as region'])
		   ->leftJoin('BecowoMemberBundle:Member', 'm', 'WITH', 'b.member = m')
		   ->leftJoin('BecowoCoreBundle:WorkspaceHasOffice', 'who', 'WITH', 'b.workspacehasoffice = who')
		   ->leftJoin('BecowoCoreBundle:Workspace', 'w', 'WITH', 'who.workspace = w')
		   ->leftJoin('BecowoCoreBundle:Region', 'r', 'WITH', 'w.region = r')
		   ->where('m.id = :id')
		   ->andWhere('w.isDeleted = false')
		   ->andWhere('w.isVisible = true')
		   ->setParameter('id', $id)
		   ->groupBy('w.name') ;

		return $qb->getQuery()->getResult();
	}

	public function findWsByBooking($booking)
	{
		$qb = $this->createQueryBuilder('b');
		$qb->select(['b', 'who', 'w'])
			->Join('b.workspacehasoffice', 'who')
			->Join('who.workspace', 'w')
			->where('b.id = :booking')
			->setParameter('booking', $booking);

		return $qb->getQuery()->getSingleResult();
	}

	public function findBookingByMember($user)
	{
		$qb = $this->createQueryBuilder('b');
		$qb->select(['b', 'who', 'w'])
			->leftJoin('b.workspacehasoffice', 'who')
			->leftJoin('who.workspace', 'w')
			->where('b.member = :user')
			->setParameter('user', $user)
			->orderBy('b.startDate') ;

		return $qb->getQuery()->getResult();
	}

	public function findBookingByWs($ws)
	{
		$qb = $this->createQueryBuilder('b');
		$qb->select(['b', 'who'])
			->leftJoin('b.workspacehasoffice', 'who')
			->where('who.workspace = :ws')
			->setParameter('ws', $ws)
			->orderBy('b.startDate') ;

		return $qb->getQuery()->getResult();
	}

	public function findJsonReservationsByWorkspaceByDates($wsId, $start, $end)
	{
		// PURE SQL

		$sql = "SELECT 
			b.id AS id, 
			who.name AS title,
			DATE_FORMAT(b.start_Date,'%Y-%m-%dT%H:%i') AS start, 
			DATE_FORMAT(b.end_Date,'%Y-%m-%dT%H:%i') AS 'end',
			CASE 
		      WHEN who.office_id = 1 THEN 'openspace'
		      WHEN who.office_id = 2 THEN 'desk'
		      WHEN who.office_id = 3 THEN 'meeting'
		      WHEN who.office_id = 4 THEN 'conference'
		      ELSE ''
		    END AS className,
		    b.duration,
		    b.duration_day,
		    b.price_incl_tax,
		    b.price_excl_tax,
		    b.nb_people,
		    b.message,
		    m.firstname AS memberFirstname,
		    m.name AS memberName,
		    m.email AS memberEmail,
		    m.city AS memberCity,
		    m.id AS memberId,
		    j.name AS memberJob,
		    who.office_id AS officeId
			FROM becowo_booking b
			LEFT JOIN becowo_workspace_has_office who ON who.id = b.WorkspaceHasOffice_id 
			LEFT JOIN becowo_member m ON b.member_id = m.id
			LEFT JOIN becowo_job j ON m.job_id = j.id
			WHERE who.workspace_id = :wsId 
			AND b.start_date BETWEEN :startD AND :endD
			AND b.status_id = 4";

		$params = array('wsId' => $wsId, 'startD' => $start, 'endD' => $end);

		$result = $this->getEntityManager()->getConnection()->executeQuery($sql, $params)->fetchAll();

		return new JsonResponse($result);
	}

}
