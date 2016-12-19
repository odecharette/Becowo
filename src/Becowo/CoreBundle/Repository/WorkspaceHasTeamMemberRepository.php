<?php

namespace Becowo\CoreBundle\Repository;

use Doctrine\ORM\EntityRepository;


class WorkspaceHasTeamMemberRepository extends EntityRepository
{
	public function findWsHasTeamMemberByWorkspace($ws)
	{
		$qb = $this->createQueryBuilder('t');
		$qb->where('t.workspace = :ws')
		   ->setParameter('ws', $ws);

		return $qb->getQuery()->getResult();
	}

	public function findWsHasTeamMemberForEmailBookingByWorkspace($ws)
	{
		$qb = $this->createQueryBuilder('t');
		$qb->select('t')
			->where('t.workspace = :ws')
			->andWhere('t.receiveEmailBooking = 1')
		   ->setParameter('ws', $ws);

		return $qb->getQuery()->getResult();
	}
}
