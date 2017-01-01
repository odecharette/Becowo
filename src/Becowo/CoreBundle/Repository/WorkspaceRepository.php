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

	public function findActiveWorkspacesOrderByVoteAvg()
	{
		$qb = $this->createQueryBuilder('w')
					->select('w')
					->from('BecowoCoreBundle:Comment', 'c')
					->leftJoin('c.workspace', 'score')
					->andWhere('c.workspace = w.id')
					->groupBy('w.name')
					->orderBy('c.scoreAvg', 'DESC');
			$this->whereIsActive($qb);

		return $qb->getQuery()->getResult();
	}

	public function whereIsActive(QueryBuilder $qb)
	{
		// filtre sur les WS actifs uniquement
		$qb->andWhere('w.isDeleted = false')
			->andWhere('w.isVisible = true');
	}


}
