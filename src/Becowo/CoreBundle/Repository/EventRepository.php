<?php

namespace Becowo\CoreBundle\Repository;

use Doctrine\ORM\EntityRepository;


class EventRepository extends EntityRepository
{
	public function findListOfWsWithEvents()
	{
		$qb = $this->createQueryBuilder('e');
		$qb->select('w.name')
			->leftJoin('BecowoCoreBundle:Workspace', 'w', 'WITH', 'w = e.workspace')
			->andWhere('w.isDeleted = false')
			->andWhere('w.isVisible = true')
			->orderBy('w.name', 'ASC')
			->distinct('w.name');

		return $qb->getQuery()->getResult();
	}

}
