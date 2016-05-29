<?php

namespace Becowo\CoreBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;


class MemberRepository extends EntityRepository
{
	public function findNewMembers($nb)
	{
		// Récupère uniquement les derniers inscrits actifs, non supprimés limité à $nb résultats
		$qb = $this->createQueryBuilder('m');
		$qb->where('m.isActivated = true')
			->andWhere('m.isDeleted = false')
			->orderBy('m.createdOn', 'DESC')
			->setFirstResult(0)
			->setMaxResults($nb);

		return $qb->getQuery()->getResult();
	}
	
}
