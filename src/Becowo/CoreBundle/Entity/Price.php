<?php

namespace Becowo\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Price
 *
 * @ORM\Table(name="price", uniqueConstraints={@ORM\UniqueConstraint(name="id_UNIQUE", columns={"id"})}, indexes={@ORM\Index(name="fk_workspace_id_idx", columns={"workspace_id"}), @ORM\Index(name="fk_office_id_idx", columns={"office_id"})})
 * @ORM\Entity
 */
class Price
{
    /**
     * @var string
     *
     * @ORM\Column(name="price_hour", type="decimal", precision=5, scale=2, nullable=true)
     */
    private $priceHour;

    /**
     * @var string
     *
     * @ORM\Column(name="price_half_day", type="decimal", precision=5, scale=2, nullable=true)
     */
    private $priceHalfDay;

    /**
     * @var string
     *
     * @ORM\Column(name="price_day", type="decimal", precision=5, scale=2, nullable=true)
     */
    private $priceDay;

    /**
     * @var string
     *
     * @ORM\Column(name="price_week", type="decimal", precision=5, scale=2, nullable=true)
     */
    private $priceWeek;

    /**
     * @var string
     *
     * @ORM\Column(name="price_month", type="decimal", precision=5, scale=2, nullable=true)
     */
    private $priceMonth;

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
     * @var \Becowo\CoreBundle\Entity\Office
     *
     * @ORM\ManyToOne(targetEntity="Becowo\CoreBundle\Entity\Office")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="office_id", referencedColumnName="id")
     * })
     */
    private $office;



    /**
     * Set priceHour
     *
     * @param string $priceHour
     *
     * @return Price
     */
    public function setPriceHour($priceHour)
    {
        $this->priceHour = $priceHour;

        return $this;
    }

    /**
     * Get priceHour
     *
     * @return string
     */
    public function getPriceHour()
    {
        return $this->priceHour;
    }

    /**
     * Set priceHalfDay
     *
     * @param string $priceHalfDay
     *
     * @return Price
     */
    public function setPriceHalfDay($priceHalfDay)
    {
        $this->priceHalfDay = $priceHalfDay;

        return $this;
    }

    /**
     * Get priceHalfDay
     *
     * @return string
     */
    public function getPriceHalfDay()
    {
        return $this->priceHalfDay;
    }

    /**
     * Set priceDay
     *
     * @param string $priceDay
     *
     * @return Price
     */
    public function setPriceDay($priceDay)
    {
        $this->priceDay = $priceDay;

        return $this;
    }

    /**
     * Get priceDay
     *
     * @return string
     */
    public function getPriceDay()
    {
        return $this->priceDay;
    }

    /**
     * Set priceWeek
     *
     * @param string $priceWeek
     *
     * @return Price
     */
    public function setPriceWeek($priceWeek)
    {
        $this->priceWeek = $priceWeek;

        return $this;
    }

    /**
     * Get priceWeek
     *
     * @return string
     */
    public function getPriceWeek()
    {
        return $this->priceWeek;
    }

    /**
     * Set priceMonth
     *
     * @param string $priceMonth
     *
     * @return Price
     */
    public function setPriceMonth($priceMonth)
    {
        $this->priceMonth = $priceMonth;

        return $this;
    }

    /**
     * Get priceMonth
     *
     * @return string
     */
    public function getPriceMonth()
    {
        return $this->priceMonth;
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
     * @return Price
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
     * Set office
     *
     * @param \Becowo\CoreBundle\Entity\Office $office
     *
     * @return Price
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
}
