<?php

namespace Becowo\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Workspace
 *
 * @ORM\Table(name="workspace", uniqueConstraints={@ORM\UniqueConstraint(name="id_UNIQUE", columns={"id"})}, indexes={@ORM\Index(name="fk_country_id_idx", columns={"country_id"}), @ORM\Index(name="fk_category_id_idx", columns={"category_id"})})
 * @ORM\Entity(repositoryClass="Becowo\CoreBundle\Repository\WorkspaceRepository")
 */
class Workspace
{
    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255, nullable=false)
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
     * @ORM\Column(name="description_bonus", type="string", length=255, nullable=true)
     */
    private $descriptionBonus;

    /**
     * @var string
     *
     * @ORM\Column(name="website", type="string", length=255, nullable=true)
     */
    private $website;

    /**
     * @var boolean
     *
     * @ORM\Column(name="is_always_open", type="boolean", nullable=true)
     */
    private $isAlwaysOpen;

    /**
     * @var string
     *
     * @ORM\Column(name="street", type="text", nullable=true)
     */
    private $street;

    /**
     * @var string
     *
     * @ORM\Column(name="post_code", type="string", length=5, nullable=true)
     */
    private $postCode;

    /**
     * @var string
     *
     * @ORM\Column(name="city", type="string", length=50, nullable=true)
     */
    private $city;

    /**
     * @var float
     *
     * @ORM\Column(name="longitude", type="float", precision=10, scale=0, nullable=true)
     */
    private $longitude;

    /**
     * @var float
     *
     * @ORM\Column(name="latitude", type="float", precision=10, scale=0, nullable=true)
     */
    private $latitude;

    /**
     * @var boolean
     *
     * @ORM\Column(name="first_booking_free", type="boolean", nullable=true)
     */
    private $firstBookingFree;

    /**
     * @var string
     *
     * @ORM\Column(name="facebook_link", type="string", length=255, nullable=true)
     */
    private $facebookLink;

    /**
     * @var string
     *
     * @ORM\Column(name="twitter_link", type="string", length=255, nullable=true)
     */
    private $twitterLink;

    /**
     * @var string
     *
     * @ORM\Column(name="instagram_link", type="string", length=255, nullable=true)
     */
    private $instagramLink;

    /**
     * @var boolean
     *
     * @ORM\Column(name="is_deleted", type="boolean", nullable=false)
     */
    private $isDeleted;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_on", type="datetime")
     */
    private $createdOn;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="updated_on", type="datetime", nullable=true)
     */
    private $updatedOn;

    /**
     * @var boolean
     *
     * @ORM\Column(name="is_visible", type="boolean", nullable=false)
     */
    private $isVisible;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var \Becowo\CoreBundle\Entity\WorkspaceCategory
     *
     * @ORM\ManyToOne(targetEntity="Becowo\CoreBundle\Entity\WorkspaceCategory")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="category_id", referencedColumnName="id")
     * })
     */
    private $category;

    /**
     * @var \Becowo\CoreBundle\Entity\Country
     *
     * @ORM\ManyToOne(targetEntity="Becowo\CoreBundle\Entity\Country")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="country_id", referencedColumnName="id")
     * })
     */
    private $country;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Becowo\CoreBundle\Entity\Poi", inversedBy="workspace")
     * @ORM\JoinTable(name="workspace_has_poi",
     *   joinColumns={
     *     @ORM\JoinColumn(name="workspace_id", referencedColumnName="id")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="poi_id", referencedColumnName="id")
     *   }
     * )
     */
    private $poi;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Becowo\CoreBundle\Entity\TeamMember", inversedBy="workspace")
     * @ORM\JoinTable(name="workspace_has_team_member",
     *   joinColumns={
     *     @ORM\JoinColumn(name="workspace_id", referencedColumnName="id")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="team_member_id", referencedColumnName="id")
     *   }
     * )
     */
    private $teamMember;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Becowo\CoreBundle\Entity\Amenities", inversedBy="workspace")
     * @ORM\JoinTable(name="workspace_has_amenities",
     *   joinColumns={
     *     @ORM\JoinColumn(name="workspace_id", referencedColumnName="id")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="amenities_id", referencedColumnName="id")
     *   }
     * )
     */
    private $amenities;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Becowo\MemberBundle\Entity\Member", mappedBy="workspace")
     */
    private $member;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Becowo\CoreBundle\Entity\Offer", inversedBy="workspace")
     * @ORM\JoinTable(name="workspace_has_offer",
     *   joinColumns={
     *     @ORM\JoinColumn(name="workspace_id", referencedColumnName="id")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="offer_id", referencedColumnName="id")
     *   }
     * )
     */
    private $offer;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->poi = new \Doctrine\Common\Collections\ArrayCollection();
        $this->teamMember = new \Doctrine\Common\Collections\ArrayCollection();
       // $this->office = new \Doctrine\Common\Collections\ArrayCollection();
        $this->amenities = new \Doctrine\Common\Collections\ArrayCollection();
        $this->member = new \Doctrine\Common\Collections\ArrayCollection();
        $this->offer = new \Doctrine\Common\Collections\ArrayCollection();
        $this->createdOn = new \DateTime();
    }


    /**
     * Set name
     *
     * @param string $name
     *
     * @return Workspace
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
     * @return Workspace
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
     * Set descriptionBonus
     *
     * @param string $descriptionBonus
     *
     * @return Workspace
     */
    public function setDescriptionBonus($descriptionBonus)
    {
        $this->descriptionBonus = $descriptionBonus;

        return $this;
    }

    /**
     * Get descriptionBonus
     *
     * @return string
     */
    public function getDescriptionBonus()
    {
        return $this->descriptionBonus;
    }

    /**
     * Set website
     *
     * @param string $website
     *
     * @return Workspace
     */
    public function setWebsite($website)
    {
        $this->website = $website;

        return $this;
    }

    /**
     * Get website
     *
     * @return string
     */
    public function getWebsite()
    {
        return $this->website;
    }

    /**
     * Set isAlwaysOpen
     *
     * @param boolean $isAlwaysOpen
     *
     * @return Workspace
     */
    public function setIsAlwaysOpen($isAlwaysOpen)
    {
        $this->isAlwaysOpen = $isAlwaysOpen;

        return $this;
    }

    /**
     * Get isAlwaysOpen
     *
     * @return boolean
     */
    public function getIsAlwaysOpen()
    {
        return $this->isAlwaysOpen;
    }

    /**
     * Set street
     *
     * @param string $street
     *
     * @return Workspace
     */
    public function setStreet($street)
    {
        $this->street = $street;

        return $this;
    }

    /**
     * Get street
     *
     * @return string
     */
    public function getStreet()
    {
        return $this->street;
    }

    /**
     * Set postCode
     *
     * @param string $postCode
     *
     * @return Workspace
     */
    public function setPostCode($postCode)
    {
        $this->postCode = $postCode;

        return $this;
    }

    /**
     * Get postCode
     *
     * @return string
     */
    public function getPostCode()
    {
        return $this->postCode;
    }

    /**
     * Set city
     *
     * @param string $city
     *
     * @return Workspace
     */
    public function setCity($city)
    {
        $this->city = $city;

        return $this;
    }

    /**
     * Get city
     *
     * @return string
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * Set longitude
     *
     * @param float $longitude
     *
     * @return Workspace
     */
    public function setLongitude($longitude)
    {
        $this->longitude = $longitude;

        return $this;
    }

    /**
     * Get longitude
     *
     * @return float
     */
    public function getLongitude()
    {
        return $this->longitude;
    }

    /**
     * Set latitude
     *
     * @param float $latitude
     *
     * @return Workspace
     */
    public function setLatitude($latitude)
    {
        $this->latitude = $latitude;

        return $this;
    }

    /**
     * Get latitude
     *
     * @return float
     */
    public function getLatitude()
    {
        return $this->latitude;
    }

    /**
     * Set firstBookingFree
     *
     * @param boolean $firstBookingFree
     *
     * @return Workspace
     */
    public function setFirstBookingFree($firstBookingFree)
    {
        $this->firstBookingFree = $firstBookingFree;

        return $this;
    }

    /**
     * Get firstBookingFree
     *
     * @return boolean
     */
    public function getFirstBookingFree()
    {
        return $this->firstBookingFree;
    }

    /**
     * Set facebookLink
     *
     * @param string $facebookLink
     *
     * @return Workspace
     */
    public function setFacebookLink($facebookLink)
    {
        $this->facebookLink = $facebookLink;

        return $this;
    }

    /**
     * Get facebookLink
     *
     * @return string
     */
    public function getFacebookLink()
    {
        return $this->facebookLink;
    }

    /**
     * Set twitterLink
     *
     * @param string $twitterLink
     *
     * @return Workspace
     */
    public function setTwitterLink($twitterLink)
    {
        $this->twitterLink = $twitterLink;

        return $this;
    }

    /**
     * Get twitterLink
     *
     * @return string
     */
    public function getTwitterLink()
    {
        return $this->twitterLink;
    }

    /**
     * Set instagramLink
     *
     * @param string $instagramLink
     *
     * @return Workspace
     */
    public function setInstagramLink($instagramLink)
    {
        $this->instagramLink = $instagramLink;

        return $this;
    }

    /**
     * Get instagramLink
     *
     * @return string
     */
    public function getInstagramLink()
    {
        return $this->instagramLink;
    }

    /**
     * Set isDeleted
     *
     * @param boolean $isDeleted
     *
     * @return Workspace
     */
    public function setIsDeleted($isDeleted)
    {
        $this->isDeleted = $isDeleted;

        return $this;
    }

    /**
     * Get isDeleted
     *
     * @return boolean
     */
    public function getIsDeleted()
    {
        return $this->isDeleted;
    }

    /**
     * Set createdOn
     *
     * @param \DateTime $createdOn
     *
     * @return Workspace
     */
    public function setCreatedOn($createdOn)
    {
        $this->createdOn = $createdOn;

        return $this;
    }

    /**
     * Get createdOn
     *
     * @return \DateTime
     */
    public function getCreatedOn()
    {
        return $this->createdOn;
    }

    /**
     * Set updatedOn
     *
     * @param \DateTime $updatedOn
     *
     * @return Workspace
     */
    public function setUpdatedOn($updatedOn)
    {
        $this->updatedOn = $updatedOn;

        return $this;
    }

    /**
     * Get updatedOn
     *
     * @return \DateTime
     */
    public function getUpdatedOn()
    {
        return $this->updatedOn;
    }

    /**
     * Set isVisible
     *
     * @param boolean $isVisible
     *
     * @return Workspace
     */
    public function setIsVisible($isVisible)
    {
        $this->isVisible = $isVisible;

        return $this;
    }

    /**
     * Get isVisible
     *
     * @return boolean
     */
    public function getIsVisible()
    {
        return $this->isVisible;
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
     * Set category
     *
     * @param \Becowo\CoreBundle\Entity\WorkspaceCategory $category
     *
     * @return Workspace
     */
    public function setCategory(\Becowo\CoreBundle\Entity\WorkspaceCategory $category = null)
    {
        $this->category = $category;

        return $this;
    }

    /**
     * Get category
     *
     * @return \Becowo\CoreBundle\Entity\WorkspaceCategory
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * Set country
     *
     * @param \Becowo\CoreBundle\Entity\Country $country
     *
     * @return Workspace
     */
    public function setCountry(\Becowo\CoreBundle\Entity\Country $country = null)
    {
        $this->country = $country;

        return $this;
    }

    /**
     * Get country
     *
     * @return \Becowo\CoreBundle\Entity\Country
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * Add poi
     *
     * @param \Becowo\CoreBundle\Entity\Poi $poi
     *
     * @return Workspace
     */
    public function addPoi(\Becowo\CoreBundle\Entity\Poi $poi)
    {
        $this->poi[] = $poi;

        return $this;
    }

    /**
     * Remove poi
     *
     * @param \Becowo\CoreBundle\Entity\Poi $poi
     */
    public function removePoi(\Becowo\CoreBundle\Entity\Poi $poi)
    {
        $this->poi->removeElement($poi);
    }

    /**
     * Get poi
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPoi()
    {
        return $this->poi;
    }

    /**
     * Add teamMember
     *
     * @param \Becowo\CoreBundle\Entity\TeamMember $teamMember
     *
     * @return Workspace
     */
    public function addTeamMember(\Becowo\CoreBundle\Entity\TeamMember $teamMember)
    {
        $this->teamMember[] = $teamMember;

        return $this;
    }

    /**
     * Remove teamMember
     *
     * @param \Becowo\CoreBundle\Entity\TeamMember $teamMember
     */
    public function removeTeamMember(\Becowo\CoreBundle\Entity\TeamMember $teamMember)
    {
        $this->teamMember->removeElement($teamMember);
    }

    /**
     * Get teamMember
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getTeamMember()
    {
        return $this->teamMember;
    }

    /**
     * Add amenity
     *
     * @param \Becowo\CoreBundle\Entity\Amenities $amenity
     *
     * @return Workspace
     */
    public function addAmenity(\Becowo\CoreBundle\Entity\Amenities $amenity)
    {
        $this->amenities[] = $amenity;

        return $this;
    }

    /**
     * Remove amenity
     *
     * @param \Becowo\CoreBundle\Entity\Amenities $amenity
     */
    public function removeAmenity(\Becowo\CoreBundle\Entity\Amenities $amenity)
    {
        $this->amenities->removeElement($amenity);
    }

    /**
     * Get amenities
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getAmenities()
    {
        return $this->amenities;
    }

    /**
     * Add member
     *
     * @param \Becowo\MemberBundle\Entity\Member $member
     *
     * @return Workspace
     */
    public function addMember(\Becowo\MemberBundle\Entity\Member $member)
    {
        $this->member[] = $member;

        return $this;
    }

    /**
     * Remove member
     *
     * @param \Becowo\MemberBundle\Entity\Member $member
     */
    public function removeMember(\Becowo\MemberBundle\Entity\Member $member)
    {
        $this->member->removeElement($member);
    }

    /**
     * Get member
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getMember()
    {
        return $this->member;
    }

    /**
     * Add offer
     *
     * @param \Becowo\CoreBundle\Entity\Offer $offer
     *
     * @return Workspace
     */
    public function addOffer(\Becowo\CoreBundle\Entity\Offer $offer)
    {
        $this->offer[] = $offer;

        return $this;
    }

    /**
     * Remove offer
     *
     * @param \Becowo\CoreBundle\Entity\Offer $offer
     */
    public function removeOffer(\Becowo\CoreBundle\Entity\Offer $offer)
    {
        $this->offer->removeElement($offer);
    }

    /**
     * Get offer
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getOffer()
    {
        return $this->offer;
    }

    public function __toString()
    {
        return $this->name;
    }
}
