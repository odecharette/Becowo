<?php

namespace Becowo\CoreBundle\Repository;

use Doctrine\ORM\EntityRepository;


class ErrorCodesRepository extends EntityRepository
{
	public function findErrorByCode($code)
	{
		$qb = $this->createQueryBuilder('e');
		$qb->where('e.errorCode = :code')
		   ->setParameter('code', $code);

		return $qb->getQuery()->getSingleResult();
		// on pourrais utiliser directement findBy(array...) mais ca renvoi un array et non un objet alors bon..
	}
}
