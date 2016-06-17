<?php

namespace Becowo\CoreBundle\Repository;

use Doctrine\ORM\EntityRepository;


class PoiRepository extends EntityRepository
{
	public function findPoiWithCategory()
	{
		$qb = $this->createQueryBuilder('p');

		$qb->leftJoin('p.poiCategory', 'c');
			//->where('p.id < 20');

		return $qb->getQuery()->getResult();
	}
}
