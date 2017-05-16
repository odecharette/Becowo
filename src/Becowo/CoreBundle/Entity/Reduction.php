<?php

namespace Becowo\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
Use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;


/**
 * Reduction
 *
 * @ORM\Table(name="becowo_reduction", uniqueConstraints={@ORM\UniqueConstraint(name="id_UNIQUE", columns={"id"})})
 * @ORM\Entity(repositoryClass="Becowo\CoreBundle\Repository\ReductionRepository")
 * @UniqueEntity("code")
 */
class Reduction
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
     * @ORM\Column(name="code", type="string", length=10, nullable=false)
     */
    private $code;

    /**
     * @var boolean
     *
     * @ORM\Column(name="is_percentage", type="boolean", nullable=false)
     */
    private $isPercentage;

    /**
     * @var float
     *
     * @ORM\Column(name="percentage", type="float", precision=2, scale=0, nullable=true)
     */
    private $percentage;

    /**
     * @var float
     *
     * @ORM\Column(name="amount", type="float", precision=4, scale=2, nullable=true)
     */
    private $amount;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text", nullable=true)
     */
    private $description;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="validity_start", type="datetime", nullable=true)
     */
    private $validityStart;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="validity_end", type="datetime", nullable=true)
     */
    private $validityEnd;

    /**
     * @var integer
     *
     * @ORM\Column(name="max_use", type="integer", nullable=true)
     */
    private $maxUse;

    /**
     * @var integer
     *
     * @ORM\Column(name="already_used", type="integer", nullable=true)
     */
    private $alreadyUsed;


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
     * Gets the value of code.
     *
     * @return string
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * Sets the value of code.
     *
     * @param string $code the code
     *
     * @return self
     */
    public function setCode($code)
    {
        $this->code = $code;

        return $this;
    }

    /**
     * Gets the value of isPercentage.
     *
     * @return boolean
     */
    public function getIsPercentage()
    {
        return $this->isPercentage;
    }

    /**
     * Sets the value of isPercentage.
     *
     * @param boolean $isPercentage the is percentage
     *
     * @return self
     */
    public function setIsPercentage($isPercentage)
    {
        $this->isPercentage = $isPercentage;

        return $this;
    }

    /**
     * Gets the value of percentage.
     *
     * @return float
     */
    public function getPercentage()
    {
        return $this->percentage;
    }

    /**
     * Sets the value of percentage.
     *
     * @param float $percentage the percentage
     *
     * @return self
     */
    public function setPercentage($percentage)
    {
        $this->percentage = $percentage;

        return $this;
    }

    /**
     * Gets the value of amount.
     *
     * @return float
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * Sets the value of amount.
     *
     * @param float $amount the amount
     *
     * @return self
     */
    public function setAmount($amount)
    {
        $this->amount = $amount;

        return $this;
    }

    /**
     * Gets the value of description.
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Sets the value of description.
     *
     * @param string $description the description
     *
     * @return self
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Gets the value of validityStart.
     *
     * @return \DateTime
     */
    public function getValidityStart()
    {
        return $this->validityStart;
    }

    /**
     * Sets the value of validityStart.
     *
     * @param \DateTime $validityStart the validity start
     *
     * @return self
     */
    public function setValidityStart(\DateTime $validityStart)
    {
        $this->validityStart = $validityStart;

        return $this;
    }

    /**
     * Gets the value of validityEnd.
     *
     * @return \DateTime
     */
    public function getValidityEnd()
    {
        return $this->validityEnd;
    }

    /**
     * Sets the value of validityEnd.
     *
     * @param \DateTime $validityEnd the validity end
     *
     * @return self
     */
    public function setValidityEnd(\DateTime $validityEnd)
    {
        $this->validityEnd = $validityEnd;

        return $this;
    }

    /**
     * Gets the value of maxUse.
     *
     * @return integer
     */
    public function getMaxUse()
    {
        return $this->maxUse;
    }

    /**
     * Sets the value of maxUse.
     *
     * @param integer $maxUse the max use
     *
     * @return self
     */
    public function setMaxUse($maxUse)
    {
        $this->maxUse = $maxUse;

        return $this;
    }

    /**
     * Gets the value of AlreadyUsed.
     *
     * @return integer
     */
    public function getAlreadyUsed()
    {
        return $this->alreadyUsed;
    }

    /**
     * Sets the value of AlreadyUsed.
     *
     * @param integer $maxUse the AlreadyUsed
     *
     * @return self
     */
    public function setAlreadyUsed($alreadyUsed)
    {
        $this->alreadyUsed = $alreadyUsed;

        return $this;
    }

    public function __toString()
    {
        return $this->code;
    }
}
