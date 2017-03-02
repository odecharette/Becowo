<?php

namespace Becowo\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * CommunityNetwork
 *
 * @ORM\Table(name="becowo_community_network", uniqueConstraints={@ORM\UniqueConstraint(name="id_UNIQUE", columns={"id"})})
 * @ORM\Entity(repositoryClass="Becowo\CoreBundle\Repository\CommunityNetworkRepository")
 */
class CommunityNetwork
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
     * @ORM\Column(name="name", type="string", length=55, nullable=true)
     */
    private $name;

    /**
     * @var \Becowo\MemberBundle\Entity\Member
     *
     * @ORM\ManyToOne(targetEntity="Becowo\MemberBundle\Entity\Member")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="admin_member_id", referencedColumnName="id")
     * })
     */
    private $adminMember;

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
    private function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Gets the value of name.
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Sets the value of name.
     *
     * @param string $name the name
     *
     * @return self
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Gets the }).
     *
     * @return \Becowo\MemberBundle\Entity\Member
     */
    public function getAdminMember()
    {
        return $this->adminMember;
    }

    /**
     * Sets the }).
     *
     * @param \Becowo\MemberBundle\Entity\Member $adminMember the admin member
     *
     * @return self
     */
    public function setAdminMember(\Becowo\MemberBundle\Entity\Member $adminMember)
    {
        $this->adminMember = $adminMember;

        return $this;
    }

    public function __toString()
    {
        return $this->name;
    }
}
