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
		$qb = $this->createQueryBuilder('w');

		$this->whereIsActive($qb);
		$qb->orderBy('w.voteAverage', 'DESC');

		return $qb->getQuery()->getResult();
	}

	public function whereIsActive(QueryBuilder $qb)
	{
		// filtre sur les WS actifs uniquement
		$qb->andWhere('w.isDeleted = false')
			->andWhere('w.isVisible = true');
	}

	public function findWsByWsNetwork($network, $name)
	{
		$qb = $this->createQueryBuilder('w')
			->andWhere('w.network = :network')
			->andWhere('w.name != :name')
			->setParameter('network', $network)
			->setParameter('name', $name);
		$this->whereIsActive($qb);

		return $qb->getQuery()->getResult();
	}

	public function findListOfActiveCities()
	{
		$qb = $this->createQueryBuilder('w')
			->select('DISTINCT w.city as cities');
		$this->whereIsActive($qb);

		return $qb->getQuery()->getResult();
	}

}
