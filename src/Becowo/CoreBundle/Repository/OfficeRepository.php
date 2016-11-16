<?php

namespace Becowo\CoreBundle\Repository;

use Doctrine\ORM\EntityRepository;

class OfficeRepository extends EntityRepository
{
	
	public function findOfficeByName($name)
	{
		$qb = $this->createQueryBuilder('o');
		$qb->where('o.name = :name')
		   ->setParameter('name', $name);

		return $qb->getQuery()->getSingleResult();
		//getSingleResult renvoi un objet alors que getScalarResult renvoi un array !
	}
	
}
