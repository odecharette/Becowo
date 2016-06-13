<?php

namespace Becowo\CoreBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;


class WorkspaceRepository extends EntityRepository
{
	public function findActiveWorkspaces()
	{
		// Récupère tous les workspace en BDD non supprimés et visibles
		// ds l'ordre de création pour afficher ques les nouveaux qd besoin
		$qb = $this->createQueryBuilder('w');

		$this->whereIsActive($qb);
		$qb->orderBy('w.createdOn', 'DESC');

		return $qb->getQuery()->getResult();
	}

	// public function findNewWorkspaces($nb)
	// {
	// 	// Récupère uniquement les X nouveaux WS actifs
	// 	$qb = $this->createQueryBuilder('w');

	// 	$this->whereIsActive($qb);

	// 	$qb->orderBy('w.createdOn', 'DESC')
	// 		->setFirstResult(0)
	// 		->setMaxResults($nb);

	// 	return $qb->getQuery()->getResult();
	// }

	public function whereIsActive(QueryBuilder $qb)
	{
		// filtre sur les WS actifs uniquement
		$qb->andWhere('w.isDeleted = false')
			->andWhere('w.isVisible = true');
	}


}
