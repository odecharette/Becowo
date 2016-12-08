<?php

namespace Becowo\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Vote
 *
 * @ORM\Table(name="becowo_vote", uniqueConstraints={@ORM\UniqueConstraint(name="id_UNIQUE", columns={"id"})}, indexes={@ORM\Index(name="fk_member_id_idx", columns={"member_id"}), @ORM\Index(name="fk_workspace_id_idx", columns={"workspace_id"})})
 * @ORM\Entity(repositoryClass="Becowo\CoreBundle\Repository\VoteRepository")
 *
 * @ORM\HasLifecycleCallbacks() 
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
     * @ORM\Column(name="score1", type="integer", nullable=false)
     */
    private $score1 = '0';

    /**
     * @var integer
     *
     * @ORM\Column(name="score2", type="integer", nullable=false)
     */
    private $score2 = '0';

    /**
     * @var integer
     *
     * @ORM\Column(name="score3", type="integer", nullable=false)
     */
    private $score3 = '0';

    /**
     * @var integer
     *
     * @ORM\Column(name="score4", type="integer", nullable=false)
     */
    private $score4 = '0';

    /**
     * @var string
     *
     * @ORM\Column(name="score_avg", type="decimal", precision=4, scale=2)
     */
    private $scoreAvg;


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
     * Set score1
     *
     * @param integer $score1
     *
     * @return Vote
     */
    public function setScore1($score1)
    {
        $this->score1 = $score1;

        return $this;
    }

    /**
     * Get score1
     *
     * @return integer
     */
    public function getScore1()
    {
        return $this->score1;
    }

    /**
     * Set score2
     *
     * @param integer $score2
     *
     * @return Vote
     */
    public function setScore2($score2)
    {
        $this->score2 = $score2;

        return $this;
    }

    /**
     * Get score2
     *
     * @return integer
     */
    public function getScore2()
    {
        return $this->score2;
    }

    /**
     * Set score3
     *
     * @param integer $score3
     *
     * @return Vote
     */
    public function setScore3($score3)
    {
        $this->score3 = $score3;

        return $this;
    }

    /**
     * Get score3
     *
     * @return integer
     */
    public function getScore3()
    {
        return $this->score3;
    }

    /**
     * Set score4
     *
     * @param integer $score4
     *
     * @return Vote
     */
    public function setScore4($score4)
    {
        $this->score4 = $score4;

        return $this;
    }

    /**
     * Get score4
     *
     * @return integer
     */
    public function getScore4()
    {
        return $this->score4;
    }

    /**
     * Set scoreAvg
     *
     * @param string $scoreAvg
     *
     * @return Vote
     */
    public function setScoreAvg($scoreAvg)
    {
        $this->scoreAvg = $scoreAvg;

        return $this;
    }

    /**
     * Get scoreAvg
     *
     * @return string
     */
    public function getScoreAvg()
    {
        return $this->scoreAvg;
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
     * Set Averafe 
     * 
     * @ORM\PrePersist 
     */  
    public function setAverage()  
    {  
        $this->scoreAvg = ($this->score1 + $this->score2 + $this->score3 + $this->score4) / 4;  
    }  

}
