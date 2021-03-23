<?php

namespace App\Models\RBAC;

use Illuminate\Database\Eloquent\Model;

class accounts extends Model
{


    public function users()
    {
        return $this->belongsToMany(users::class,'accounts_users','accounts_id','users_id');
    }

    private $id;
    private $name;
    private $uuid;
    private $account_level;
    private $expirated_at;
    private $updated_at;
    private $created_at;
    private $description;
    private $phone_number;
    private $contact;
    private $email;
    private $industry;
    private $position;
    private $user_uuid;
    private $tenant_id;

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
    public function setId($id): void
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
    public function setName($name): void
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getUuid()
    {
        return $this->uuid;
    }

    /**
     * @param mixed $uuid
     */
    public function setUuid($uuid): void
    {
        $this->uuid = $uuid;
    }

    /**
     * @return mixed
     */
    public function getAccountLevel()
    {
        return $this->account_level;
    }

    /**
     * @param mixed $account_level
     */
    public function setAccountLevel($account_level): void
    {
        $this->account_level = $account_level;
    }

    /**
     * @return mixed
     */
    public function getExpiratedAt()
    {
        return $this->expirated_at;
    }

    /**
     * @param mixed $expirated_at
     */
    public function setExpiratedAt($expirated_at): void
    {
        $this->expirated_at = $expirated_at;
    }

    /**
     * @return mixed
     */
    public function getCreatedAt()
    {
        return $this->created_at;
    }

    /**
     * @param mixed $created_at
     */
    public function setCreatedAt($created_at): void
    {
        $this->created_at = $created_at;
    }

    /**
     * @return mixed
     */
    public function getUpdatedAt()
    {
        return $this->updated_at;
    }

    /**
     * @param mixed $updated_at
     */
    public function setUpdatedAt($updated_at): void
    {
        $this->updated_at = $updated_at;
    }


    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param mixed $description
     */
    public function setDescription($description): void
    {
        $this->description = $description;
    }

    /**
     * @return mixed
     */
    public function getPhoneNumber()
    {
        return $this->phone_number;
    }

    /**
     * @param mixed $phone_number
     */
    public function setPhoneNumber($phone_number): void
    {
        $this->phone_number = $phone_number;
    }


    /**
     * @return mixed
     */
    public function getContact()
    {
        return $this->contact;
    }

    /**
     * @param mixed $contact
     */
    public function setContact($contact): void
    {
        $this->contact = $contact;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param mixed $email
     */
    public function setEmail($email): void
    {
        $this->email = $email;
    }

    /**
     * @return mixed
     */
    public function getIndustry()
    {
        return $this->industry;
    }

    /**
     * @param mixed $industry
     */
    public function setIndustry($industry): void
    {
        $this->industry = $industry;
    }

    /**
     * @return mixed
     */
    public function getPosition()
    {
        return $this->position;
    }

    /**
     * @param mixed $position
     */
    public function setPosition($position): void
    {
        $this->position = $position;
    }

    /**
     * @return mixed
     */
    public function getUserUuid()
    {
        return $this->user_uuid;
    }

    /**
     * @param mixed $user_uuid
     */
    public function setUserUuid($user_uuid): void
    {
        $this->user_uuid = $user_uuid;
    }

    /**
     * @return mixed
     */
    public function getTenantId()
    {
        return $this->tenant_id;
    }

    /**
     * @param mixed $tenant_id
     */
    public function setTenantId($tenant_id): void
    {
        $this->tenant_id = $tenant_id;
    }
}
