<?php

namespace Becowo\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * TeamMember
 *
 * @ORM\Table(name="becowo_team_member", uniqueConstraints={@ORM\UniqueConstraint(name="id_UNIQUE", columns={"id"})})
 * @ORM\Entity
 */
class TeamMember
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
     * @ORM\Column(name="firstname", type="string", length=45, nullable=true)
     */
    private $firstname;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=45, nullable=true)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=255, nullable=true)
     */
    private $email;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Becowo\CoreBundle\Entity\Workspace", mappedBy="teamMember")
     */
    private $workspace;

    /**
     * @var string
     *
     * @ORM\Column(name="job", type="string", length=55, nullable=true)
     */
    private $job;

    /**
     * @var string
     *
     * @ORM\Column(name="url_profile_picture", type="string", length=255, nullable=true)
     */
    private $urlProfilePicture;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text", nullable=true)
     */
    private $description;

    /**
     * @var string
     *
     * @ORM\Column(name="phone", type="string", length=10, nullable=true)
     */
    private $phone;

    private $file;
  
      public function getFile()
      {
        return $this->file;
      }

      public function setFile(UploadedFile $file = null)
      {
        $this->file = $file;
      }

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->workspace = new \Doctrine\Common\Collections\ArrayCollection();
    }


    /**
     * Set firstname
     *
     * @param string $firstname
     *
     * @return TeamMember
     */
    public function setFirstname($firstname)
    {
        $this->firstname = $firstname;

        return $this;
    }

    /**
     * Get firstname
     *
     * @return string
     */
    public function getFirstname()
    {
        return $this->firstname;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return TeamMember
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set email
     *
     * @param string $email
     *
     * @return TeamMember
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
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
     * Set description
     *
     * @param string $description
     *
     * @return TeamMember
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set phone
     *
     * @param string $phone
     *
     * @return TeamMember
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;

        return $this;
    }

    /**
     * Get phone
     *
     * @return string
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * Set job
     *
     * @param string $job
     *
     * @return TeamMember
     */
    public function setJob($job)
    {
        $this->job = $job;

        return $this;
    }

    /**
     * Get job
     *
     * @return string
     */
    public function getJob()
    {
        return $this->job;
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
     * Add workspace
     *
     * @param \Becowo\CoreBundle\Entity\Workspace $workspace
     *
     * @return TeamMember
     */
    public function addWorkspace(\Becowo\CoreBundle\Entity\Workspace $workspace)
    {
        $this->workspace[] = $workspace;

        return $this;
    }

    /**
     * Remove workspace
     *
     * @param \Becowo\CoreBundle\Entity\Workspace $workspace
     */
    public function removeWorkspace(\Becowo\CoreBundle\Entity\Workspace $workspace)
    {
        $this->workspace->removeElement($workspace);
    }

    /**
     * Get workspace
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getWorkspace()
    {
        return $this->workspace;
    }

    public function __toString()
    {
        return $this->name;
    }

    public function upload($wsName)
    {
    // Si jamais il n'y a pas de fichier (champ facultatif), on ne fait rien
    if (null === $this->file) {
      return;
    }

    // On récupère le nom original du fichier de l'internaute
    $name = $this->file->getClientOriginalName();

    // On déplace le fichier envoyé dans le répertoire de notre choix
    $this->file->move($this->getUploadRootDir($wsName), $name);

    // On sauvegarde le nom de fichier dans notre attribut $url
    $this->urlProfilePicture = $name;
  }

  public function getUploadDir($wsName)
  {
    // On retourne le chemin relatif vers l'image pour un navigateur (relatif au répertoire /web donc)
    return 'images/Workspaces/' . $wsName;
  }

  protected function getUploadRootDir($wsName)
  {
    // On retourne le chemin relatif vers l'image pour notre code PHP
    return __DIR__.'/../../../../web/'.$this->getUploadDir($wsName);
  }
}
