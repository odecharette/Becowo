<?php

namespace Becowo\CoreBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query\ResultSetMapping;

class VoteRepository extends EntityRepository
{
	

	

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
