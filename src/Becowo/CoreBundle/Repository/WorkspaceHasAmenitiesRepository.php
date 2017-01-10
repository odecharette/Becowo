<?php

namespace Becowo\CoreBundle\Repository;

use Doctrine\ORM\EntityRepository;

class WorkspaceHasAmenitiesRepository extends EntityRepository
{
	
	public function findAmenitiesByWorkspace($ws)
	{
		$qb = $this->createQueryBuilder('wha');
		$qb->select(['wha', 'a'])
			->join('wha.amenities', 'a')
			->where('wha.workspace = :ws')
		   ->setParameter('ws', $ws);

		return $qb->getQuery()->getResult();
	}	



}
