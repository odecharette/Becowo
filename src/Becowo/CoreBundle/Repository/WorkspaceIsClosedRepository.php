<?php

namespace Becowo\CoreBundle\Repository;

use Doctrine\ORM\EntityRepository;


class WorkspaceIsClosedRepository extends EntityRepository
{
	public function findClosedDatesByWorkspaces($ws)
	{
		$qb = $this->createQueryBuilder('w');
		$qb->where('w.workspace = :ws')
		   ->setParameter('ws', $ws);

		return $qb->getQuery()->getResult();
	}
}
