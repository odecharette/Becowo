<?php

namespace Becowo\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * InfoIsPublic
 *
 * @ORM\Table(name="info_is_public", uniqueConstraints={@ORM\UniqueConstraint(name="id_UNIQUE", columns={"id"})}, indexes={@ORM\Index(name="fk_member_id_idx", columns={"member_id"})})
 * @ORM\Entity
 */
class InfoIsPublic
{
    /**
     * @var string
     *
     * @ORM\Column(name="list_of_field", type="text", nullable=true)
     */
    private $listOfField;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var \Becowo\CoreBundle\Entity\Member
     *
     * @ORM\ManyToOne(targetEntity="Becowo\CoreBundle\Entity\Member")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="member_id", referencedColumnName="id")
     * })
     */
    private $member;



    /**
     * Set listOfField
     *
     * @param string $listOfField
     *
     * @return InfoIsPublic
     */
    public function setListOfField($listOfField)
    {
        $this->listOfField = $listOfField;

        return $this;
    }

    /**
     * Get listOfField
     *
     * @return string
     */
    public function getListOfField()
    {
        return $this->listOfField;
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
     * Set member
     *
     * @param \Becowo\CoreBundle\Entity\Member $member
     *
     * @return InfoIsPublic
     */
    public function setMember(\Becowo\CoreBundle\Entity\Member $member = null)
    {
        $this->member = $member;

        return $this;
    }

    /**
     * Get member
     *
     * @return \Becowo\CoreBundle\Entity\Member
     */
    public function getMember()
    {
        return $this->member;
    }
}
