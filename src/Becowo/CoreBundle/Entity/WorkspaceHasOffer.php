<?php

// entité créée maunellement contrairement aux autres
// gère la relation ManyToMany avec attribut

namespace Becowo\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="becowo_workspace_has_offer", uniqueConstraints={@ORM\UniqueConstraint(name="id_UNIQUE", columns={"id"})})
 * @ORM\Entity(repositoryClass="Becowo\CoreBundle\Repository\WorkspaceHasOfferRepository")
 */
class WorkspaceHasOffer
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
   * @ORM\ManyToOne(targetEntity="Becowo\CoreBundle\Entity\Offer", fetch="EAGER")
   * @ORM\JoinColumn(nullable=false)
   */
  private $offer;

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
    public function setId($id)
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
     * Gets the value of offer.
     *
     * @return mixed
     */
    public function getOffer()
    {
        return $this->offer;
    }

    /**
     * Sets the value of offer.
     *
     * @param mixed $offer the offer
     *
     * @return self
     */
    public function setOffer($offer)
    {
        $this->offer = $offer;

        return $this;
    }

}
