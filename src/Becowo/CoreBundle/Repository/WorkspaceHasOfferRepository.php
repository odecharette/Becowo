<?php

namespace Becowo\CoreBundle\Repository;

use Doctrine\ORM\EntityRepository;

class WorkspaceHasOfferRepository extends EntityRepository
{
	
	public function findOffersByWorkspace($ws)
	{
		$qb = $this->createQueryBuilder('o');
		$qb->where('o.workspace = :ws')
		   ->setParameter('ws', $ws);

		return $qb->getQuery()->getResult();
	}	



}
