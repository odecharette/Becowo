<?php

namespace Becowo\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Comment
 *
 * @ORM\Table(name="becowo_comment", uniqueConstraints={@ORM\UniqueConstraint(name="id_UNIQUE", columns={"id"})}, indexes={@ORM\Index(name="fk_member_id_idx", columns={"member_id"}), @ORM\Index(name="fk_workspace_id_idx", columns={"workspace_id"})})
 * @ORM\Entity(repositoryClass="Becowo\CoreBundle\Repository\CommentRepository")
 * @ORM\EntityListeners({"Becowo\CoreBundle\EventListener\CommentListener"})
  * @ORM\HasLifecycleCallbacks() 
 */
class Comment
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
     * @ORM\Column(name="post", type="text", nullable=true)
     */
    private $post;

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
     * @var \DateTime
     *
     * @ORM\Column(name="posted_on", type="datetime")
     */
    private $postedOn;

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
    public function __construct($workspace=null, $member=null)
    {
        $this->postedOn = new \DateTime();
        $this->workspace = $workspace;
        $this->member = $member;
    }

    /**
     * Set post
     *
     * @param string $post
     *
     * @return Comment
     */
    public function setPost($post)
    {
        $this->post = $post;

        return $this;
    }

    /**
     * Get post
     *
     * @return string
     */
    public function getPost()
    {
        return $this->post;
    }

    /**
     * Set postedOn
     *
     * @param \DateTime $postedOn
     *
     * @return Comment
     */
    public function setPostedOn($postedOn)
    {
        $this->postedOn = $postedOn;

        return $this;
    }

    /**
     * Get postedOn
     *
     * @return \DateTime
     */
    public function getPostedOn()
    {
        return $this->postedOn;
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
     * @return Comment
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
     * @return Comment
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
     * Set Average 
     * 
     * @ORM\PrePersist 
     */  
    public function setAverage()  
    {  
        $this->scoreAvg = ($this->score1 + $this->score2 + $this->score3 + $this->score4) / 4;  
    }  


}
