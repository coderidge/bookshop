<?php

namespace Books\BookBundle\Entity;

/**
 * User
 */
class User
{
    /**
     * @var string
     */
    private $email;

    /**
     * @var integer
     */
    private $id;


    /**
     * Set email
     *
     * @param string $email
     *
     * @return User
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
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }
}

