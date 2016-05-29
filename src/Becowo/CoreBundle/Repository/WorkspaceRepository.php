<?php

namespace Becowo\CoreBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;


class WorkspaceRepository extends EntityRepository
{
	public function findActiveWorkspaces()
	{
		// Récupère tous les workspace en BDD non supprimés et visibles
		$qb = $this->createQueryBuilder('w');
		$qb->where('w.isDeleted = false')
			->andWhere('w.isVisible = true');

		return $qb->getQuery()->getResult();
	}
}
