<?php

namespace Becowo\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Comment
 *
 * @ORM\Table(name="comment", uniqueConstraints={@ORM\UniqueConstraint(name="id_UNIQUE", columns={"id"})}, indexes={@ORM\Index(name="fk_member_id_idx", columns={"member_id"}), @ORM\Index(name="fk_workspace_id_idx", columns={"workspace_id"})})
 * @ORM\Entity
 */
class Comment
{
    /**
     * @var string
     *
     * @ORM\Column(name="post", type="text", nullable=true)
     */
    private $post;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="posted_on", type="datetime")
     */
    private $postedOn;

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
    public function __construct($workspace, $member)
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
}
