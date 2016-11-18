<?php

namespace Becowo\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * PaiementTransaction
 *
 * @ORM\Table(name="becowo_paiement_transaction", uniqueConstraints={@ORM\UniqueConstraint(name="id_UNIQUE", columns={"id"})})
 * @ORM\Entity(repositoryClass="Becowo\CoreBundle\Repository\PaiementTransactionRepository")
 */
class PaiementTransaction
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
     * @var \ErrorCodes
     *
     * @ORM\OneToOne(targetEntity="ErrorCodes")
     * @ORM\JoinColumn(name="returnCode", referencedColumnName="id")
     */
    private $returnCode;    

    /**
     * @var string
     *
     * @ORM\Column(name="authorization_number", type="string", length=255)
     */
    private $authorizationNumber;   

    /**
     * @var boolean
     *
     * @ORM\Column(name="trusted_IP", type="boolean")
     */
    private $trustedIP; 

    /**
     * @var boolean
     *
     * @ORM\Column(name="trusted_signature", type="boolean")
     */
    private $trustedSignature; 

    /**
     * @var \Booking
     *
     * @ORM\OneToOne(targetEntity="Booking")
     * @ORM\JoinColumn(name="booking_id", referencedColumnName="id")
     */
    private $booking;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_on", type="datetime")
     */
    private $createdOn;    

    public function __construct()
    {
        $this->createdOn = new \DateTime();
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
     * Gets the value of returnCode.
     *
     * @return \Becowo\CoreBundle\Entity\ErrorCodes
     */
    public function getReturnCode()
    {
        return $this->returnCode;
    }

    /**
     * Sets the value of returnCode.
     *
     * @param \Becowo\CoreBundle\Entity\ErrorCodes $ErrorCodes
     *
     * @return self
     */
    public function setReturnCode(\Becowo\CoreBundle\Entity\ErrorCodes $returnCode)
    {
        $this->returnCode = $returnCode;

        return $this;
    }

    /**
     * Gets the value of authorizationNumber.
     *
     * @return string
     */
    public function getAuthorizationNumber()
    {
        return $this->authorizationNumber;
    }

    /**
     * Sets the value of authorizationNumber.
     *
     * @param string $authorizationNumber the return code
     *
     * @return self
     */
    public function setAuthorizationNumber($authorizationNumber)
    {
        $this->authorizationNumber = $authorizationNumber;

        return $this;
    }

    /**
     * Gets the value of bookingId.
     *
     * @return \Becowo\CoreBundle\Entity\Booking
     */
    public function getBooking()
    {
        return $this->booking;
    }

    /**
     * Sets the value of booking.
     *
     * @param \Becowo\CoreBundle\Entity\Booking $booking
     *
     * @return self
     */
    public function setBooking(\Becowo\CoreBundle\Entity\Booking $booking)
    {
        $this->booking = $booking;

        return $this;
    }

    /**
     * Gets the value of createdOn.
     *
     * @return \DateTime
     */
    public function getCreatedOn()
    {
        return $this->createdOn;
    }

    /**
     * Sets the value of createdOn.
     *
     * @param \DateTime $createdOn the created on
     *
     * @return self
     */
    public function setCreatedOn(\DateTime $createdOn)
    {
        $this->createdOn = $createdOn;

        return $this;
    }

    /**
     * Gets the value of trustedIP.
     *
     * @return boolean
     */
    public function getTrustedIP()
    {
        return $this->trustedIP;
    }

    /**
     * Sets the value of trustedIP.
     *
     * @param boolean $trustedIP the trusted
     *
     * @return self
     */
    public function setTrustedIP($trustedIP)
    {
        $this->trustedIP = $trustedIP;

        return $this;
    }

 
    /**
     * Gets the value of trustedSignature.
     *
     * @return boolean
     */
    public function getTrustedSignature()
    {
        return $this->trustedSignature;
    }

    /**
     * Sets the value of trustedSignature.
     *
     * @param boolean $trustedSignature the trusted
     *
     * @return self
     */
    public function setTrustedSignature($trustedSignature)
    {
        $this->trustedSignature = $trustedSignature;

        return $this;
    }

}
