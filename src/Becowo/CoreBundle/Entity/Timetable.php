<?php

namespace Becowo\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Timetable
 *
 * @ORM\Table(name="becowo_timetable", uniqueConstraints={@ORM\UniqueConstraint(name="id_UNIQUE", columns={"id"})}, indexes={@ORM\Index(name="fk_workspace_id_idx", columns={"workspace_id"})})
 * @ORM\Entity(repositoryClass="Becowo\CoreBundle\Repository\TimetableRepository")
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
     * @ORM\OneToOne(targetEntity="Becowo\CoreBundle\Entity\Workspace", mappedBy = "timetable")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="workspace_id", referencedColumnName="id")
     * })
     */
    private $workspace;

    /**
     * @var \Timestamp
     *
     * @ORM\Column(name="open_hour", type="time", nullable=true)
     */
    private $openHour;

    /**
     * @var \Timestamp
     *
     * @ORM\Column(name="close_hour", type="time", nullable=true)
     */
    private $closeHour;

    /**
     * @var boolean
     *
     * @ORM\Column(name="is_open_saturday", type="boolean", nullable=true)
     */
    private $isOpenSaturday;

    /**
     * @var boolean
     *
     * @ORM\Column(name="is_open_sunday", type="boolean", nullable=true)
     */
    private $isOpenSunday;

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
     * Set isOpenSaturday
     *
     * @param boolean $isOpenSaturday
     *
     * @return Timetable
     */
    public function setIsOpenSaturday($isOpenSaturday)
    {
        $this->isOpenSaturday = $isOpenSaturday;

        return $this;
    }

    /**
     * Get isOpenSaturday
     *
     * @return boolean
     */
    public function getisOpenSaturday()
    {
        return $this->isOpenSaturday;
    }

    /**
     * Set isOpenSunday
     *
     * @param boolean $isOpenSunday
     *
     * @return Timetable
     */
    public function setIsOpenSunday($isOpenSunday)
    {
        $this->isOpenSunday = $isOpenSunday;

        return $this;
    }

    /**
     * Get isOpenSunday
     *
     * @return boolean
     */
    public function getIsOpenSunday()
    {
        return $this->isOpenSunday;
    }
    
    public function __toString()
    {
        return '';
    }
}
