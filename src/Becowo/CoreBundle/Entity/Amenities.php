<?php

namespace Becowo\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Amenities
 *
 * @ORM\Table(name="becowo_amenities", uniqueConstraints={@ORM\UniqueConstraint(name="id_UNIQUE", columns={"id"})})
 * @ORM\Entity
 */
class Amenities
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
     * @ORM\Column(name="name", type="string", length=55, nullable=true)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="urlLogo", type="string", length=55, nullable=true)
     */
    private $urlLogo;


    /**
     * Constructor
     */
    public function __construct()
    {
    }


    /**
     * Set name
     *
     * @param string $name
     *
     * @return Amenities
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
     * Set urlLogo
     *
     * @param string $urlLogo
     *
     * @return Amenities
     */
    public function setUrlLogo($urlLogo)
    {
        $this->urlLogo = $urlLogo;

        return $this;
    }

    /**
     * Get urlLogo
     *
     * @return string
     */
    public function getUrlLogo()
    {
        return $this->urlLogo;
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
