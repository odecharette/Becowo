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

}
