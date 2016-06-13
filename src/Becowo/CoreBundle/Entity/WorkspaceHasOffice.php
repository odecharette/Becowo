<?php

// entité créée maunellement contrairement aux autres
// gère la relation ManyToMany avec attribut

namespace Becowo\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="workspace_has_office", uniqueConstraints={@ORM\UniqueConstraint(name="id_UNIQUE", columns={"id"})})
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
   */
  private $desk_qty;

  /**
   * @ORM\ManyToOne(targetEntity="Becowo\CoreBundle\Entity\Workspace")
   * @ORM\JoinColumn(nullable=false)
   */
  private $workspace;

  /**
   * @ORM\ManyToOne(targetEntity="Becowo\CoreBundle\Entity\Office", fetch="EAGER")
   * @ORM\JoinColumn(nullable=false)
   */
  private $office;

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
}