<?php

namespace Becowo\MemberBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;


class MemberRepository extends EntityRepository
{
	public function findNewMembers($nb)
	{
		// Récupère uniquement les derniers inscrits actifs, non supprimés limité à $nb résultats
		$qb = $this->createQueryBuilder('m');
		$qb->where('m.enabled = true')
			->andWhere('m.isDeleted = false')
			->orderBy('m.createdAt', 'DESC')
			->setFirstResult(0)
			->setMaxResults($nb);

		return $qb->getQuery()->getResult();
	}
	
}
