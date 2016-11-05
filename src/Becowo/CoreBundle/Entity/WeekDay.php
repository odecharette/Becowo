<?php

namespace Becowo\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * WeekDay
 *
 * @ORM\Table(name="becowo_week_day", uniqueConstraints={@ORM\UniqueConstraint(name="id_UNIQUE", columns={"id"})})
 * @ORM\Entity
 */
class WeekDay
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
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=8, nullable=false)
     */
    private $name;

    /**
     * @var boolean
     *
     * @ORM\Column(name="is_weekend", type="boolean", nullable=false)
     */
    private $isWeekend;



    /**
     * Set name
     *
     * @param string $name
     *
     * @return WeekDay
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set isWeekend
     *
     * @param boolean $isWeekend
     *
     * @return WeekDay
     */
    public function setIsWeekend($isWeekend)
    {
        $this->isWeekend = $isWeekend;

        return $this;
    }

    /**
     * Get isWeekend
     *
     * @return boolean
     */
    public function getIsWeekend()
    {
        return $this->isWeekend;
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

    public function __toString()
    {
        return $this->name;
    }
}
