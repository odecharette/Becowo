<?php

namespace Becowo\CoreBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;


class PictureRepository extends EntityRepository
{
	
	public function findByWsNoLogo($wsName)
	{
		//retourne toutes les pictures d'un WS mais sans les logos

		$qb = $this->createQueryBuilder('p');

		$qb->leftJoin('p.workspace', 'w')
			->where('w.name = :name')
			->andWhere('p.isLogo = false')
			->setParameter('name', $wsName);

		return $qb->getQuery()->getResult();
	}
}
