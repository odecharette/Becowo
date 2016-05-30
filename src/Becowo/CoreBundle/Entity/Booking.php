<?php

namespace Becowo\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Booking
 *
 * @ORM\Table(name="booking", uniqueConstraints={@ORM\UniqueConstraint(name="id_UNIQUE", columns={"id"})}, indexes={@ORM\Index(name="fk_member_id_idx", columns={"member_id"}), @ORM\Index(name="fk_workspace_id_idx", columns={"workspace_id"}), @ORM\Index(name="fk_office_id_idx", columns={"office_id"}), @ORM\Index(name="fk_status_id_idx", columns={"status_id"})})
 * @ORM\Entity
 */
class Booking
{
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="start_date", type="date", nullable=true)
     */
    private $startDate;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="start_time", type="time", nullable=true)
     */
    private $startTime;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="end_date", type="date", nullable=true)
     */
    private $endDate;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="end_time", type="time", nullable=true)
     */
    private $endTime;

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
    private $createdOn = 'CURRENT_TIMESTAMP';

    /**
     * @var string
     *
     * @ORM\Column(name="price_excl_tax", type="decimal", precision=5, scale=2, nullable=true)
     */
    private $priceExclTax;

    /**
     * @var string
     *
     * @ORM\Column(name="price_incl_tax", type="decimal", precision=5, scale=2, nullable=true)
     */
    private $priceInclTax;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var \Becowo\CoreBundle\Entity\Workspace
     *
     * @ORM\ManyToOne(targetEntity="Becowo\CoreBundle\Entity\Workspace")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="workspace_id", referencedColumnName="id")
     * })
     */
    private $workspace;

    /**
     * @var \Becowo\CoreBundle\Entity\Status
     *
     * @ORM\ManyToOne(targetEntity="Becowo\CoreBundle\Entity\Status")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="status_id", referencedColumnName="id")
     * })
     */
    private $status;

    /**
     * @var \Becowo\CoreBundle\Entity\Office
     *
     * @ORM\ManyToOne(targetEntity="Becowo\CoreBundle\Entity\Office")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="office_id", referencedColumnName="id")
     * })
     */
    private $office;

    /**
     * @var \Becowo\CoreBundle\Entity\Member
     *
     * @ORM\ManyToOne(targetEntity="Becowo\MemberBundle\Entity\Member")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="member_id", referencedColumnName="id")
     * })
     */
    private $member;



    /**
     * Set startDate
     *
     * @param \DateTime $startDate
     *
     * @return Booking
     */
    public function setStartDate($startDate)
    {
        $this->startDate = $startDate;

        return $this;
    }

    /**
     * Get startDate
     *
     * @return \DateTime
     */
    public function getStartDate()
    {
        return $this->startDate;
    }

    /**
     * Set startTime
     *
     * @param \DateTime $startTime
     *
     * @return Booking
     */
    public function setStartTime($startTime)
    {
        $this->startTime = $startTime;

        return $this;
    }

    /**
     * Get startTime
     *
     * @return \DateTime
     */
    public function getStartTime()
    {
        return $this->startTime;
    }

    /**
     * Set endDate
     *
     * @param \DateTime $endDate
     *
     * @return Booking
     */
    public function setEndDate($endDate)
    {
        $this->endDate = $endDate;

        return $this;
    }

    /**
     * Get endDate
     *
     * @return \DateTime
     */
    public function getEndDate()
    {
        return $this->endDate;
    }

    /**
     * Set endTime
     *
     * @param \DateTime $endTime
     *
     * @return Booking
     */
    public function setEndTime($endTime)
    {
        $this->endTime = $endTime;

        return $this;
    }

    /**
     * Get endTime
     *
     * @return \DateTime
     */
    public function getEndTime()
    {
        return $this->endTime;
    }

    /**
     * Set isFirstBook
     *
     * @param boolean $isFirstBook
     *
     * @return Booking
     */
    public function setIsFirstBook($isFirstBook)
    {
        $this->isFirstBook = $isFirstBook;

        return $this;
    }

    /**
     * Get isFirstBook
     *
     * @return boolean
     */
    public function getIsFirstBook()
    {
        return $this->isFirstBook;
    }

    /**
     * Set createdOn
     *
     * @param \DateTime $createdOn
     *
     * @return Booking
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
     * Set priceExclTax
     *
     * @param string $priceExclTax
     *
     * @return Booking
     */
    public function setPriceExclTax($priceExclTax)
    {
        $this->priceExclTax = $priceExclTax;

        return $this;
    }

    /**
     * Get priceExclTax
     *
     * @return string
     */
    public function getPriceExclTax()
    {
        return $this->priceExclTax;
    }

    /**
     * Set priceInclTax
     *
     * @param string $priceInclTax
     *
     * @return Booking
     */
    public function setPriceInclTax($priceInclTax)
    {
        $this->priceInclTax = $priceInclTax;

        return $this;
    }

    /**
     * Get priceInclTax
     *
     * @return string
     */
    public function getPriceInclTax()
    {
        return $this->priceInclTax;
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
     * Set workspace
     *
     * @param \Becowo\CoreBundle\Entity\Workspace $workspace
     *
     * @return Booking
     */
    public function setWorkspace(\Becowo\CoreBundle\Entity\Workspace $workspace = null)
    {
        $this->workspace = $workspace;

        return $this;
    }

    /**
     * Get workspace
     *
     * @return \Becowo\CoreBundle\Entity\Workspace
     */
    public function getWorkspace()
    {
        return $this->workspace;
    }

    /**
     * Set status
     *
     * @param \Becowo\CoreBundle\Entity\Status $status
     *
     * @return Booking
     */
    public function setStatus(\Becowo\CoreBundle\Entity\Status $status = null)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return \Becowo\CoreBundle\Entity\Status
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set office
     *
     * @param \Becowo\CoreBundle\Entity\Office $office
     *
     * @return Booking
     */
    public function setOffice(\Becowo\CoreBundle\Entity\Office $office = null)
    {
        $this->office = $office;

        return $this;
    }

    /**
     * Get office
     *
     * @return \Becowo\CoreBundle\Entity\Office
     */
    public function getOffice()
    {
        return $this->office;
    }

    /**
     * Set member
     *
     * @param \Becowo\MemberBundle\Entity\Member $member
     *
     * @return Booking
     */
    public function setMember(\Becowo\CoreBundle\Entity\Member $member = null)
    {
        $this->member = $member;

        return $this;
    }

    /**
     * Get member
     *
     * @return \Becowo\MemberBundle\Entity\Member
     */
    public function getMember()
    {
        return $this->member;
    }
}
