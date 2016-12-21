<?php

namespace Becowo\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Booking
 *
 * @ORM\Table(name="becowo_booking", uniqueConstraints={@ORM\UniqueConstraint(name="id_UNIQUE", columns={"id"}), @ORM\UniqueConstraint(name="bookingRef_UNIQUE", columns={"booking_ref"})}, indexes={@ORM\Index(name="fk_member_id_idx", columns={"member_id"}), @ORM\Index(name="fk_status_id_idx", columns={"status_id"}), @ORM\Index(name="fk_WorkspaceHasOffice_id_idx", columns={"WorkspaceHasOffice_id"})})
 * @ORM\Entity(repositoryClass="Becowo\CoreBundle\Repository\BookingRepository")
 */
class Booking
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    protected $id;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="start_date", type="datetime", nullable=true)
     */
    private $startDate;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="end_date", type="datetime", nullable=true)
     */
    private $endDate;

    /**
     * @var boolean
     *
     * @ORM\Column(name="is_first_book", type="boolean", nullable=true)
     */
    private $isFirstBook;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_on", type="datetime", nullable=false)
     */
    private $createdOn;

    /**
     * @var decimal
     *
     * @ORM\Column(name="price_excl_tax", type="decimal", precision=7, scale=2, nullable=true)
     */
    private $priceExclTax;

    /**
     * @var decimal
     *
     * @ORM\Column(name="price_incl_tax", type="decimal", precision=7, scale=2, nullable=true)
     */
    private $priceInclTax;

    /**
     * @var string
     *
     * @ORM\Column(name="duration", type="string", length=30, nullable=false)
     */
    private $duration;


    /**
     * @var string
     *
     * @ORM\Column(name="duration_day", type="string", length=20, nullable=false)
     */
    private $durationDay;

    /**
     * @var integer
     *
     * @ORM\Column(name="nb_people", type="integer", nullable=false)
     */
    private $nbPeople;

    /**
     * @var \WorkspaceHasOffice
     *
     * @ORM\ManyToOne(targetEntity="WorkspaceHasOffice")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="WorkspaceHasOffice_id", referencedColumnName="id")
     * })
     */
    private $workspacehasoffice;

    /**
     * @var \Status
     *
     * @ORM\ManyToOne(targetEntity="Status")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="status_id", referencedColumnName="id")
     * })
     */
    private $status;

    /**
     * @var \string
     *
     * @ORM\Column(name="booking_ref", type="string", length=20, nullable=false)
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $bookingRef;

    /**
     * @var Becowo\MemberBundle\Entity\Member
     *
     * @ORM\ManyToOne(targetEntity="Becowo\MemberBundle\Entity\Member")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="member_id", referencedColumnName="id")
     * })
     */
    private $member;


    /**
     * @var \string
     *
     * @ORM\Column(name="message", type="string", length=255, nullable=true)
     */
    private $message;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->createdOn = new \DateTime();
        $this->bookingRef = uniqid();
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
    private function _setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Gets the value of startDate.
     *
     * @return \DateTime
     */
    public function getStartDate()
    {
        return $this->startDate;
    }

    /**
     * Sets the value of startDate.
     *
     * @param \DateTime $startDate
     *
     * @return self
     */
    public function setStartDate(\DateTime $startDate)
    {
        $this->startDate = $startDate;

        return $this;
    }

    /**
     * Gets the value of endDate.
     *
     * @return \DateTime
     */
    public function getEndDate()
    {
        return $this->endDate;
    }

    /**
     * Sets the value of endDate.
     *
     * @param \DateTime $endDate the end date
     *
     * @return self
     */
    public function setEndDate(\DateTime $endDate)
    {
        $this->endDate = $endDate;

        return $this;
    }

    /**
     * Gets the value of isFirstBook.
     *
     * @return boolean
     */
    public function getIsFirstBook()
    {
        return $this->isFirstBook;
    }

    /**
     * Sets the value of isFirstBook.
     *
     * @param boolean $isFirstBook the is first book
     *
     * @return self
     */
    public function setIsFirstBook($isFirstBook)
    {
        $this->isFirstBook = $isFirstBook;

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
     * Gets the value of priceExclTax.
     *
     * @return decimal
     */
    public function getPriceExclTax()
    {
        return $this->priceExclTax;
    }

    /**
     * Sets the value of priceExclTax.
     *
     * @param decimal 
     *
     * @return self
     */
    public function setPriceExclTax($priceExclTax)
    {
        $this->priceExclTax = $priceExclTax;

        return $this;
    }

    /**
     * Gets the value of priceInclTax.
     *
     * @return decimal
     */
    public function getPriceInclTax()
    {
        return $this->priceInclTax;
    }

    /**
     * Sets the value of priceInclTax.
     *
     * @param $priceInclTax
     *
     * @return decimal
     */
    public function setPriceInclTax($priceInclTax)
    {
        $this->priceInclTax = $priceInclTax;

        return $this;
    }

    /**
     * Gets the value of duration.
     *
     * @return string
     */
    public function getDuration()
    {
        return $this->duration;
    }

    /**
     * Sets the value of duration.
     *
     * @param string $duration
     *
     * @return self
     */
    public function setDuration($duration)
    {
        $this->duration = $duration;

        return $this;
    }

 
    /**
     * Gets the value of durationDay.
     *
     * @return string
     */
    public function getDurationDay()
    {
        return $this->durationDay;
    }

    /**
     * Sets the value of durationDay.
     *
     * @param string $durationDay the duration day
     *
     * @return self
     */
    public function setDurationDay($durationDay)
    {
        $this->durationDay = $durationDay;

        return $this;
    }

    /**
     * Gets the value of nbPeople.
     *
     * @return integer
     */
    public function getNbPeople()
    {
        return $this->nbPeople;
    }

    /**
     * Sets the value of nbPeople.
     *
     * @param integer $nbPeople the nb people
     *
     * @return self
     */
    public function setNbPeople($nbPeople)
    {
        $this->nbPeople = $nbPeople;

        return $this;
    }

    /**
     * Gets the }).
     *
     * @return Becowo\CoreBundle\Entity\WorkspaceHasOffice
     */
    public function getWorkspaceHasOffice()
    {
        return $this->workspacehasoffice;
    }

    /**
     * Sets the workspacehasoffice
     *
     * @param \Becowo\CoreBundle\Entity\WorkspaceHasOffice $workspacehasoffice
     *
     * @return self
     */
    public function setWorkspaceHasOffice(\Becowo\CoreBundle\Entity\WorkspaceHasOffice $workspacehasoffice)
    {
        $this->workspacehasoffice = $workspacehasoffice;

        return $this;
    }

    /**
     * Gets the }).
     *
     * @return Becowo\CoreBundle\Entity\Status
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Sets the }).
     *
     * @param \Becowo\CoreBundle\Entity\Status $status
     *
     * @return self
     */
    public function setStatus(\Becowo\CoreBundle\Entity\Status $status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Gets the Member
     *
     * @return \Becowo\MemberBundle\Entity\Member
     */
    public function getMember()
    {
        return $this->member;
    }

    /**
     * Sets the Member
     *
     * @param \Becowo\MemberBundle\Entity\Member $member
     *
     * @return self
     */
    public function setMember(\Becowo\MemberBundle\Entity\Member $member = null)
    {
        $this->member = $member;

        return $this;
    }

   /**
     * Gets the value of booking_ref.
     *
     * @return string
     */
    public function getBookingRef()
    {
        return $this->bookingRef;
    }

    /**
     * Sets the value of bookingRef.
     *
     * @param string $bookingRef
     *
     * @return self
     */
    public function setBookingRef($bookingRef)
    {
        $this->bookingRef = $bookingRef;

        return $this;
    }

    /**
     * Gets the value of message.
     *
     * @return \string
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * Sets the value of message.
     *
     * @param \string $message the message
     *
     * @return self
     */
    public function setMessage($message)
    {
        $this->message = $message;

        return $this;
    }
}

