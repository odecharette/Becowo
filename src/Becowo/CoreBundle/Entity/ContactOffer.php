<?php

namespace Becowo\CoreBundle\Entity;


class ContactOffer
{
    private $wsName;
    private $email;
    private $street;
    private $postcode;
    private $city;
    private $phone;
    private $nbDesk;
    private $comments;


    /**
     * Gets the value of WsName.
     *
     * @return mixed
     */
    public function getWsName()
    {
        return $this->wsName;
    }

    /**
     * Sets the value of WsName.
     *
     * @param mixed $WsName the ws name
     *
     * @return self
     */
    public function setWsName($wsName)
    {
        $this->wsName = $wsName;

        return $this;
    }

    /**
     * Gets the value of email.
     *
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Sets the value of email.
     *
     * @param mixed $email the email
     *
     * @return self
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Gets the value of street.
     *
     * @return mixed
     */
    public function getStreet()
    {
        return $this->street;
    }

    /**
     * Sets the value of street.
     *
     * @param mixed $street the street
     *
     * @return self
     */
    public function setStreet($street)
    {
        $this->street = $street;

        return $this;
    }

    /**
     * Gets the value of postcode.
     *
     * @return mixed
     */
    public function getPostcode()
    {
        return $this->postcode;
    }

    /**
     * Sets the value of postcode.
     *
     * @param mixed $postcode the postcode
     *
     * @return self
     */
    public function setPostcode($postcode)
    {
        $this->postcode = $postcode;

        return $this;
    }

    /**
     * Gets the value of city.
     *
     * @return mixed
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * Sets the value of city.
     *
     * @param mixed $city the city
     *
     * @return self
     */
    public function setCity($city)
    {
        $this->city = $city;

        return $this;
    }

    /**
     * Gets the value of phone.
     *
     * @return mixed
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * Sets the value of phone.
     *
     * @param mixed $phone the phone
     *
     * @return self
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;

        return $this;
    }

    /**
     * Gets the value of nbDesk.
     *
     * @return mixed
     */
    public function getNbDesk()
    {
        return $this->nbDesk;
    }

    /**
     * Sets the value of nbDesk.
     *
     * @param mixed $nbDesk the nb desk
     *
     * @return self
     */
    public function setNbDesk($nbDesk)
    {
        $this->nbDesk = $nbDesk;

        return $this;
    }

    /**
     * Gets the value of comments.
     *
     * @return mixed
     */
    public function getComments()
    {
        return $this->comments;
    }

    /**
     * Sets the value of comments.
     *
     * @param mixed $comments the comments
     *
     * @return self
     */
    public function setComments($comments)
    {
        $this->comments = $comments;

        return $this;
    }
}
