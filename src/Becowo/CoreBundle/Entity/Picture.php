<?php

namespace Becowo\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * Picture
 *
 * @ORM\Table(name="becowo_picture", uniqueConstraints={@ORM\UniqueConstraint(name="id_UNIQUE", columns={"id"})}, indexes={@ORM\Index(name="fk_workspace_id_idx", columns={"workspace_id"})})
 * @ORM\Entity(repositoryClass="Becowo\CoreBundle\Repository\PictureRepository")
 * @ORM\HasLifecycleCallbacks
 * @ORM\EntityListeners({"Becowo\CoreBundle\EventListener\PictureListener"})
 */
class Picture
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
     * @ORM\Column(name="url", type="string", length=255, nullable=false)
     */
    private $url;

    /**
     * @var string
     *
     * @ORM\Column(name="alt", type="string", length=255, nullable=false)
     */
    private $alt;

    /**
     * @var boolean
     *
     * @ORM\Column(name="is_favorite", type="boolean", nullable=true)
     */
    private $isFavorite;

    /**
     * @var boolean
     *
     * @ORM\Column(name="is_logo", type="boolean", nullable=true)
     */
    private $isLogo;

    /**
     * @var \Becowo\CoreBundle\Entity\Workspace
     *
     * @ORM\ManyToOne(targetEntity="Becowo\CoreBundle\Entity\Workspace", inversedBy = "pictures", cascade={"persist"})
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="workspace_id", referencedColumnName="id")
     * })
     */
    private $workspace;

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
     * Set url
     *
     * @param string $url
     *
     * @return Picture
     */
    public function setUrl($url)
    {
        $this->url = $url;

        return $this;
    }

    /**
     * Get url
     *
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * Set alt
     *
     * @param string $alt
     *
     * @return Picture
     */
    public function setAlt($alt)
    {
        $this->alt = $alt;

        return $this;
    }

    /**
     * Get alt
     *
     * @return string
     */
    public function getAlt()
    {
        return $this->alt;
    }

    /**
     * Set isFavorite
     *
     * @param boolean $isFavorite
     *
     * @return Picture
     */
    public function setIsFavorite($isFavorite)
    {
        $this->isFavorite = $isFavorite;

        return $this;
    }

    /**
     * Get isFavorite
     *
     * @return boolean
     */
    public function getIsFavorite()
    {
        return $this->isFavorite;
    }

    /**
     * Set isLogo
     *
     * @param boolean $isLogo
     *
     * @return Picture
     */
    public function setIsLogo($isLogo)
    {
        $this->isLogo = $isLogo;

        return $this;
    }

    /**
     * Get isLogo
     *
     * @return boolean
     */
    public function getIsLogo()
    {
        return $this->isLogo;
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
     * @return Picture
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
    $this->url = $name;

    // On crée également le futur attribut alt de notre balise <img>
    $this->alt = $name;
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
