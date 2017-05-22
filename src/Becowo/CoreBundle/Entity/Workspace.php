<?php

namespace Becowo\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Algolia\AlgoliaSearchBundle\Mapping\Annotation as Algolia;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * Workspace
 *
 * @ORM\Table(name="becowo_workspace", uniqueConstraints={@ORM\UniqueConstraint(name="id_UNIQUE", columns={"id"})}, indexes={@ORM\Index(name="fk_country_id_idx", columns={"country_id"}), @ORM\Index(name="fk_category_id_idx", columns={"category_id"}), @ORM\Index(name="fk_vote_average", columns={"vote_average"})})
 * @ORM\Entity(repositoryClass="Becowo\CoreBundle\Repository\WorkspaceRepository")
 * @UniqueEntity("name")
 */
class Workspace
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @Algolia\Attribute
     */
    private $id;
    
    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255, nullable=false)
     * @Assert\NotNull(message="Le nom est obligatoire")
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
     * @ORM\Column(name="network", type="string", length=255, nullable=true)
     * @Algolia\Attribute
     */
    private $network;

    /**
     * @var string
     *
     * @ORM\Column(name="description_bonus", type="string", length=255, nullable=true)
     * @Algolia\Attribute
     */
    private $descriptionBonus;


    /**
     * @var string
     *
     * @ORM\Column(name="description_like", type="string", length=255, nullable=true)
     */
    private $descriptionLike;

    /**
     * @var string
     *
     * @ORM\Column(name="openHoursInfo", type="string", length=255, nullable=true)
     */
    private $openHoursInfo;

    /**
     * @var string
     *
     * @ORM\Column(name="website", type="string", length=255, nullable=true)
     */
    private $website;

    /**
     * @var string
     *
     * @ORM\Column(name="url_visit_360", type="string", length=255, nullable=true)
     */
    private $urlVisit360;

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
     * @Algolia\Attribute
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
     * @var \Becowo\CoreBundle\Entity\WorkspaceCategory
     *
     * @ORM\ManyToOne(targetEntity="Becowo\CoreBundle\Entity\WorkspaceCategory", fetch="EAGER")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="category_id", referencedColumnName="id")
     * })
     * @Algolia\Attribute
     */
    private $category;

    /**
     * @var \Becowo\CoreBundle\Entity\Offer
     *
     * @ORM\ManyToOne(targetEntity="Becowo\CoreBundle\Entity\Offer", fetch="EAGER")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="offer_id", referencedColumnName="id")
     * })
     * @Algolia\Attribute
     */
    private $offer;

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
     * @ORM\JoinTable(name="becowo_workspace_has_poi",
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
     * @ORM\ManyToMany(targetEntity="Becowo\CoreBundle\Entity\Office", inversedBy="workspace", fetch="EAGER")
     * @ORM\JoinTable(name="becowo_workspace_filter_offices",
     *   joinColumns={
     *     @ORM\JoinColumn(name="workspace_id", referencedColumnName="id")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="office_id", referencedColumnName="id")
     *   }
     * )
     * @Algolia\Attribute
     */
    private $filterOffices;


    /**
     * @var \Becowo\CoreBundle\Entity\Region
     *
     * @ORM\ManyToOne(targetEntity="Becowo\CoreBundle\Entity\Region", fetch="EAGER")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="region_id", referencedColumnName="id")
     * })
     * @Algolia\Attribute
     */
    private $region;

    /**
     * @var string
     *
     * @ORM\Column(name="amenities_desc", type="text", nullable=true)
     *
     */
    private $amenitiesDesc;

    /**
     * @var string
     *
     * @ORM\Column(name="arrival_desc", type="string", length=255, nullable=true)
     *
     */
    private $arrivalDesc;


    /**
     * @var decimal
     *
     * @ORM\Column(name="lowest_price", type="string", nullable=true)
     * @Algolia\Attribute
     *
     */
    private $lowestPrice;

    /**
     * @var decimal
     *
     * @ORM\Column(name="vote_average", type="decimal", precision=4, scale=2, nullable=true)
     * @Algolia\Attribute
     *
     */
    private $voteAverage;


    /**
     * @var string
     *
     * @ORM\Column(name="favorite_picture_url", type="string", length=255, nullable=true)
     * @Algolia\Attribute
     *
     */
    private $favoritePictureUrl;


    /**
     * @var string
     *
     * @ORM\Column(name="horaire_calme", type="string", length=255, nullable=true)
     *
     */
    private $horaireCalme;

    /**
       * @ORM\OneToMany(targetEntity="Becowo\CoreBundle\Entity\WorkspaceHasAmenities", mappedBy="workspace", cascade={"persist"})
       */
    private $workspaceHasAmenitiesList; 

    /**
       * @ORM\OneToMany(targetEntity="Becowo\CoreBundle\Entity\WorkspaceHasOffice", mappedBy="workspace", cascade={"persist"})
       * @Assert\NotNull(message="bureau obligatoire")
       */
    private $workspaceHasOfficeList;


    /**
       * @ORM\OneToMany(targetEntity="Becowo\CoreBundle\Entity\WorkspaceHasTeamMember", mappedBy="workspace", cascade={"persist"})
       */
    private $workspaceHasTeamMemberList;  

    /**
     * @var \Becowo\CoreBundle\Entity\Timetable
     *
     * @ORM\OneToOne(targetEntity="Becowo\CoreBundle\Entity\Timetable", inversedBy = "workspace", cascade={"persist"})
     */
    private $timetable;

    /**
       * @ORM\OneToMany(targetEntity="Becowo\CoreBundle\Entity\Picture", mappedBy="workspace", cascade={"persist"})
       */
    private $pictures;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->poi = new \Doctrine\Common\Collections\ArrayCollection();
        $this->filterOffices = new \Doctrine\Common\Collections\ArrayCollection();
        $this->createdOn = new \DateTime();
        $this->isDeleted = false;
        $this->lowestPrice = 0;
        $this->voteAverage = 0;
        $this->workspaceHasAmenitiesList = new ArrayCollection();
        $this->workspaceHasOfficeList = new ArrayCollection();
        $this->workspaceHasTeamMemberList = new ArrayCollection();
        $this->pictures = new ArrayCollection();
    }

    public function addPicture(Picture $picture)
      {
        $this->pictures[] = $picture;
      }

      public function removePicture(Picture $picture)
      {
        $this->pictures->removeElement($picture);
      }

      public function getPictures()
      {
        return $this->pictures;
      }

    /**
     * Set timetable
     *
     * @param \Becowo\CoreBundle\Entity\Timetable $timetable
     *
     * @return Price
     */
    public function setTimetable(\Becowo\CoreBundle\Entity\Timetable $timetable = null)
    {
        $this->timetable = $timetable;

        return $this;
    }

    /**
     * Get timetable
     *
     * @return \Becowo\CoreBundle\Entity\Timetable
     */
    public function getTimetable()
    {
        return $this->timetable;
    }

    public function addWorkspaceHasAmenities(WorkspaceHasAmenities $WorkspaceHasAmenities)
      {
        $this->workspaceHasAmenitiesList[] = $WorkspaceHasAmenities;
      }

      public function removeWorkspaceHasAmenities(workspaceHasAmenities $workspaceHasAmenities)
      {
        $this->workspaceHasAmenitiesList->removeElement($workspaceHasAmenities);
      }

      public function getWorkspaceHasAmenitiesList()
      {
        return $this->workspaceHasAmenitiesList;
      }

    public function addWorkspaceHasOffice(WorkspaceHasOffice $WorkspaceHasOffice)
      {
        $this->workspaceHasOfficeList[] = $WorkspaceHasOffice;
      }

      public function removeWorkspaceHasOffice(WorkspaceHasOffice $WorkspaceHasOffice)
      {
        $this->workspaceHasOfficeList->removeElement($WorkspaceHasOffice);
      }

      public function getWorkspaceHasOfficeList()
      {
        return $this->workspaceHasOfficeList;
      }

    public function addWorkspaceHasTeamMemberList(WorkspaceHasTeamMember $WorkspaceHasTeamMember)
    {
        $this->workspaceHasTeamMemberList[] = $WorkspaceHasTeamMember;
    }

    public function removeTeamMember(WorkspaceHasTeamMemberList $WorkspaceHasTeamMember)
    {
        $this->workspaceHasTeamMemberList->removeElement($WorkspaceHasTeamMember);
    }

    public function getWorkspaceHasTeamMemberList()
    {
        return $this->workspaceHasTeamMemberList;
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
     * Set network
     *
     * @param string $network
     *
     * @return Workspace
     */
    public function setNetwork($network)
    {
        $this->network = $network;

        return $this;
    }

    /**
     * Get network
     *
     * @return string
     */
    public function getNetwork()
    {
        return $this->network;
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
     * Set openHoursInfo
     *
     * @param string $openHoursInfo
     *
     * @return Workspace
     */
    public function setOpenHoursInfo($openHoursInfo)
    {
        $this->openHoursInfo = $openHoursInfo;

        return $this;
    }

    /**
     * Get openHoursInfo
     *
     * @return string
     */
    public function getOpenHoursInfo()
    {
        return $this->openHoursInfo;
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
     * Set urlVisit360
     *
     * @param string $urlVisit360
     *
     * @return Workspace
     */
    public function setUrlVisit360($urlVisit360)
    {
        $this->urlVisit360 = $urlVisit360;

        return $this;
    }

    /**
     * Get urlVisit360
     *
     * @return string
     */
    public function getUrlVisit360()
    {
        return $this->urlVisit360;
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
     * Set offer
     *
     * @param \Becowo\CoreBundle\Entity\Offer $offer
     *
     * @return Workspace
     */
    public function setOffer(\Becowo\CoreBundle\Entity\Offer $offer = null)
    {
        $this->offer = $offer;

        return $this;
    }

    /**
     * Get offer
     *
     * @return \Becowo\CoreBundle\Entity\Offer
     */
    public function getOffer()
    {
        return $this->offer;
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
     * Add filterOffices
     *
     * @param \Becowo\CoreBundle\Entity\Office $office
     *
     * @return Workspace
     */
    public function addFilterOffices(\Becowo\CoreBundle\Entity\Office $office)
    {
        $this->filterOffices[] = $office;

        return $this;
    }

    /**
     * Remove filterOffices
     *
     * @param \Becowo\CoreBundle\Entity\Office $office
     */
    public function removeFilterOffices(\Becowo\CoreBundle\Entity\Office $office)
    {
        $this->filterOffices->removeElement($office);
    }

    /**
     * Get filterOffices
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getFilterOffices()
    {
        return $this->filterOffices;
    }


    /**
     * Set region
     *
     * @param \Becowo\CoreBundle\Entity\region $region
     *
     * @return Workspace
     */
    public function setRegion(\Becowo\CoreBundle\Entity\Region $region = null)
    {
        $this->region = $region;

        return $this;
    }

    /**
     * Get region
     *
     * @return \Becowo\CoreBundle\Entity\Region
     */
    public function getRegion()
    {
        return $this->region;
    }

    /**
     * Set amenitiesDesc
     *
     * @param string $amenitiesDesc
     *
     * @return Workspace
     */
    public function setAmenitiesDesc($amenitiesDesc)
    {
        $this->amenitiesDesc = $amenitiesDesc;

        return $this;
    }

    /**
     * Get amenitiesDesc
     *
     * @return string
     */
    public function getAmenitiesDesc()
    {
        return $this->amenitiesDesc;
    }

    /**
     * Set arrivalDesc
     *
     * @param string $arrivalDesc
     *
     * @return Workspace
     */
    public function setArrivalDesc($arrivalDesc)
    {
        $this->arrivalDesc = $arrivalDesc;

        return $this;
    }

    /**
     * Get arrivalDesc
     *
     * @return string
     */
    public function getArrivalDesc()
    {
        return $this->arrivalDesc;
    }

    /**
     * Set lowestPrice
     *
     * @param decimal $lowestPrice
     *
     * @return Workspace
     */
    public function setLowestPrice($lowestPrice)
    {
        $this->lowestPrice = $lowestPrice;

        return $this;
    }

    /**
     * Get lowestPrice
     *
     * @return decimal
     */
    public function getLowestPrice()
    {
        return $this->lowestPrice;
    }

    /**
     * Set voteAverage
     *
     * @param decimal $voteAverage
     *
     * @return Workspace
     */
    public function setVoteAverage($voteAverage)
    {
        $this->voteAverage = $voteAverage;

        return $this;
    }

    /**
     * Get voteAverage
     *
     * @return decimal
     */
    public function getVoteAverage()
    {
        return $this->voteAverage;
    }


    /**
     * Set favoritePictureUrl
     *
     * @param string $favoritePictureUrl
     *
     * @return Workspace
     */
    public function setFavoritePictureUrl($favoritePictureUrl)
    {
        $this->favoritePictureUrl = $favoritePictureUrl;

        return $this;
    }

    /**
     * Get favoritePictureUrl
     *
     * @return string
     */
    public function getFavoritePictureUrl()
    {
        return $this->favoritePictureUrl;
    }

    /**
     * Set horaireCalme
     *
     * @param string $horaireCalme
     *
     * @return Workspace
     */
    public function setHoraireCalme($horaireCalme)
    {
        $this->horaireCalme = $horaireCalme;

        return $this;
    }

    /**
     * Get horaireCalme
     *
     * @return string
     */
    public function getHoraireCalme()
    {
        return $this->horaireCalme;
    }


    /**
     * Set descriptionLike
     *
     * @param string $descriptionLike
     *
     * @return Workspace
     */
    public function setDescriptionLike($descriptionLike)
    {
        $this->descriptionLike = $descriptionLike;

        return $this;
    }

    /**
     * Get descriptionLike
     *
     * @return string
     */
    public function getDescriptionLike()
    {
        return $this->descriptionLike;
    }

    public function __toString()
    {
        return $this->name;
    }


    /**
     * @Algolia\IndexIf
     */
    public function isVisible()
    {
        return !$this->isDeleted && $this->isVisible;
    }
}
