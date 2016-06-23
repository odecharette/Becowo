<?php

namespace Becowo\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * DistanceSearch
 *
 * @ORM\Table(name="distance_search", uniqueConstraints={@ORM\UniqueConstraint(name="id_UNIQUE", columns={"id"})})
 * @ORM\Entity
 */
class DistanceSearch
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var integer
     *
     * @ORM\Column(name="distance", type="integer", nullable=true)
     */
    private $distance;

    /**
     * @var string
     *
     * @ORM\Column(name="unit", type="string", length=5, nullable=true)
     */
    private $unit;



    /**
     * Set distance
     *
     * @param integer $distance
     *
     * @return DistanceSearch
     */
    public function setDistance($distance)
    {
        $this->distance = $distance;

        return $this;
    }

    /**
     * Get distance
     *
     * @return integer
     */
    public function getDistance()
    {
        return $this->distance;
    }

    /**
     * Set unit
     *
     * @param string $unit
     *
     * @return DistanceSearch
     */
    public function setUnit($unit)
    {
        $this->unit = $unit;

        return $this;
    }

    /**
     * Get unit
     *
     * @return string
     */
    public function getUnit()
    {
        return $this->unit;
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }
}
