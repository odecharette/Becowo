<?php

namespace Becowo\CoreBundle\Repository;

use Doctrine\ORM\EntityRepository;

class WorkspaceHasOfficeRepository extends EntityRepository
{
	
	public function findOfficeOfWorkspaceByWsOfficeName($ws, $office, $name)
	{
		$qb = $this->createQueryBuilder('o');
		$qb->where('o.name = :name')
		   ->andWhere('o.workspace = :ws')
		   ->andWhere('o.office = :office')
		   ->setParameter('name', $name)
		   ->setParameter('ws', $ws)
		   ->setParameter('office', $office);

		return $qb->getQuery()->getSingleResult();
	}
	
	public function findWsHasOfficeById($id)
	{
		$qb = $this->createQueryBuilder('o');
		$qb->where('o.id = :id')
		   ->setParameter('id', $id);

		return $qb->getQuery()->getSingleResult();
	}

}
