<?php

namespace Becowo\ApiBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
/**
 * EmailsStats
 *
 * @ORM\Table(name="becowo_api_email_stats", uniqueConstraints={@ORM\UniqueConstraint(name="id_UNIQUE", columns={"id"})})
 * @ORM\Entity()
 */
class EmailStats
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
     * @ORM\Column(name="stat_time", type="string")
     */
    private $statTime;

    /**
     * @var integer
     *
     * @ORM\Column(name="accepted_incoming", type="integer", nullable=true)
     */
    private $acceptedIncoming;

    /**
     * @var integer
     *
     * @ORM\Column(name="accepted_outgoing", type="integer", nullable=true)
     */
    private $acceptedOutgoing;
 
    /**
     * @var integer
     *
     * @ORM\Column(name="delivered", type="integer", nullable=true)
     */
    private $delivered;

    /**
     * @var integer
     *
     * @ORM\Column(name="failed_temp_esp", type="integer", nullable=true)
     */
    private $failedTempEsp;

    /**
     * @var integer
     *
     * @ORM\Column(name="failed_permanent_suppress_bounce", type="integer", nullable=true)
     */
    private $failedPermanentSuppressBounce;

    /**
     * @var integer
     *
     * @ORM\Column(name="failed_permanent_suppress_unsubscribe", type="integer", nullable=true)
     */
    private $failedPermanentSuppressUnsubscribe;

    /**
     * @var integer
     *
     * @ORM\Column(name="failed_permanent_suppress_complaint", type="integer", nullable=true)
     */
    private $failedPermanentSuppressComplaint;

    /**
     * @var integer
     *
     * @ORM\Column(name="failed_permanent_bounce", type="integer", nullable=true)
     */
    private $failedPermanentBounce;

    /**
     * @var integer
     *
     * @ORM\Column(name="failed_permanent_total", type="integer", nullable=true)
     */
    private $failedPermanentTotal;

    /**
     * @var integer
     *
     * @ORM\Column(name="nb_stored", type="integer", nullable=true)
     */
    private $nbStored;

    /**
     * @var integer
     *
     * @ORM\Column(name="opened", type="integer", nullable=true)
     */
    private $opened;

    /**
     * @var integer
     *
     * @ORM\Column(name="clicked", type="integer", nullable=true)
     */
    private $clicked;

    /**
     * @var integer
     *
     * @ORM\Column(name="unsuscribed", type="integer", nullable=true)
     */
    private $unsuscribed;

    /**
     * @var integer
     *
     * @ORM\Column(name="complained", type="integer", nullable=true)
     */
    private $complained;

    /**
     * Constructor
     */
    public function __construct()
    {
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
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Gets the value of statTime.
     *
     * @return string
     */
    public function getStatTime()
    {
        return $this->statTime;
    }

    /**
     * Sets the value of statTime.
     *
     * @param string $statTime the stat time
     *
     * @return self
     */
    public function setStatTime($statTime)
    {
        $this->statTime = $statTime;

        return $this;
    }

    /**
     * Gets the value of acceptedIncoming.
     *
     * @return integer
     */
    public function getAcceptedIncoming()
    {
        return $this->acceptedIncoming;
    }

    /**
     * Sets the value of acceptedIncoming.
     *
     * @param integer $acceptedIncoming the accepted incoming
     *
     * @return self
     */
    public function setAcceptedIncoming($acceptedIncoming)
    {
        $this->acceptedIncoming = $acceptedIncoming;

        return $this;
    }

    /**
     * Gets the value of acceptedOutgoing.
     *
     * @return integer
     */
    public function getAcceptedOutgoing()
    {
        return $this->acceptedOutgoing;
    }

    /**
     * Sets the value of acceptedOutgoing.
     *
     * @param integer $acceptedOutgoing the accepted outgoing
     *
     * @return self
     */
    public function setAcceptedOutgoing($acceptedOutgoing)
    {
        $this->acceptedOutgoing = $acceptedOutgoing;

        return $this;
    }

    /**
     * Gets the value of delivered.
     *
     * @return integer
     */
    public function getDelivered()
    {
        return $this->delivered;
    }

    /**
     * Sets the value of delivered.
     *
     * @param integer $delivered the delivered
     *
     * @return self
     */
    public function setDelivered($delivered)
    {
        $this->delivered = $delivered;

        return $this;
    }

    /**
     * Gets the value of failedTempEsp.
     *
     * @return integer
     */
    public function getFailedTempEsp()
    {
        return $this->failedTempEsp;
    }

    /**
     * Sets the value of failedTempEsp.
     *
     * @param integer $failedTempEsp the failed temp esp
     *
     * @return self
     */
    public function setFailedTempEsp($failedTempEsp)
    {
        $this->failedTempEsp = $failedTempEsp;

        return $this;
    }

    /**
     * Gets the value of failedPermanentSuppressBounce.
     *
     * @return integer
     */
    public function getFailedPermanentSuppressBounce()
    {
        return $this->failedPermanentSuppressBounce;
    }

    /**
     * Sets the value of failedPermanentSuppressBounce.
     *
     * @param integer $failedPermanentSuppressBounce the failed permanent suppress bounce
     *
     * @return self
     */
    public function setFailedPermanentSuppressBounce($failedPermanentSuppressBounce)
    {
        $this->failedPermanentSuppressBounce = $failedPermanentSuppressBounce;

        return $this;
    }

    /**
     * Gets the value of failedPermanentSuppressUnsubscribe.
     *
     * @return integer
     */
    public function getFailedPermanentSuppressUnsubscribe()
    {
        return $this->failedPermanentSuppressUnsubscribe;
    }

    /**
     * Sets the value of failedPermanentSuppressUnsubscribe.
     *
     * @param integer $failedPermanentSuppressUnsubscribe the failed permanent suppress unsubscribe
     *
     * @return self
     */
    public function setFailedPermanentSuppressUnsubscribe($failedPermanentSuppressUnsubscribe)
    {
        $this->failedPermanentSuppressUnsubscribe = $failedPermanentSuppressUnsubscribe;

        return $this;
    }

    /**
     * Gets the value of failedPermanentSuppressComplaint.
     *
     * @return integer
     */
    public function getFailedPermanentSuppressComplaint()
    {
        return $this->failedPermanentSuppressComplaint;
    }

    /**
     * Sets the value of failedPermanentSuppressComplaint.
     *
     * @param integer $failedPermanentSuppressComplaint the failed permanent suppress complaint
     *
     * @return self
     */
    public function setFailedPermanentSuppressComplaint($failedPermanentSuppressComplaint)
    {
        $this->failedPermanentSuppressComplaint = $failedPermanentSuppressComplaint;

        return $this;
    }

    /**
     * Gets the value of failedPermanentBounce.
     *
     * @return integer
     */
    public function getFailedPermanentBounce()
    {
        return $this->failedPermanentBounce;
    }

    /**
     * Sets the value of failedPermanentBounce.
     *
     * @param integer $failedPermanentBounce the failed permanent bounce
     *
     * @return self
     */
    public function setFailedPermanentBounce($failedPermanentBounce)
    {
        $this->failedPermanentBounce = $failedPermanentBounce;

        return $this;
    }

    /**
     * Gets the value of failedPermanentTotal.
     *
     * @return integer
     */
    public function getFailedPermanentTotal()
    {
        return $this->failedPermanentTotal;
    }

    /**
     * Sets the value of failedPermanentTotal.
     *
     * @param integer $failedPermanentTotal the failed permanent total
     *
     * @return self
     */
    public function setFailedPermanentTotal($failedPermanentTotal)
    {
        $this->failedPermanentTotal = $failedPermanentTotal;

        return $this;
    }

    /**
     * Gets the value of stored.
     *
     * @return integer
     */
    public function getNbStored()
    {
        return $this->nbStored;
    }

    /**
     * Sets the value of stored.
     *
     * @param integer $stored the stored
     *
     * @return self
     */
    public function setNbStored($stored)
    {
        $this->nbStored = $stored;

        return $this;
    }

    /**
     * Gets the value of opened.
     *
     * @return integer
     */
    public function getOpened()
    {
        return $this->opened;
    }

    /**
     * Sets the value of opened.
     *
     * @param integer $opened the opened
     *
     * @return self
     */
    public function setOpened($opened)
    {
        $this->opened = $opened;

        return $this;
    }

    /**
     * Gets the value of clicked.
     *
     * @return integer
     */
    public function getClicked()
    {
        return $this->clicked;
    }

    /**
     * Sets the value of clicked.
     *
     * @param integer $clicked the clicked
     *
     * @return self
     */
    public function setClicked($clicked)
    {
        $this->clicked = $clicked;

        return $this;
    }

    /**
     * Gets the value of unsuscribed.
     *
     * @return integer
     */
    public function getUnsuscribed()
    {
        return $this->unsuscribed;
    }

    /**
     * Sets the value of unsuscribed.
     *
     * @param integer $unsuscribed the unsuscribed
     *
     * @return self
     */
    public function setUnsuscribed($unsuscribed)
    {
        $this->unsuscribed = $unsuscribed;

        return $this;
    }

    /**
     * Gets the value of complained.
     *
     * @return integer
     */
    public function getComplained()
    {
        return $this->complained;
    }

    /**
     * Sets the value of complained.
     *
     * @param integer $complained the complained
     *
     * @return self
     */
    public function setComplained($complained)
    {
        $this->complained = $complained;

        return $this;
    }
}
