<?php

namespace Becowo\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Price
 *
 * @ORM\Table(name="becowo_price", uniqueConstraints={@ORM\UniqueConstraint(name="id_UNIQUE", columns={"id"})}, indexes={@ORM\Index(name="fk_workspace_has_office_idx", columns={"workspace_has_office_id"})})
 * @ORM\Entity(repositoryClass="Becowo\CoreBundle\Repository\PriceRepository")
 */
class Price
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
     * @var \Becowo\CoreBundle\Entity\WorkspaceHasOffice
     *
     * @ORM\OneToOne(targetEntity="WorkspaceHasOffice")
     * @ORM\JoinColumn(name="Workspace_has_office_id", referencedColumnName="id")
     */
    private $workspaceHasOffice;




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
     * Set workspaceHasOffice
     *
     * @param \Becowo\CoreBundle\Entity\WorkspaceHasOffice $workspaceHasOffice
     *
     * @return Price
     */
    public function setWorkspaceHasOffice(\Becowo\CoreBundle\Entity\WorkspaceHasOffice $workspaceHasOffice = null)
    {
        $this->workspaceHasOffice = $workspaceHasOffice;

        return $this;
    }

    /**
     * Get workspaceHasOffice
     *
     * @return \Becowo\CoreBundle\Entity\WorkspaceHasOffice
     */
    public function getWorkspaceHasOffice()
    {
        return $this->workspaceHasOffice;
    }

   
}
