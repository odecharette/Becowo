<?php

namespace Becowo\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * PartnerOffer
 *
 * @ORM\Table(name="becowo_partner_offer", uniqueConstraints={@ORM\UniqueConstraint(name="id_UNIQUE", columns={"id"})}, indexes={@ORM\Index(name="fk_category_id_idx", columns={"category_id"})})
 * @ORM\Entity
 */
class PartnerOffer
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
     * @var \Becowo\CoreBundle\Entity\PartnerOfferCategory
     *
     * @ORM\ManyToOne(targetEntity="Becowo\CoreBundle\Entity\PartnerOfferCategory", fetch="EAGER")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="category_id", referencedColumnName="id")
     * })
     */
    private $category;

    /**
     * @var \Becowo\CoreBundle\Entity\Partner
     *
     * @ORM\ManyToOne(targetEntity="Becowo\CoreBundle\Entity\Partner", fetch="EAGER")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="partner_id", referencedColumnName="id")
     * })
     */
    private $partner;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Becowo\CoreBundle\Entity\WorkspaceHasOffice")
     */
    private $workspaceHasOffice;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=45, nullable=true)
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
     * @ORM\Column(name="url_picture", type="string", length=255, nullable=true)
     *
     */
    private $urlPicture;

    /**
     * @var string
     *
     * @ORM\Column(name="price_excluded_tax", type="decimal", precision=5, scale=2, nullable=true)
     */
    private $priceExcludedTax;

    /**
     * @var boolean
     *
     * @ORM\Column(name="is_price_per_coworker", type="boolean", nullable=true)
     */
    private $isPricePerCoworker;


    public function __construct()
    {
        $this->workspacesHasOffice = new ArrayCollection();
    }

    /**
     * Gets the value of id.
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }


    /**
     * Gets the }).
     *
     * @return \Becowo\CoreBundle\Entity\PartnerOfferCategory
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * Sets the }).
     *
     * @param \Becowo\CoreBundle\Entity\PartnerOfferCategory $category the category
     *
     * @return self
     */
    public function setCategory(\Becowo\CoreBundle\Entity\PartnerOfferCategory $category)
    {
        $this->category = $category;

        return $this;
    }

    /**
     * Gets the }).
     *
     * @return \Becowo\CoreBundle\Entity\Partner
     */
    public function getPartner()
    {
        return $this->partner;
    }

    /**
     * Sets the }).
     *
     * @param \Becowo\CoreBundle\Entity\Partner $partner the partner
     *
     * @return self
     */
    public function setPartner(\Becowo\CoreBundle\Entity\Partner $partner)
    {
        $this->partner = $partner;

        return $this;
    }

    public function addWorkspaceHasOffice(\Becowo\CoreBundle\Entity\WorkspaceHasOffice $who)
    {
        
        $this->workspaceHasOffice[] = $who;
    }

    public function removeWorkspaceHasOffice(\Becowo\CoreBundle\Entity\WorkspaceHasOffice $who)
    {
        $this->workspaceHasOffice->removeElement($who);
    }

    public function getWorkspaceHasOffices()
    {
        return $this->workspaceHasOffice;
    }

    /**
     * Gets the value of name.
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Sets the value of name.
     *
     * @param string $name the name
     *
     * @return self
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Gets the value of description.
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Sets the value of description.
     *
     * @param string $description the description
     *
     * @return self
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Gets the value of urlPicture.
     *
     * @return string
     */
    public function getUrlPicture()
    {
        return $this->urlPicture;
    }

    /**
     * Sets the value of urlPicture.
     *
     * @param string $urlPicture the url picture
     *
     * @return self
     */
    public function setUrlPicture($urlPicture)
    {
        $this->urlPicture = $urlPicture;

        return $this;
    }

    /**
     * Gets the value of priceExcludedTax.
     *
     * @return string
     */
    public function getPriceExcludedTax()
    {
        return $this->priceExcludedTax;
    }

    /**
     * Sets the value of priceExcludedTax.
     *
     * @param string $priceExcludedTax the price excluded tax
     *
     * @return self
     */
    public function setPriceExcludedTax($priceExcludedTax)
    {
        $this->priceExcludedTax = $priceExcludedTax;

        return $this;
    }

    /**
     * Gets the value of isPricePerCoworker.
     *
     * @return boolean
     */
    public function getIsPricePerCoworker()
    {
        return $this->isPricePerCoworker;
    }

    /**
     * Sets the value of isPricePerCoworker.
     *
     * @param boolean $isPricePerCoworker the is price per coworker
     *
     * @return self
     */
    public function setIsPricePerCoworker($isPricePerCoworker)
    {
        $this->isPricePerCoworker = $isPricePerCoworker;

        return $this;
    }
    
    public function __toString()
    {
        return $this->name;
    }
}
