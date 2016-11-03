<?php

namespace Becowo\CoreBundle\Repository;

use Doctrine\ORM\EntityRepository;


class TimetableRepository extends EntityRepository
{
	public function findOpenCloseHoursByWorkspaces($ws)
	{
		$qb = $this->createQueryBuilder('t');
		$qb->select('t.openHour AS openHour', 't.closeHour AS closeHour')
		   ->where('t.workspace = :ws')
		   ->setParameter('ws', $ws);

		return $qb->getQuery()->getResult();
	}
}
