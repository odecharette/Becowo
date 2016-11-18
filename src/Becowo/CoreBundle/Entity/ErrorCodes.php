<?php

namespace Becowo\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ErrorCodes
 *
 * @ORM\Table(name="becowo_error_codes", uniqueConstraints={@ORM\UniqueConstraint(name="id_UNIQUE", columns={"id"})})
 * @ORM\Entity(repositoryClass="Becowo\CoreBundle\Repository\ErrorCodesRepository")
 */
class ErrorCodes
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
     * @ORM\Column(name="error_code", type="string", length=5)
     */
    private $errorCode;

    /**
     * @var string
     *
     * @ORM\Column(name="sentence", type="string", length=255)
     */
    private $sentence;


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
     * Gets the value of errorCode.
     *
     * @return string
     */
    public function getErrorCode()
    {
        return $this->errorCode;
    }

    /**
     * Sets the value of errorCode.
     *
     * @param string $errorCode the error code
     *
     * @return self
     */
    private function setErrorCode($errorCode)
    {
        $this->errorCode = $errorCode;

        return $this;
    }

    /**
     * Gets the value of sentence.
     *
     * @return string
     */
    public function getSentence()
    {
        return $this->sentence;
    }

    /**
     * Sets the value of sentence.
     *
     * @param string $sentence the sentence
     *
     * @return self
     */
    private function setSentence($sentence)
    {
        $this->sentence = $sentence;

        return $this;
    }
}
