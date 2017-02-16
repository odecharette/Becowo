<?php

// entité créée maunellement contrairement aux autres
// gère la relation ManyToMany avec attribut

namespace Becowo\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="becowo_workspace_has_team_member", uniqueConstraints={@ORM\UniqueConstraint(name="id_UNIQUE", columns={"id"})})
 * @ORM\Entity(repositoryClass="Becowo\CoreBundle\Repository\WorkspaceHasTeamMemberRepository")
 */
class WorkspaceHasTeamMember
{
  /**
   * @ORM\Column(name="id", type="integer")
   * @ORM\Id
   * @ORM\GeneratedValue(strategy="IDENTITY")
   */
  private $id;

  /**
   * @ORM\ManyToOne(targetEntity="Becowo\CoreBundle\Entity\Workspace")
   * @ORM\JoinColumn(nullable=false)
   */
  private $workspace;

  /**
   * @ORM\ManyToOne(targetEntity="Becowo\CoreBundle\Entity\TeamMember", cascade={"persist"}, fetch="EAGER")
   * @ORM\JoinColumn(nullable=false)
   */
  private $teamMember;

    /**
     * @var boolean
     *
     * @ORM\Column(name="receive_email_booking", type="boolean", nullable=true)
     */
    private $receiveEmailBooking;

    /**
     * @var boolean
     *
     * @ORM\Column(name="receive_email_contact", type="boolean", nullable=true)
     */
    private $receiveEmailContact;
  

    public function __toString()
    {
        return $this->workspace->getName();
    }


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
     * Gets the value of workspace.
     *
     * @return mixed
     */
    public function getWorkspace()
    {
        return $this->workspace;
    }

    /**
     * Sets the value of workspace.
     *
     * @param mixed $workspace the workspace
     *
     * @return self
     */
    public function setWorkspace($workspace)
    {
        $this->workspace = $workspace;

        return $this;
    }

    /**
     * Gets the value of member.
     *
     * @return mixed
     */
    public function getTeamMember()
    {
        return $this->teamMember;
    }

    /**
     * Sets the value of teamMember.
     *
     * @param mixed $teamMember the teamMember
     *
     * @return self
     */
    public function setTeamMember($teamMember)
    {
        $this->teamMember = $teamMember;

        return $this;
    }

    /**
     * Gets the value of receiveEmailBooking.
     *
     * @return boolean
     */
    public function getReceiveEmailBooking()
    {
        return $this->receiveEmailBooking;
    }

    /**
     * Sets the value of receiveEmailBooking.
     *
     * @param boolean $receiveEmailBooking the receive email booking
     *
     * @return self
     */
    public function setReceiveEmailBooking($receiveEmailBooking)
    {
        $this->receiveEmailBooking = $receiveEmailBooking;

        return $this;
    }

    /**
     * Gets the value of receiveEmailContact.
     *
     * @return boolean
     */
    public function getReceiveEmailContact()
    {
        return $this->receiveEmailContact;
    }

    /**
     * Sets the value of receiveEmailContact.
     *
     * @param boolean $receiveEmailContact the receive email booking
     *
     * @return self
     */
    public function setReceiveEmailContact($receiveEmailContact)
    {
        $this->receiveEmailContact = $receiveEmailContact;

        return $this;
    }
}
