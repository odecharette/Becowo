<?php

namespace Becowo\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Timetable
 *
 * @ORM\Table(name="timetable", uniqueConstraints={@ORM\UniqueConstraint(name="id_UNIQUE", columns={"id"})}, indexes={@ORM\Index(name="fk_workspace_id_idx", columns={"workspace_id"}), @ORM\Index(name="fk_week_day_id_idx", columns={"week_day_id"})})
 * @ORM\Entity
 */
class Timetable
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
     * @var \Becowo\CoreBundle\Entity\Workspace
     *
     * @ORM\ManyToOne(targetEntity="Becowo\CoreBundle\Entity\Workspace")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="workspace_id", referencedColumnName="id")
     * })
     */
    private $workspace;

    /**
     * @var \Becowo\CoreBundle\Entity\WeekDay
     *
     * @ORM\ManyToOne(targetEntity="Becowo\CoreBundle\Entity\WeekDay")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="week_day_id", referencedColumnName="id")
     * })
     */
    private $weekDay;


    /**
     * @var \DateTime
     *
     * @ORM\Column(name="open_hour", type="time", nullable=true)
     */
    private $openHour;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="close_hour", type="time", nullable=true)
     */
    private $closeHour;


    /**
     * Set openHour
     *
     * @param \DateTime $openHour
     *
     * @return Timetable
     */
    public function setOpenHour($openHour)
    {
        $this->openHour = $openHour;

        return $this;
    }

    /**
     * Get openHour
     *
     * @return \DateTime
     */
    public function getOpenHour()
    {
        return $this->openHour;
    }

    /**
     * Set closeHour
     *
     * @param \DateTime $closeHour
     *
     * @return Timetable
     */
    public function setCloseHour($closeHour)
    {
        $this->closeHour = $closeHour;

        return $this;
    }

    /**
     * Get closeHour
     *
     * @return \DateTime
     */
    public function getCloseHour()
    {
        return $this->closeHour;
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
     * @return Timetable
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
     * Set weekDay
     *
     * @param \Becowo\CoreBundle\Entity\WeekDay $weekDay
     *
     * @return Timetable
     */
    public function setWeekDay(\Becowo\CoreBundle\Entity\WeekDay $weekDay = null)
    {
        $this->weekDay = $weekDay;

        return $this;
    }

    /**
     * Get weekDay
     *
     * @return \Becowo\CoreBundle\Entity\WeekDay
     */
    public function getWeekDay()
    {
        return $this->weekDay;
    }

    public function __toString()
    {
        return $this->openHour;
    }
}
