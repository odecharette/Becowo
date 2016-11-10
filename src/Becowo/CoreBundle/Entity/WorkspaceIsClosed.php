<?php

namespace Becowo\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * WorkspaceIsClosed
 *
 * @ORM\Table(name="becowo_workspace_is_closed", uniqueConstraints={@ORM\UniqueConstraint(name="id_UNIQUE", columns={"id"})}, indexes={@ORM\Index(name="fk_workspace_id_idx", columns={"workspace_id"})})
 * @ORM\Entity(repositoryClass="Becowo\CoreBundle\Repository\WorkspaceIsClosedRepository")
 */
class WorkspaceIsClosed
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
     * @var \Becowo\CoreBundle\Entity\Workspace
     *
     * @ORM\ManyToOne(targetEntity="Becowo\CoreBundle\Entity\Workspace")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="workspace_id", referencedColumnName="id")
     * })
     */
    private $workspace;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="closed_date", type="datetime")
     */
    private $closedDate;

    
    /**
     * Constructor
     */
    public function __construct()
    {

    }


    /**
     * Set closedDate
     *
     * @param \DateTime $closedDate
     *
     * @return WorkspaceIsClosed
     */
    public function setClosedDate($closedDate)
    {
        $this->closedDate = $closedDate;

        return $this;
    }

    /**
     * Get closedDate
     *
     * @return \DateTime
     */
    public function getClosedDate()
    {
        return $this->closedDate;
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
     * @return WorkspaceIsClosed
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
}
