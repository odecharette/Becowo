<?php

namespace Becowo\CoreBundle\Repository;

use Doctrine\ORM\EntityRepository;


class EventRepository extends EntityRepository
{
	public function findListOfWsWithEvents()
	{
		$qb = $this->createQueryBuilder('e');
		$qb->select('w.name, w.city')
			->leftJoin('BecowoCoreBundle:Workspace', 'w', 'WITH', 'w = e.workspace')
			->andWhere('w.isDeleted = false')
			->andWhere('w.isVisible = true')
            ->andWhere('e.startDate >= :today')
			->orderBy('w.name', 'ASC')
			->distinct('w.name')
            ->setParameter('today', date("Y-m-d"));

		return $qb->getQuery()->getResult();
	}

	public function findFuturEventsByWorkspaceOrderByDate($ws)
	{
		$qb = $this->createQueryBuilder('e');
		$qb->select('e')
			->leftJoin('BecowoCoreBundle:Workspace', 'w', 'WITH', 'w = e.workspace')
			->andWhere('w = :ws')
            ->andWhere('e.startDate >= :today')
			->orderBy('e.startDate', 'ASC')
			->setParameter('ws', $ws)
            ->setParameter('today', date("Y-m-d"));

		return $qb->getQuery()->getResult();
	}

}
