<?php

namespace Becowo\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * ProfilePicture
 *
 * @ORM\Table(name="profile_picture", uniqueConstraints={@ORM\UniqueConstraint(name="id_UNIQUE", columns={"id"})})
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks()
 */
class ProfilePicture
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


    // Permet la gestion d'un champ FileType pour uploader un fichier
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
     * @ORM\PrePersist()
     * @ORM\PreUpdate()
     * 
     * Upload the profile picture
     * 
     * @return mixed
     */
    public function upload()
  {
    // Si jamais il n'y a pas de fichier (champ facultatif), on ne fait rien
    if (null === $this->file) {
      return;
    }

    // On récupère le nom original du fichier de l'internaute et on ajoute l'id pour que l'image soit unique
    $name = $this->file->getClientOriginalName();

    // On déplace le fichier envoyé dans le répertoire de notre choix
    $this->file->move($this->getUploadRootDir(), $name);

    // On sauvegarde le nom de fichier dans notre attribut $url
    $this->url = $name;

    // On crée également le futur attribut alt de notre balise <img>
    $this->alt = $name;
  }

  public function getUploadDir()
  {
    // On retourne le chemin relatif vers l'image pour un navigateur (relatif au répertoire /web donc)
    return 'images/ProfilePictures';
  }

  protected function getUploadRootDir()
  {
    // On retourne le chemin relatif vers l'image pour notre code PHP
    return __DIR__.'/../../../../web/'.$this->getUploadDir();
  }

    /**
     * Set url
     *
     * @param string $url
     *
     * @return ProfilePicture
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
     * @return ProfilePicture
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
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    
}
