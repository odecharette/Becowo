<?php

namespace Becowo\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Offer
 *
 * @ORM\Table(name="offer", uniqueConstraints={@ORM\UniqueConstraint(name="id_UNIQUE", columns={"id"})})
 * @ORM\Entity
 */
class Offer
{
    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=55, nullable=true)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text", nullable=true)
     */
    private $description;

    /**
     * @var string
     *
     * @ORM\Column(name="commission", type="decimal", precision=3, scale=2, nullable=true)
     */
    private $commission;

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
     * @ORM\ManyToMany(targetEntity="Becowo\CoreBundle\Entity\Workspace", mappedBy="offer")
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
     * @return Offer
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
     * Set description
     *
     * @param string $description
     *
     * @return Offer
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set commission
     *
     * @param string $commission
     *
     * @return Offer
     */
    public function setCommission($commission)
    {
        $this->commission = $commission;

        return $this;
    }

    /**
     * Get commission
     *
     * @return string
     */
    public function getCommission()
    {
        return $this->commission;
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
     * @return Offer
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