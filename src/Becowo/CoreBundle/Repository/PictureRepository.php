<?php

namespace Becowo\CoreBundle\Repository;

use Doctrine\ORM\EntityRepository;


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

	public function findByWsFavorite($wsName)
	{
		//retourne la picture favorite d'un WS

		$qb = $this->createQueryBuilder('p');

		$qb->leftJoin('p.workspace', 'w')
			->where('w.name = :name')
			->andWhere('p.isFavorite = true')
			->setParameter('name', $wsName);

		return $qb->getQuery()->getResult();
	}

	public function findByWsLogo($wsName)
	{
		//retourne le logo d'un WS

		$qb = $this->createQueryBuilder('p');

		$qb->leftJoin('p.workspace', 'w')
			->where('w.name = :name')
			->andWhere('p.isLogo = true')
			->setParameter('name', $wsName);

		return $qb->getQuery()->getResult();
	}
}
