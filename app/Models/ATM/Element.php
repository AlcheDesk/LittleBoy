<?php
/**
 * Created by PhpStorm.
 * User: scott.fu
 * Date: 2018/1/23
 * Time: 18:54
 */

namespace App\Models\ATM;

class Element
{

    private $id; //int
    private $name; //String
    private $comment; //String
    private $locatorValue; //String
    private $htmlPositionX; //String
    private $htmlPositionY; //String
    private $active; //boolean
    private $createdAt; //Date
    private $updatedAt; //Date
    private $type; //String
    private $locatorType;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getComment()
    {
        return $this->comment;
    }

    /**
     * @param mixed $comment
     */
    public function setComment($comment)
    {
        $this->comment = $comment;
    }

    /**
     * @return mixed
     */
    public function getLocatorValue()
    {
        return $this->locatorValue;
    }

    /**
     * @param mixed $locatorValue
     */
    public function setLocatorValue($locatorValue)
    {
        $this->locatorValue = $locatorValue;
    }

    /**
     * @return mixed
     */
    public function getHtmlPositionX()
    {
        return $this->htmlPositionX;
    }

    /**
     * @param mixed $htmlPositionX
     */
    public function setHtmlPositionX($htmlPositionX)
    {
        $this->htmlPositionX = $htmlPositionX;
    }

    /**
     * @return mixed
     */
    public function getHtmlPositionY()
    {
        return $this->htmlPositionY;
    }

    /**
     * @param mixed $htmlPositionY
     */
    public function setHtmlPositionY($htmlPositionY)
    {
        $this->htmlPositionY = $htmlPositionY;
    }

    /**
     * @return mixed
     */
    public function getActive()
    {
        return $this->active;
    }

    /**
     * @param mixed $active
     */
    public function setActive($active)
    {
        $this->active = $active;
    }

    /**
     * @return mixed
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * @param mixed $createdAt
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;
    }

    /**
     * @return mixed
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * @param mixed $updatedAt
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;
    }

    /**
     * @return mixed
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param mixed $type
     */
    public function setType($type)
    {
        $this->type = $type;
    }

    /**
     * @return mixed
     */
    public function getLocatorType()
    {
        return $this->locatorType;
    }

    /**
     * @param mixed $locatorType
     */
    public function setLocatorType($locatorType)
    {
        $this->locatorType = $locatorType;
    } //String


}
