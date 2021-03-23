<?php

namespace App\Models\ATM;

use Illuminate\Support\Facades\Config;
use Psy\Exception\TypeErrorException;

class TestCase implements \JsonSerializable
{

    private $id; //int
    private $name; //String
    private $createdAt; //Date
    private $updatedAt; //Date
    private $flag; //boolean
    private $comment; //String
    private $active; //boolean
    private $group; //String
    private $instructions; //array(Instruction)
    private $systemRequirements; //array(Object)
    private $drivers; //array(Object)
    private $storages; //array(Storage)
    private $testCaseOptions; //array(Object)
    private $priority; //int
    private $type;

    public function __construct()
    {
        $get_arguments = func_get_args();
        $number_of_arguments = func_num_args();

        if (method_exists($this, $method_name = '__construct' . $number_of_arguments)) {
            call_user_func_array(array($this, $method_name), $get_arguments);
        }
    }

    public function __construct0()
    {
        $this->id = null;
        $this->name = null;
        $this->createdAt = null;
        $this->updatedAt = null;
        $this->flag = null;
        $this->comment = null;
        $this->active = null;
        $this->group = null;
        $this->instructions = null;
        $this->systemRequirements = null;
        $this->drivers = null;
        $this->storages = null;
        $this->testCaseOptions = null;
        $this->priority = null;
        $this->type = null;
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

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName(string $name)
    {
        $this->name = $name;
    }

    public function getCreatedAt(): ?\DateTime
    {
        return $this->createdAt;
    }

    public function setCreatedAt($createdAt)
    {
        if (is_string($createdAt)) {
            $this->createdAt = \DateTime::createFromFormat(Config::get('meowlomo.date_time_format'), $createdAt);
        } else if ($createdAt instanceof \DateTime) {
            $this->createdAt = $createdAt;
        } else {
            throw new TypeErrorException('Attribute createdAt only accept string or DateTime for as value, ' . gettype($createdAt) . ' is given.');
        }
    }

    public function getUpdatedAt(): ?\DateTime
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt($updatedAt)
    {
        if (is_string($updatedAt)) {
            echo $updatedAt;
            $this->updatedAt = \DateTime::createFromFormat(DATE_RFC3339_EXTENDED, $updatedAt);
        } else if ($updatedAt instanceof \DateTime) {
            $this->updatedAt = $updatedAt;
        } else {
            throw new TypeErrorException('Attribute updatedAt only accept string or DateTime for as value, ' . gettype($updatedAt) . ' is given.');
        }
    }

    public function isFlag()
    {
        return $this->flag;
    }

    public function setFlag(bool $flag)
    {
        $this->flag = $flag;
    }

    public function getComment()
    {
        return $this->comment;
    }

    public function setComment(string $comment)
    {
        $this->comment = $comment;
    }

    public function isActive()
    {
        return $this->active;
    }

    public function setActive(bool $active)
    {
        $this->active = $active;
    }

    public function getGroup()
    {
        return $this->group;
    }

    public function setGroup(string $group)
    {
        $this->group = $group;
    }

    public function getInstructions(): array
    {
        return $this->instructions;
    }

    public function setInstructions(array $instructions = []): void
    {
        $this->instructions = $instructions;
    }

    public function addInstruction(Instruction $instruction): void
    {
        $this->instructions[] = $instruction;
    }

    public function hasInstructions(): bool
    {
        return 0 != count($this->instructions);
    }

    public function removeInstruction($index): void
    {
        unset($this->instructions[$index]);
        $this->instructions = array_values($this->instructions);
    }

    public function getSystemRequirements(): array
    {
        return $this->systemRequirements;
    }

    public function setSystemRequirements(array $systemRequirements = []): void
    {
        $this->systemRequirements = $systemRequirements;
    }

    public function getDrivers(): array
    {
        return $this->drivers;
    }

    public function setDrivers(array $drivers = []): void
    {
        $this->drivers = $drivers;
    }

    public function getStorages(): array
    {
        return $this->storages;
    }

    public function setStorages(array $storages = []): void
    {
        $this->storages = $storages;
    }

    public function getTestCaseOptions(): array
    {
        return $this->testCaseOptions;
    }

    public function setTestCaseOptions(array $testCaseOptions = []): void
    {
        $this->testCaseOptions = $testCaseOptions;
    }

    public function getPriority()
    {
        return $this->priority;
    }

    public function setPriority(int $priority)
    {
        $this->priority = $priority;
    }

    public function getType()
    {
        return $this->type;
    }

    public function setType(string $type)
    {
        $this->type = $type;
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
//        return [
//                'id' => $this->id,
//                'name' => $this->name,
//                'createdAt' => $this->createdAt,
//                'updatedAt' => $this->updatedAt,
//                'flag' => $this->flag,
//                'comment' => $this->comment,
//                'active' => $this->active,
//                'group' => $this->group,
//                'priority' => $this->priority,
//                'type' => $this->type
//            ];


        $returnArray = [];
        if ($this->id != null) {
            $returnArray['id'] = $this->getId();
        };
        if ($this->name != null) {
            $returnArray['name'] = $this->getName();
        };
        if ($this->createdAt != null) {
            $returnArray['createdAt'] = $this->getCreatedAt();
        };
        if ($this->flag != null) {
            $returnArray['flag'] = $this->getFlag();
        };
        if ($this->comment != null) {
            $returnArray['comment'] = $this->getComment();
        };
        if ($this->active != null) {
            $returnArray['active'] = $this->getActive();
        };
        if ($this->group != null) {
            $returnArray['group'] = $this->getGroup();
        };
        if ($this->instructions != null) {
            $returnArray['instructions'] = $this->getInstructions();
        };
        if ($this->systemRequirements != null) {
            $returnArray['systemRequirements'] = $this->getSystemRequirements();
        };
        if ($this->drivers != null) {
            $returnArray['drivers'] = $this->getDrivers();
        };
        if ($this->storages != null) {
            $returnArray['storages'] = $this->getStorages();
        };
        if ($this->testCaseOptions != null) {
            $returnArray['testCaseOptions'] = $this->getTestCaseOptions();
        };
        if ($this->priority != null) {
            $returnArray['priority'] = $this->getPriority();
        };
        if ($this->type != null) {
            $returnArray['type'] = $this->getType();
        };
        return $returnArray;
    }
}
