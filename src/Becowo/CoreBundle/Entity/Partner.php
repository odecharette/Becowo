<?php

namespace Becowo\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Partner
 *
 * @ORM\Table(name="becowo_partner", uniqueConstraints={@ORM\UniqueConstraint(name="id_UNIQUE", columns={"id"})})
 * @ORM\Entity
 */
class Partner
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
     * @ORM\Column(name="name", type="string", length=45, nullable=true)
     */
    private $name;

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
     * @var \Becowo\CoreBundle\Entity\Country
     *
     * @ORM\ManyToOne(targetEntity="Becowo\CoreBundle\Entity\Country")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="country_id", referencedColumnName="id")
     * })
     */
    private $country;

    /**
     * @var string
     *
     * @ORM\Column(name="phone", type="string", length=10, nullable=true)
     * @Assert\Regex(pattern="/\A0\d{9}/", message="Le N° de téléphone doit commencer par zéro et contenir 10 chiffres")
     */
    private $phone;

    /**
     * @var string
     *
     * @ORM\Column(name="contact_firstname", type="string", length=50, nullable=true)
     * @Assert\Length(min = 3, max = 25, minMessage="Le prénom doit contenir entre 3 et 25 caractères", maxMessage="Le prénom doit contenir entre 3 et 25 caractères")
     *
     */
    private $contactFirstname;

    /**
     * @var string
     *
     * @ORM\Column(name="contact_name", type="string", length=255, nullable=true)
     * @Assert\Length(min = 3, max = 30, minMessage="Le nom doit contenir entre 3 et 30 caractères", maxMessage="Le nom doit contenir entre 3 et 30 caractères")
     *
     */
    private $contactName;


    /**
     * @var string
     *
     * @ORM\Column(name="contact_email", type="string", length=255, nullable=true)
     * @Assert\Email()
     */
    private $contactEmail;

    /**
     * @var string
     *
     * @ORM\Column(name="website", type="string", length=255, nullable=true)
     * @Assert\Regex("/\b(?:(?:https?|ftp):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i", message="L'URL de votre site n'est pas valide")
     *
     */
    private $website;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text", nullable=true)
     */
    private $description;

    /**
     * @var string
     *
     * @ORM\Column(name="url_logo", type="string", length=255, nullable=true)
     *
     */
    private $urlLogo;


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
     * Sets the value of id.
     *
     * @param integer $id the id
     *
     * @return self
     */
    private function setId($id)
    {
        $this->id = $id;

        return $this;
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
     * Gets the value of street.
     *
     * @return string
     */
    public function getStreet()
    {
        return $this->street;
    }

    /**
     * Sets the value of street.
     *
     * @param string $street the street
     *
     * @return self
     */
    public function setStreet($street)
    {
        $this->street = $street;

        return $this;
    }

    /**
     * Gets the value of postCode.
     *
     * @return string
     */
    public function getPostCode()
    {
        return $this->postCode;
    }

    /**
     * Sets the value of postCode.
     *
     * @param string $postCode the post code
     *
     * @return self
     */
    public function setPostCode($postCode)
    {
        $this->postCode = $postCode;

        return $this;
    }

    /**
     * Gets the value of city.
     *
     * @return string
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * Sets the value of city.
     *
     * @param string $city the city
     *
     * @return self
     */
    public function setCity($city)
    {
        $this->city = $city;

        return $this;
    }

    /**
     * Gets the }).
     *
     * @return \Becowo\CoreBundle\Entity\Country
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * Sets the }).
     *
     * @param \Becowo\CoreBundle\Entity\Country $country the country
     *
     * @return self
     */
    public function setCountry(\Becowo\CoreBundle\Entity\Country $country)
    {
        $this->country = $country;

        return $this;
    }

    /**
     * Gets the value of phone.
     *
     * @return string
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * Sets the value of phone.
     *
     * @param string $phone the phone
     *
     * @return self
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;

        return $this;
    }

    /**
     * Gets the value of contactFirstname.
     *
     * @return string
     */
    public function getContactFirstname()
    {
        return $this->contactFirstname;
    }

    /**
     * Sets the value of contactFirstname.
     *
     * @param string $contactFirstname the contact firstname
     *
     * @return self
     */
    public function setContactFirstname($contactFirstname)
    {
        $this->contactFirstname = $contactFirstname;

        return $this;
    }

    /**
     * Gets the value of contactName.
     *
     * @return string
     */
    public function getContactName()
    {
        return $this->contactName;
    }

    /**
     * Sets the value of contactName.
     *
     * @param string $contactName the contact name
     *
     * @return self
     */
    public function setContactName($contactName)
    {
        $this->contactName = $contactName;

        return $this;
    }

    /**
     * Gets the value of contactEmail.
     *
     * @return string
     */
    public function getContactEmail()
    {
        return $this->contactEmail;
    }

    /**
     * Sets the value of contactEmail.
     *
     * @param string $contactEmail the contact email
     *
     * @return self
     */
    public function setContactEmail($contactEmail)
    {
        $this->contactEmail = $contactEmail;

        return $this;
    }

    /**
     * Gets the value of website.
     *
     * @return string
     */
    public function getWebsite()
    {
        return $this->website;
    }

    /**
     * Sets the value of website.
     *
     * @param string $website the website
     *
     * @return self
     */
    public function setWebsite($website)
    {
        $this->website = $website;

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
     * Gets the value of urlLogo.
     *
     * @return string
     */
    public function getUrlLogo()
    {
        return $this->urlLogo;
    }

    /**
     * Sets the value of urlLogo.
     *
     * @param string $urlLogo the url logo
     *
     * @return self
     */
    public function setUrlLogo($urlLogo)
    {
        $this->urlLogo = $urlLogo;

        return $this;
    }


    public function __toString()
    {
        return $this->name;
    }
}
