<?php

// entité créée maunellement contrairement aux autres
// gère la relation ManyToMany avec attribut

namespace Becowo\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="becowo_workspace_has_amenities", uniqueConstraints={@ORM\UniqueConstraint(name="id_UNIQUE", columns={"id"})})
 * @ORM\Entity(repositoryClass="Becowo\CoreBundle\Repository\WorkspaceHasAmenitiesRepository")
 */
class WorkspaceHasAmenities
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
   * @ORM\ManyToOne(targetEntity="Becowo\CoreBundle\Entity\Amenities", fetch="EAGER")
   * @ORM\JoinColumn(nullable=false)
   */
  private $amenities;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=255, nullable=true)
     */
    private $description;

    /**
     * @var string
     *
     * @ORM\Column(name="label", type="string", length=50, nullable=true)
     */
    private $label;


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
     * Gets the value of description.
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Sets the value of description.
     *
     * @param string $description the description
     *
     * @return self
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Gets the value of label.
     *
     * @return string
     */
    public function getLabel()
    {
        return $this->label;
    }

    /**
     * Sets the value of label.
     *
     * @param string $label the label
     *
     * @return self
     */
    public function setLabel($label)
    {
        $this->label = $label;

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
     * Gets the value of Amenities.
     *
     * @return mixed
     */
    public function getAmenities()
    {
        return $this->amenities;
    }

    /**
     * Sets the value of Amenities.
     *
     * @param mixed $Amenities the Amenities
     *
     * @return self
     */
    public function setAmenities($amenities)
    {
        $this->amenities = $amenities;

        return $this;
    }
}
