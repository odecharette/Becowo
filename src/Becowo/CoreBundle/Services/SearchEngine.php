<?php

namespace Becowo\CoreBundle\Services;

use Elastica\Query\Match;
use FOS\ElasticaBundle\Finder\FinderInterface;

/**
 * Service pour exécuter des requêtes sur Elastic Search.
 */
class SearchEngine
{
    const MIN_CHAR_MDR_CATEGORIE = 3;
    const LIMIT_MDR_CATEGORIE = 10;

    private $finderWS;

    public function __construct(FinderInterface $finderWS)
    {
        $this->finderWS = $finderWS;
    }

    /**
     * Exécute la recherche sur Elasticsearch pour le moteur de recherche des WS.
     *
     * @param string $recherche Valeur recherchée
     *
     * @return WS[]
     */
    public function rechercheWorkspace($recherche)
    {
        $query = new Match();
        $query->setFieldQuery('name', $recherche);
        $query->setFieldOperator('name', 'AND');
        dump($query);

        return $this->finderWS->find($query, self::LIMIT_MDR_CATEGORIE);
    }
}