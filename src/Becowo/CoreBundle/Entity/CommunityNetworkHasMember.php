<?php

// entité créée maunellement contrairement aux autres
// gère la relation ManyToMany avec attribut

namespace Becowo\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="becowo_community_network_has_member", uniqueConstraints={@ORM\UniqueConstraint(name="id_UNIQUE", columns={"id"})})
 * @ORM\Entity(repositoryClass="Becowo\CoreBundle\Repository\CommunityNetworkHasMemberRepository")
 */
class CommunityNetworkHasMember
{
  /**
   * @ORM\Column(name="id", type="integer")
   * @ORM\Id
   * @ORM\GeneratedValue(strategy="IDENTITY")
   */
  private $id;

  /**
   * @ORM\ManyToOne(targetEntity="Becowo\MemberBundle\Entity\Member")
   * @ORM\JoinColumn(nullable=false)
   */
  private $member;

  /**
   * @ORM\ManyToOne(targetEntity="Becowo\CoreBundle\Entity\CommunityNetwork")
   * @ORM\JoinColumn(nullable=false)
   */
  private $communityNetwork;

 

    /**
     * Gets the value of id.
     *
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Sets the value of id.
     *
     * @param mixed $id the id
     *
     * @return self
     */
    private function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Gets the value of member.
     *
     * @return mixed
     */
    public function getMember()
    {
        return $this->member;
    }

    /**
     * Sets the value of member.
     *
     * @param mixed $member the member
     *
     * @return self
     */
    public function setMember($member)
    {
        $this->member = $member;

        return $this;
    }

    /**
     * Gets the value of communityNetwork.
     *
     * @return mixed
     */
    public function getCommunityNetwork()
    {
        return $this->communityNetwork;
    }

    /**
     * Sets the value of communityNetwork.
     *
     * @param mixed $communityNetwork the community network
     *
     * @return self
     */
    public function setCommunityNetwork($communityNetwork)
    {
        $this->communityNetwork = $communityNetwork;

        return $this;
    }
}
