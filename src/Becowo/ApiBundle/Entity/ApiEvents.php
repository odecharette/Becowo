<?php

namespace Becowo\ApiBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * APiEvents
 *
 * @ORM\Table(name="becowo_api_events", uniqueConstraints={@ORM\UniqueConstraint(name="id_UNIQUE", columns={"id"})})
 * @ORM\Entity(repositoryClass="Becowo\ApiBundle\Repository\ApiEventsRepository")
 */
class ApiEvents
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
     * @var string
     *
     * @ORM\Column(name="facebook_page_id", type="string")
     */
    private $facebookPageId;

    /**
     * @var datetime
     *
     * @ORM\Column(name="facebook_last_update", type="datetime", nullable=true)
     */
    private $facebookLastUpdate;

    /**
     * Constructor
     */
    public function __construct()
    {
    }



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
     * Gets the }).
     *
     * @return \Becowo\CoreBundle\Entity\Workspace
     */
    public function getWorkspace()
    {
        return $this->workspace;
    }

    /**
     * Sets the }).
     *
     * @param \Becowo\CoreBundle\Entity\Workspace $workspace the workspace
     *
     * @return self
     */
    private function setWorkspace(\Becowo\CoreBundle\Entity\Workspace $workspace)
    {
        $this->workspace = $workspace;

        return $this;
    }

    /**
     * Gets the value of facebookPageId.
     *
     * @return string
     */
    public function getFacebookPageId()
    {
        return $this->facebookPageId;
    }

    /**
     * Sets the value of facebookPageId.
     *
     * @param string $facebookPageId the facebook page id
     *
     * @return self
     */
    private function setFacebookPageId($facebookPageId)
    {
        $this->facebookPageId = $facebookPageId;

        return $this;
    }


    /**
     * Gets the value of facebookLastUpdate.
     *
     * @return datetime
     */
    public function getFacebookLastUpdate()
    {
        return $this->facebookLastUpdate;
    }

    /**
     * Sets the value of facebookLastUpdate.
     *
     * @param datetime $facebookLastUpdate the facebook last update
     *
     * @return self
     */
    private function setFacebookLastUpdate(datetime $facebookLastUpdate)
    {
        $this->facebookLastUpdate = $facebookLastUpdate;

        return $this;
    }
}
