<?php

namespace Becowo\MemberBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query\ResultSetMapping;

class MemberRepository extends EntityRepository
{
	public function findNewMembers($nb)
	{
		// Récupère uniquement les derniers inscrits actifs, non supprimés limité à $nb résultats
		$qb = $this->createQueryBuilder('m');
		$qb->where('m.enabled = true')
			->andWhere('m.isDeleted = false')
			->orderBy('m.createdAt', 'DESC')
			->setFirstResult(0)
			->setMaxResults($nb);

		return $qb->getQuery()->getResult();
	}

	public function findAllActiveMembers()
	{
		$qb = $this->createQueryBuilder('m');
		$qb->where('m.enabled = true')
			->andWhere('m.isDeleted = false')
			->orderBy('m.fillRate', 'desc');

		return $qb->getQuery()->getResult();
	}

	public function findActiveMembersByFillRate($rate)
	{
		$qb = $this->createQueryBuilder('m');
		$qb->where('m.enabled = true')
			->andWhere('m.isDeleted = false')
			->andWhere('m.fillRate >= :rate')
			->setParameter('rate', $rate)
			->orderBy('m.fillRate', 'desc');

		return $qb->getQuery()->getResult();
	}
	public function getAgeByRangeFromMembers()
	{
		$rsm = new ResultSetMapping();
		$sql = "SELECT (case when age > 18 and age <= 24
            	then '18 - 24 ans'
            	when age > 24 and age <= 34
            	then '25 - 34 ans'
            	when age > 34 and age <= 44
            	then '35 - 44 ans'
            	when age > 44
            	then 'Plus de 44 ans'
            	else 'undefined'
         		end) bucket,
       			count(*) AS count
  				FROM(SELECT ABS(FLOOR(DATEDIFF(m.birth_date, NOW()) / 365.25)) AS age FROM Member m) request
				GROUP BY (case when age > 18 and age <= 24
            	then '18 - 24 ans'
            	when age > 24 and age <= 34
            	then '25 - 34 ans'
            	when age > 34 and age <= 44
            	then '35 - 44 ans'
            	when age > 44
            	then 'Plus de 44 ans'
            	else 'undefined'
         		end)";
		$rsm->addScalarResult('bucket', 'bucket');	// colonnes à renvoyer
		$rsm->addScalarResult('count', 'count');

		return $this->getEntityManager()->createNativeQuery($sql, $rsm)->getScalarResult();
	}

	public function getSexFromMembers()
	{
		$rsm = new ResultSetMapping();
		$sql = "SELECT (case when sex = 'F' then 'Femme' 
			when sex = 'H' then 'Homme' 
			else 'undefined' end) sex, 
			count(*) AS count 
			FROM( SELECT sex from Member m) request
			GROUP BY (case when sex = 'F' then 'Femme' 
			when sex = 'H' then 'Homme' 
			else 'undefined' end)";

		$rsm->addScalarResult('sex', 'sex');
		$rsm->addScalarResult('count', 'count');

		return $this->getEntityManager()->createNativeQuery($sql, $rsm)->getScalarResult();
	}
	
	public function findMembersHasNotReceivedMailNewUser()
	{
		$qb = $this->createQueryBuilder('m');
		$qb->select('m')
			->where('m.enabled = true')
			->andWhere('m.isDeleted = false')
			->andWhere('m.hasReceivedEmailNewUser = false');

		return $qb->getQuery()->getResult();
	}

}
