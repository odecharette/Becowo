<?php

namespace Becowo\CoreBundle\Repository;

use Doctrine\ORM\EntityRepository;


class PartnerOfferRepository extends EntityRepository
{
	public function findPartnerOffersByWorkspace($ws)
	{
		// QueryBuilder avec une relation manyToMany sur workspace
		// https://openclassrooms.com/forum/sujet/symfony2-querybuilder-et-jointure-manytomany

		$qb = $this->createQueryBuilder('po');
		$qb->select('po')
			->join('po.workspace', 'w')
			->addSelect('w')
			->where('w = :ws')
            ->setParameter('ws', $ws);

		return $qb->getQuery()->getResult();
	}

	public function findCountPartnerOffersByWorkspace($ws)
	{
		// QueryBuilder avec une relation manyToMany sur workspace
		// https://openclassrooms.com/forum/sujet/symfony2-querybuilder-et-jointure-manytomany
		
		$qb = $this->createQueryBuilder('po');
		$qb->select('count(po) AS nb')
			->join('po.workspace', 'w')
			->where('w = :ws')
            ->setParameter('ws', $ws);

		return $qb->getQuery()->getSingleScalarResult();
	}


}
