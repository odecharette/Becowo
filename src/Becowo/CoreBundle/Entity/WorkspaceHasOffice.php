<?php

// entité créée maunellement contrairement aux autres
// gère la relation ManyToMany avec attribut

namespace Becowo\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Table(name="becowo_workspace_has_office", uniqueConstraints={@ORM\UniqueConstraint(name="id_UNIQUE", columns={"id"})})
 * @ORM\Entity(repositoryClass="Becowo\CoreBundle\Repository\WorkspaceHasOfficeRepository")
 * @ORM\EntityListeners({"Becowo\CoreBundle\EventListener\WorkspaceHasOfficeListener"})
 */
class WorkspaceHasOffice
{
  /**
   * @ORM\Column(name="id", type="integer")
   * @ORM\Id
   * @ORM\GeneratedValue(strategy="IDENTITY")
   */
  private $id;

  /**
   * @ORM\Column(name="desk_qty", type="integer")
   * @Assert\NotNull(message="La capacité est obligatoire")
   */
  private $desk_qty;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=45, nullable=false)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=255, nullable=true)
     */
    private $description;

    /**
     * @var string
     *
     * @ORM\Column(name="url_profile_picture", type="string", length=255, nullable=true)
     */
    private $urlProfilePicture;

  /**
   * @ORM\ManyToOne(targetEntity="Becowo\CoreBundle\Entity\Workspace", inversedBy="workspaceHasOfficeList")
   * @ORM\JoinColumn(nullable=false)
   */
  private $workspace;

  /**
   * @ORM\ManyToOne(targetEntity="Becowo\CoreBundle\Entity\Office", fetch="EAGER")
   * @ORM\JoinColumn(nullable=false)
   */
  private $office;
  
  private $file;

  /**
     * @var Becowo\CoreBundle\Entity\Price $price
     *
     * @ORM\OneToOne(targetEntity = "Becowo\CoreBundle\Entity\Price", inversedBy = "workspaceHasOffice", cascade={"persist"})
     */
    private $price;
  
  public function getFile()
  {
    return $this->file;
  }

  public function setFile(UploadedFile $file = null)
  {
    $this->file = $file;
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
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Gets the value of desk_qty.
     *
     * @return mixed
     */
    public function getDeskQty()
    {
        return $this->desk_qty;
    }

    /**
     * Sets the value of desk_qty.
     *
     * @param mixed $desk_qty the desk qty
     *
     * @return self
     */
    public function setDeskQty($desk_qty)
    {
        $this->desk_qty = $desk_qty;

        return $this;
    }

    /**
     * Set urlProfilePicture
     *
     * @param string $urlProfilePicture
     *
     * @return TeamMember
     */
    public function setUrlProfilePicture($urlProfilePicture)
    {
        $this->urlProfilePicture = $urlProfilePicture;

        return $this;
    }

    /**
     * Get urlProfilePicture
     *
     * @return string
     */
    public function getUrlProfilePicture()
    {
        return $this->urlProfilePicture;
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
     * Gets the value of office.
     *
     * @return mixed
     */
    public function getOffice()
    {
        return $this->office;
    }

    /**
     * Sets the value of office.
     *
     * @param mixed $office the office
     *
     * @return self
     */
    public function setOffice($office)
    {
        $this->office = $office;

        return $this;
    }

  
    /**
     * Gets the value of name.
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Sets the value of name.
     *
     * @param string $name the name
     *
     * @return self
     */
    public function setName($name)
    {
        $this->name = $name;

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
     * Set price
     *
     * @param \Becowo\CoreBundle\Entity\Price $price
     *
     * @return Price
     */
    public function setPrice(\Becowo\CoreBundle\Entity\Price $price = null)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Get Price
     *
     * @return \Becowo\CoreBundle\Entity\Price
     */
    public function getPrice()
    {
        return $this->price;
    }

    public function getFullPathProfilePicture()
    {
        $parent = $this->getWorkspace()->getName();
        return 'images/Workspaces/' . $parent . '/' . $this->urlProfilePicture;
    }

    public function __toString()
    {
        return $this->name;
    }

}
