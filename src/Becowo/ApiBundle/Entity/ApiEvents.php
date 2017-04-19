<?php

namespace Becowo\ApiBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use \DateTime;

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
     * @var string
     *
     * @ORM\Column(name="google_calendar_id", type="string")
     */
    private $googleCalendarId;

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
    public function setWorkspace(\Becowo\CoreBundle\Entity\Workspace $workspace)
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
    public function setFacebookPageId($facebookPageId)
    {
        $this->facebookPageId = $facebookPageId;

        return $this;
    }

    /**
     * Gets the value of googleCalendarId.
     *
     * @return string
     */
    public function getGoogleCalendarId()
    {
        return $this->googleCalendarId;
    }

    /**
     * Sets the value of googleCalendarId.
     *
     * @param string $googleCalendarId the google calendar id
     *
     * @return self
     */
    public function setGoogleCalendarId($googleCalendarId)
    {
        $this->googleCalendarId = $googleCalendarId;

        return $this;
    }
}
