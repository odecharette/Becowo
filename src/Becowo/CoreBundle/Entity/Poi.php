<?php

namespace Becowo\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Poi
 *
 * @ORM\Table(name="poi", uniqueConstraints={@ORM\UniqueConstraint(name="id_UNIQUE", columns={"id"})}, indexes={@ORM\Index(name="fk_country_id_idx", columns={"country_id"}), @ORM\Index(name="fk_poi_category_id_idx", columns={"poi_category_id"})})
 * @ORM\Entity(repositoryClass="Becowo\CoreBundle\Repository\PoiRepository")
 */
class Poi
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
     * @ORM\Column(name="name", type="string", length=255, nullable=true)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="longitude", type="decimal", precision=11, scale=8, nullable=true)
     */
    private $longitude;

    /**
     * @var string
     *
     * @ORM\Column(name="latitude", type="decimal", precision=10, scale=8, nullable=true)
     */
    private $latitude;

    /**
     * @var string
     *
     * @ORM\Column(name="street", type="string", length=255, nullable=true)
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
     * @ORM\Column(name="city", type="string", length=45, nullable=true)
     */
    private $city;

    /**
     * @var string
     *
     * @ORM\Column(name="marker_symbol", type="string", length=45, nullable=true)
     */
    private $marker_symbol;

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
     * @var \Becowo\CoreBundle\Entity\PoiCategory
     *
     * @ORM\ManyToOne(targetEntity="Becowo\CoreBundle\Entity\PoiCategory")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="poi_category_id", referencedColumnName="id")
     * })
     */
    private $poiCategory;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Becowo\CoreBundle\Entity\Workspace", mappedBy="poi")
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
     * @return Poi
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
     * Set longitude
     *
     * @param string $longitude
     *
     * @return Poi
     */
    public function setLongitude($longitude)
    {
        $this->longitude = $longitude;

        return $this;
    }

    /**
     * Get longitude
     *
     * @return string
     */
    public function getLongitude()
    {
        return $this->longitude;
    }

    /**
     * Set latitude
     *
     * @param string $latitude
     *
     * @return Poi
     */
    public function setLatitude($latitude)
    {
        $this->latitude = $latitude;

        return $this;
    }

    /**
     * Get latitude
     *
     * @return string
     */
    public function getLatitude()
    {
        return $this->latitude;
    }

    /**
     * Set street
     *
     * @param string $street
     *
     * @return Poi
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
     * @return Poi
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
     * @return Poi
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
     * Set marker_symbol
     *
     * @param string $marker_symbol
     *
     * @return Poi
     */
    public function setMarkerSymbol($marker_symbol)
    {
        $this->marker_symbol = $marker_symbol;

        return $this;
    }

    /**
     * Get marker_symbol
     *
     * @return string
     */
    public function getMarkerSymbol()
    {
        return $this->marker_symbol;
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
     * Set country
     *
     * @param \Becowo\CoreBundle\Entity\Country $country
     *
     * @return Poi
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
     * Set poiCategory
     *
     * @param \Becowo\CoreBundle\Entity\PoiCategory $poiCategory
     *
     * @return Poi
     */
    public function setPoiCategory(\Becowo\CoreBundle\Entity\PoiCategory $poiCategory = null)
    {
        $this->poiCategory = $poiCategory;

        return $this;
    }

    /**
     * Get poiCategory
     *
     * @return \Becowo\CoreBundle\Entity\PoiCategory
     */
    public function getPoiCategory()
    {
        return $this->poiCategory;
    }

    /**
     * Add workspace
     *
     * @param \Becowo\CoreBundle\Entity\Workspace $workspace
     *
     * @return Poi
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

    public function __toString()
    {
        return $this->name;
    }
}
