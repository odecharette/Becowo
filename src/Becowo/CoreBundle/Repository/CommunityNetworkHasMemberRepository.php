<?php

namespace Becowo\CoreBundle\Repository;

use Doctrine\ORM\EntityRepository;


class CommunityNetworkHasMemberRepository extends EntityRepository
{
	public function findMembersByNetworkId($idCommunity)
	{
		$qb = $this->createQueryBuilder('chm');
		$qb->select('m')
			->leftJoin('BecowoMemberBundle:Member', 'm', 'WITH', 'm = chm.member')
			->leftJoin('BecowoCoreBundle:communityNetwork', 'c', 'WITH', 'c = chm.communityNetwork')
			->andWhere('c.id = :idCommunity')
			->setParameter('idCommunity', $idCommunity)
			->orderBy('c.name', 'ASC')
			->distinct('c.name');

		return $qb->getQuery()->getResult();
	}

	public function findMembersByNetworkName($network)
	{
		$qb = $this->createQueryBuilder('chm');
		$qb->select('m')
			->leftJoin('BecowoMemberBundle:Member', 'm', 'WITH', 'm = chm.member')
			->leftJoin('BecowoCoreBundle:communityNetwork', 'c', 'WITH', 'c = chm.communityNetwork')
			->andWhere('c.name = :network')
			->setParameter('network', $network);

		return $qb->getQuery()->getResult();
	}
}
