<?php

namespace Becowo\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Amenities
 *
 * @ORM\Table(name="amenities", uniqueConstraints={@ORM\UniqueConstraint(name="id_UNIQUE", columns={"id"})})
 * @ORM\Entity
 */
class Amenities
{
    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=55, nullable=true)
     */
    private $name;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Becowo\CoreBundle\Entity\Workspace", mappedBy="amenities")
     */
    private $workspace;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->workspace = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Add workspace
     *
     * @param \Becowo\CoreBundle\Entity\Workspace $workspace
     *
     * @return Amenities
     */
    public function addWorkspace(\Becowo\CoreBundle\Entity\Workspace $workspace)
    {
        $this->workspace[] = $workspace;

        return $this;
    }

    /**
     * Remove workspace
     *
     * @param \Becowo\CoreBundle\Entity\Workspace $workspace
     */
    public function removeWorkspace(\Becowo\CoreBundle\Entity\Workspace $workspace)
    {
        $this->workspace->removeElement($workspace);
    }

    /**
     * Get workspace
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getWorkspace()
    {
        return $this->workspace;
    }
}
