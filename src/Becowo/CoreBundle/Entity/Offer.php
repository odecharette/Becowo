<?php

namespace Becowo\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Algolia\AlgoliaSearchBundle\Mapping\Annotation as Algolia;

/**
 * Offer
 *
 * @ORM\Table(name="becowo_offer", uniqueConstraints={@ORM\UniqueConstraint(name="id_UNIQUE", columns={"id"})})
 * @ORM\Entity
 */
class Offer
{
    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=55, nullable=true)
     * @Algolia\Attribute
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
     * @ORM\Column(name="priority_index", type="integer", nullable=true)
     * @Algolia\Attribute
     */
    private $priorityIndex;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;


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
     * Gets the value of priorityIndex.
     *
     * @return integer
     */
    public function getPriorityIndex()
    {
        return $this->priorityIndex;
    }

    /**
     * Sets the value of priorityIndex.
     *
     * @param integer $priorityIndex the priority index
     *
     * @return self
     */
    public function setPriorityIndex($priorityIndex)
    {
        $this->priorityIndex = $priorityIndex;

        return $this;
    }

    
    public function __toString()
    {
        return $this->name;
    }
}
