<?php

namespace Becowo\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Vote
 *
 * @ORM\Table(name="becowo_vote", uniqueConstraints={@ORM\UniqueConstraint(name="id_UNIQUE", columns={"id"})}, indexes={@ORM\Index(name="fk_member_id_idx", columns={"member_id"}), @ORM\Index(name="fk_workspace_id_idx", columns={"workspace_id"})})
 * @ORM\Entity(repositoryClass="Becowo\CoreBundle\Repository\VoteRepository")
 *
 */
class Vote
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
     * @var \DateTime
     *
     * @ORM\Column(name="vote_date", type="datetime")
     */
    private $voteDate;

    /**
     * @var integer
     *
     * @ORM\Column(name="devenir_zen", type="integer", nullable=false)
     */
    private $devenirZen = '0';
    

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
     * @var \Becowo\MemberBundle\Entity\Member
     *
     * @ORM\ManyToOne(targetEntity="Becowo\MemberBundle\Entity\Member")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="member_id", referencedColumnName="id")
     * })
     */
    private $member;

    /**
     * @var string
     *
     * @ORM\Column(name="email_vote", type="string")
     */
    private $emailVote;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->voteDate = new \DateTime();
    }


    /**
     * Set voteDate
     *
     * @param \DateTime $voteDate
     *
     * @return Vote
     */
    public function setVoteDate($voteDate)
    {
        $this->voteDate = $voteDate;

        return $this;
    }

    /**
     * Get voteDate
     *
     * @return \DateTime
     */
    public function getVoteDate()
    {
        return $this->voteDate;
    }

    /**
     * Set devenirZen
     *
     * @param integer $devenirZen
     *
     * @return Vote
     */
    public function setDevenirZen($devenirZen)
    {
        $this->devenirZen = $devenirZen;

        return $this;
    }

    /**
     * Get devenirZen
     *
     * @return integer
     */
    public function getDevenirZen()
    {
        return $this->devenirZen;
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
     * @return Vote
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
     * Set member
     *
     * @param \Becowo\MemberBundle\Entity\Member $member
     *
     * @return Vote
     */
    public function setMember(\Becowo\MemberBundle\Entity\Member $member = null)
    {
        $this->member = $member;

        return $this;
    }

    /**
     * Get member
     *
     * @return \Becowo\MemberBundle\Entity\Member
     */
    public function getMember()
    {
        return $this->member;
    }


    /**
     * Get emailVote
     *
     * @return \String
     */
    public function getEmailVote()
    {
        return $this->emailVote;
    }

    /**
     * Set emailVote
     *
     * @param string $emailVote
     *
     * @return Vote
     */
    public function setEmailVote($emailVote)
    {
        $this->emailVote = $emailVote;

        return $this;
    }

}
