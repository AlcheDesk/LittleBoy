<?php
/**
 * Created by PhpStorm.
 * User: scott.fu
 * Date: 2018/1/23
 * Time: 18:58
 */

namespace App\Models\ATM;

class Storage
{
    private $id; //int
    private $url; //String
    private $testCaseId; //int
    private $parameter; //Parameter
    private $name;

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
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * @param mixed $url
     */
    public function setUrl($url)
    {
        $this->url = $url;
    }

    /**
     * @return mixed
     */
    public function getTestCaseId()
    {
        return $this->testCaseId;
    }

    /**
     * @param mixed $testCaseId
     */
    public function setTestCaseId($testCaseId)
    {
        $this->testCaseId = $testCaseId;
    }

    /**
     * @return mixed
     */
    public function getParameter()
    {
        return $this->parameter;
    }

    /**
     * @param mixed $parameter
     */
    public function setParameter($parameter)
    {
        $this->parameter = $parameter;
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
    } //String


}