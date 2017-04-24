<?php

// entité créée manuellement contrairement aux autres
// gère la relation ManyToMany avec attribut

namespace Becowo\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="becowo_booking_has_partner_offer", uniqueConstraints={@ORM\UniqueConstraint(name="id_UNIQUE", columns={"id"})})
 * @ORM\Entity(repositoryClass="Becowo\CoreBundle\Repository\BookingHasPartnerOfferRepository")
 */
class BookingHasPartnerOffer
{
  /**
   * @ORM\Column(name="id", type="integer")
   * @ORM\Id
   * @ORM\GeneratedValue(strategy="IDENTITY")
   */
  private $id;

  /**
   * @ORM\Column(name="quantity", type="integer")
   */
  private $quantity;


  /**
   * @ORM\ManyToOne(targetEntity="Becowo\CoreBundle\Entity\Booking")
   * @ORM\JoinColumn(nullable=false)
   */
  private $booking;

  /**
   * @ORM\ManyToOne(targetEntity="Becowo\CoreBundle\Entity\PartnerOffer", fetch="EAGER")
   * @ORM\JoinColumn(nullable=false)
   */
  private $partnerOffer;
  

    /**
     * Gets the value of id.
     *
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Gets the value of quantity.
     *
     * @return mixed
     */
    public function getQuantity()
    {
        return $this->quantity;
    }

    /**
     * Sets the value of quantity.
     *
     * @param mixed $quantity
     *
     * @return self
     */
    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;

        return $this;
    }

    
    /**
     * Gets the value of booking.
     *
     * @return mixed
     */
    public function getBooking()
    {
        return $this->booking;
    }

    /**
     * Sets the value of booking.
     *
     * @param mixed $booking
     *
     * @return self
     */
    public function setBooking($booking)
    {
        $this->booking = $booking;

        return $this;
    }

    /**
     * Gets the value of PartnerOffer
     *
     * @return mixed
     */
    public function getPartnerOffer()
    {
        return $this->partnerOffer;
    }

    /**
     * Sets the value of PartnerOffer
     *
     * @param mixed $PartnerOffer
     *
     * @return self
     */
    public function setPartnerOffer($partnerOffer)
    {
        $this->partnerOffer = $partnerOffer;

        return $this;
    }


}
