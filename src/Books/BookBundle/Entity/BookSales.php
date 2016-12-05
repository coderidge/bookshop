<?php

namespace Books\BookBundle\Entity;

/**
 * BookSales
 */
class BookSales
{
    /**
     * @var integer
     */
    private $bookId;

    /**
     * @var integer
     */
    private $userId;

    /**
     * @var integer
     */
    private $id;


    /**
     * Set bookId
     *
     * @param integer $bookId
     *
     * @return BookSales
     */
    public function setBookId($bookId)
    {
        $this->bookId = $bookId;

        return $this;
    }

    /**
     * Get bookId
     *
     * @return integer
     */
    public function getBookId()
    {
        return $this->bookId;
    }

    /**
     * Set userId
     *
     * @param integer $userId
     *
     * @return BookSales
     */
    public function setUserId($userId)
    {
        $this->userId = $userId;

        return $this;
    }

    /**
     * Get userId
     *
     * @return integer
     */
    public function getUserId()
    {
        return $this->userId;
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

