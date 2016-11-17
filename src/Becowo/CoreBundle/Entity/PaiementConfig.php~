<?php

namespace Becowo\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * PaiementConfig
 *
 * @ORM\Table(name="becowo_paiement_config")
 * @ORM\Entity(repositoryClass="Becowo\CoreBundle\Repository\PaiementConfigRepository")
 */
class PaiementConfig
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="PBX_SITE", type="string", length=7, nullable=true)
     */
    private $pbxSite;

    /**
     * @var string
     *
     * @ORM\Column(name="PBX_RANG", type="string", length=2, nullable=true)
     */
    private $pbxRang;

    /**
     * @var string
     *
     * @ORM\Column(name="PBX_IDENTIFIANT", type="string", length=3, nullable=true)
     */
    private $pbxIdentifiant;

    /**
     * @var string
     *
     * @ORM\Column(name="PBX_DEVISE", type="string", length=3, nullable=false)
     */
    private $pbxDevise;

    /**
     * @var string
     *
     * @ORM\Column(name="PBX_RETOUR", type="string", length=255, nullable=false)
     */
    private $pbxRetour;

    /**
     * @var string
     *
     * @ORM\Column(name="PBX_HASH", type="string", length=10, nullable=false)
     */
    private $pbxHash;

    /**
     * @var string
     *
     * @ORM\Column(name="PBX_HMAC", type="string", length=255, nullable=false)
     */
    private $pbxHmac;



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
    private function _setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Gets the value of pbxSite.
     *
     * @return string
     */
    public function getPbxSite()
    {
        return $this->pbxSite;
    }

    /**
     * Sets the value of pbxSite.
     *
     * @param string $pbxSite the pbx site
     *
     * @return self
     */
    private function _setPbxSite($pbxSite)
    {
        $this->pbxSite = $pbxSite;

        return $this;
    }

    /**
     * Gets the value of pbxRang.
     *
     * @return string
     */
    public function getPbxRang()
    {
        return $this->pbxRang;
    }

    /**
     * Sets the value of pbxRang.
     *
     * @param string $pbxRang the pbx rang
     *
     * @return self
     */
    private function _setPbxRang($pbxRang)
    {
        $this->pbxRang = $pbxRang;

        return $this;
    }

    /**
     * Gets the value of pbxIdentifiant.
     *
     * @return string
     */
    public function getPbxIdentifiant()
    {
        return $this->pbxIdentifiant;
    }

    /**
     * Sets the value of pbxIdentifiant.
     *
     * @param string $pbxIdentifiant the pbx identifiant
     *
     * @return self
     */
    private function _setPbxIdentifiant($pbxIdentifiant)
    {
        $this->pbxIdentifiant = $pbxIdentifiant;

        return $this;
    }

    /**
     * Gets the value of pbxDevise.
     *
     * @return string
     */
    public function getPbxDevise()
    {
        return $this->pbxDevise;
    }

    /**
     * Sets the value of pbxDevise.
     *
     * @param string $pbxDevise the pbx devise
     *
     * @return self
     */
    private function _setPbxDevise($pbxDevise)
    {
        $this->pbxDevise = $pbxDevise;

        return $this;
    }

    /**
     * Gets the value of pbxRetour.
     *
     * @return string
     */
    public function getPbxRetour()
    {
        return $this->pbxRetour;
    }

    /**
     * Sets the value of pbxRetour.
     *
     * @param string $pbxRetour the pbx retour
     *
     * @return self
     */
    private function _setPbxRetour($pbxRetour)
    {
        $this->pbxRetour = $pbxRetour;

        return $this;
    }

    /**
     * Gets the value of pbxHash.
     *
     * @return string
     */
    public function getPbxHash()
    {
        return $this->pbxHash;
    }

    /**
     * Sets the value of pbxHash.
     *
     * @param string $pbxHash the pbx hash
     *
     * @return self
     */
    private function _setPbxHash($pbxHash)
    {
        $this->pbxHash = $pbxHash;

        return $this;
    }

    /**
     * Gets the value of pbxHmac.
     *
     * @return string
     */
    public function getPbxHmac()
    {
        return $this->pbxHmac;
    }

    /**
     * Sets the value of pbxHmac.
     *
     * @param string $pbxHmac the pbx hmac
     *
     * @return self
     */
    private function _setPbxHmac($pbxHmac)
    {
        $this->pbxHmac = $pbxHmac;

        return $this;
    }
}

