<?php

namespace Becowo\CoreBundle\Repository;

use Doctrine\ORM\EntityRepository;


class CommentRepository extends EntityRepository
{
	public function findLastCommentsAndAuthor($nb)
	{
		$qb = $this->createQueryBuilder('c');
		$qb->select('c as comments', 'v.scoreAvg')
			->leftJoin('c.member', 'm')
			->leftJoin('c.workspace', 'w')
			->join('BecowoCoreBundle:Vote', 'v', 'WITH', 'v.member = c.member')
			->andWhere('v.workspace = w')
			->orderBy('c.postedOn', 'DESC')
			->setFirstResult(0)
			->setMaxResults($nb);

		return $qb->getQuery()->getResult();
	}

	public function getMemberCommentForWorkspace($ws, $member)
	{
		$qb = $this->createQueryBuilder('c');
		$qb->where('c.workspace = :ws')
			->andWhere('c.member = :member')
			->setParameter('ws', $ws)
			->setParameter('member', $member);

		return $qb->getQuery()->getResult();
	}

	public function getAverage($ws)
	{
		$qb = $this->createQueryBuilder('c');
		$qb->select('AVG(c.scoreAvg) AS Average')
			->where('c.workspace = :ws')
			->setParameter('ws', $ws);

		return $qb->getQuery()->getSingleScalarResult();
	}

	public function getAverageScore1($ws)
	{
		$qb = $this->createQueryBuilder('c');
		$qb->select('AVG(c.score1) AS Average')
			->where('c.workspace = :ws')
			->setParameter('ws', $ws);

		return $qb->getQuery()->getSingleScalarResult();
	}

	public function getAverageScore2($ws)
	{
		$qb = $this->createQueryBuilder('c');
		$qb->select('AVG(c.score2) AS Average')
			->where('c.workspace = :ws')
			->setParameter('ws', $ws);

		return $qb->getQuery()->getSingleScalarResult();
	}

	public function getAverageScore3($ws)
	{
		$qb = $this->createQueryBuilder('c');
		$qb->select('AVG(c.score3) AS Average')
			->where('c.workspace = :ws')
			->setParameter('ws', $ws);

		return $qb->getQuery()->getSingleScalarResult();
	}

	public function getAverageScore4($ws)
	{
		$qb = $this->createQueryBuilder('c');
		$qb->select('AVG(c.score4) AS Average')
			->where('c.workspace = :ws')
			->setParameter('ws', $ws);

		return $qb->getQuery()->getSingleScalarResult();
	}

	public function getVotesByWorkspace($ws)
	{
		$qb = $this->createQueryBuilder('c');
		$qb->where('c.workspace = :ws')
			->setParameter('ws', $ws);

		return $qb->getQuery()->getResult();
	}

}
