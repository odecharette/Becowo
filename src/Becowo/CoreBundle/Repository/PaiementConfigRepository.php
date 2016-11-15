<?php

namespace Becowo\CoreBundle\Repository;

use Doctrine\ORM\EntityRepository;


class PaiementConfigRepository extends EntityRepository
{
	public function findPaiementInfos()
	{
		$qb = $this->createQueryBuilder('p');

		return $qb->getQuery()->getResult();
	}

	

}
