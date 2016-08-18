<?php

namespace Becowo\CoreBundle\Repository;

use Doctrine\ORM\EntityRepository;


class VoteRepository extends EntityRepository
{
	public function getAverage($ws)
	{
		$qb = $this->createQueryBuilder('v');
		$qb->select('AVG(v.scoreAvg) AS Average')
			->where('v.workspace = :ws')
			->setParameter('ws', $ws);

		return $qb->getQuery()->getSingleScalarResult();
	}

	public function getVotesByWorkspace($ws)
	{
		$qb = $this->createQueryBuilder('v');
		$qb->where('v.workspace = :ws')
			->setParameter('ws', $ws);

		return $qb->getQuery()->getResult();
	}

	public function getMemberVoteForWorkspace($ws, $member)
	{
		$qb = $this->createQueryBuilder('v');
		$qb->where('v.workspace = :ws')
			->andWhere('v.member = :member')
			->setParameter('ws', $ws)
			->setParameter('member', $member);

		return $qb->getQuery()->getResult();
	}
}
