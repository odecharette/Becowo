<?php

namespace Becowo\CoreBundle\Repository;

use Doctrine\ORM\EntityRepository;


class StatusRepository extends EntityRepository
{
	public function findStatusById($id)
	{
		$qb = $this->createQueryBuilder('s');
		$qb->where('s.id = :id')
		   ->setParameter('id', $id);

		return $qb->getQuery()->getSingleResult();
		// on pourrais utiliser directement findBy(array...) mais ca renvoi un array et non un objet alors bon..
	}
	
	
}
