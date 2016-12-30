<?php

namespace Becowo\CoreBundle\Repository;

use Doctrine\ORM\EntityRepository;


class PriceRepository extends EntityRepository
{
	public function findPricesByWorkspace($ws)
	{
		$qb = $this->createQueryBuilder('p');
		$qb->select('p, w')
		   ->Join('p.workspaceHasOffice', 'w')
		   ->where('w.workspace = :ws')
		   ->setParameter('ws', $ws);

		return $qb->getQuery()->getResult();
	}


	public function findPricesByWsHasOfficeId($id)
	{
		$qb = $this->createQueryBuilder('p');
		$qb->where('p.workspaceHasOffice = :id')
		   ->setParameter('id', $id);

		return $qb->getQuery()->getResult();
	}

}
