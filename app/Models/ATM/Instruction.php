<?php
/**
 * Created by PhpStorm.
 * User: scott.fu
 * Date: 2018/1/23
 * Time: 18:56
 */

namespace App\Models\ATM;

class Instruction implements \JsonSerializable
{

    private $id; //int
    private $comment; //String
    private $createdAt; //Date
    private $updatedAt;
    private $active; //boolean
    private $orderIndex; //int
    private $target; //String
    private $type; //String
    private $testCaseId; //int
    private $refTestCaseId; //int
    private $instructionOptions; //array(Object)
    private $action; //String
    private $input; //String
    private $elementId; //int?
    private $applicationId; //int?
    private $sectionId; //int?
    private $element; //Element
    private $color;

    public function __construct()
    {
        $this->id = null;
        $this->comment = null;
        $this->createdAt = null;
        $this->updatedAt = null;
        $this->active = null;
        $this->orderIndex = null;
        $this->target = null;
        $this->type = null;
        $this->testCaseId = null;
        $this->refTestCaseId = null;
        $this->instructionOptions = null;
        $this->action = null;
        $this->input = null;
        $this->elementId = null;
        $this->applicationId = null;
        $this->sectionId = null;
        $this->element = null;
        $this->color = null;
    }

    public function __construct1(array $values = [])
    {
        array_key_exists('id', $values) ? $this->setId($values['id']) : $this->id = null;
        array_key_exists('name', $values) ? $this->setName($values['name']) : $this->name = null;
        array_key_exists('createdAt', $values) ? $this->setCreatedAt($values['createdAt']) : $this->createdAt = null;
        array_key_exists('updatedAt', $values) ? $this->setUpdatedAt($values['updatedAt']) : $this->updatedAt = null;
        array_key_exists('flag', $values) ? $this->setFlag($values['flag']) : $this->flag = null;
        array_key_exists('comment', $values) ? $this->setComment($values['comment']) : $this->comment = null;
        array_key_exists('active', $values) ? $this->setActive($values['active']) : $this->active = null;
        array_key_exists('group', $values) ? $this->setGroup($values['group']) : $this->group = null;
        array_key_exists('instructions', $values) ? $this->setInstructions($values['instructions']) : $this->instructions = null;
        array_key_exists('systemRequirements', $values) ? $this->setSystemRequirements($values['systemRequirements']) : $this->systemRequirements = null;
        array_key_exists('drivers', $values) ? $this->setDrivers($values['drivers']) : $this->drivers = null;
        array_key_exists('storages', $values) ? $this->setStorages($values['storages']) : $this->storages = null;
        array_key_exists('testCaseOptions', $values) ? $this->setTestCaseOptions($values['testCaseOptions']) : $this->testCaseOptions = null;
        array_key_exists('priority', $values) ? $this->setPriority($values['priority']) : $this->priority = null;
        array_key_exists('type', $values) ? $this->setType($values['type']) : $this->type = null;
    }

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
    public function getCreatedAt(): \DateTime
    {
        return $this->createdAt;
    }

    /**
     * @param mixed $createdAt
     */
    public function setCreatedAt(\DateTime $createdAt)
    {
        $this->createdAt = $createdAt;
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
    public function getOrderIndex()
    {
        return $this->orderIndex;
    }

    /**
     * @param mixed $orderIndex
     */
    public function setOrderIndex($orderIndex)
    {
        $this->orderIndex = $orderIndex;
    }

    /**
     * @return mixed
     */
    public function getTarget()
    {
        return $this->target;
    }

    /**
     * @param mixed $target
     */
    public function setTarget($target)
    {
        $this->target = $target;
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
    public function getRefTestCaseId()
    {
        return $this->refTestCaseId;
    }

    /**
     * @param mixed $refTestCaseId
     */
    public function setRefTestCaseId($refTestCaseId)
    {
        $this->refTestCaseId = $refTestCaseId;
    }

    /**
     * @return mixed
     */
    public function getInstructionOptions()
    {
        return $this->instructionOptions;
    }

    /**
     * @param mixed $instructionOptions
     */
    public function setInstructionOptions($instructionOptions)
    {
        $this->instructionOptions = $instructionOptions;
    }

    /**
     * @return mixed
     */
    public function getAction()
    {
        return $this->action;
    }

    /**
     * @param mixed $action
     */
    public function setAction($action)
    {
        $this->action = $action;
    }

    /**
     * @return mixed
     */
    public function getInput()
    {
        return $this->input;
    }

    /**
     * @param mixed $input
     */
    public function setInput($input)
    {
        $this->input = $input;
    }

    /**
     * @return mixed
     */
    public function getElementId()
    {
        return $this->elementId;
    }

    /**
     * @param mixed $elementId
     */
    public function setElementId($elementId)
    {
        $this->elementId = $elementId;
    }

    /**
     * @return mixed
     */
    public function getApplicationId()
    {
        return $this->applicationId;
    }

    /**
     * @param mixed $applicationId
     */
    public function setApplicationId($applicationId)
    {
        $this->applicationId = $applicationId;
    }

    /**
     * @return mixed
     */
    public function getSectionId()
    {
        return $this->sectionId;
    }

    /**
     * @param mixed $sectionId
     */
    public function setSectionId($sectionId)
    {
        $this->sectionId = $sectionId;
    }

    /**
     * @return mixed
     */
    public function getElement()
    {
        return $this->element;
    }

    /**
     * @param mixed $element
     */
    public function setElement($element)
    {
        $this->element = $element;
    }

    /**
     * @return mixed
     */
    public function getColor()
    {
        return $this->color;
    }

    /**
     * @param mixed $color
     */
    public function setColor($color)
    {
        $this->color = $color;
    }

    /**
     * @return mixed
     */
    public function getUpdatedAt(): \DateTime
    {
        return $this->updatedAt;
    }

    /**
     * @param mixed $updatedAt
     */
    public function setUpdatedAt(\DateTime $updatedAt): void
    {
        $this->updatedAt = $updatedAt;
    } //String


    /**
     * Specify data which should be serialized to JSON
     * @link http://php.net/manual/en/jsonserializable.jsonserialize.php
     * @return mixed data which can be serialized by <b>json_encode</b>,
     * which is a value of any type other than a resource.
     * @since 5.4.0
     */
    public function jsonSerialize()
    {
        return [
            'id' => $this->id,
            'comment' => $this->comment,
            'createdAt' => $this->createdAt,
            'updatedAt' => $this->updatedAt,
            'active' => $this->active,
            'orderIndex' => $this->orderIndex,
            'target' => $this->target,
            'type' => $this->type,
            'testCasesId' => $this->testCaseId,
            'refTestCaseId' => $this->refTestCaseId,
            'instructionOptions' => $this->instructionOptions,
            'action' => $this->action,
            'input' => $this->input,
            'elementId' => $this->elementId,
            'applicationId' => $this->applicationId,
            'sectionId' => $this->sectionId,
            'element' => $this->element,
            'color' => $this->color
        ];
    }
}