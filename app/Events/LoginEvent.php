<?php

namespace App\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class LoginEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    protected $name;
    protected $uuid;
    protected $ip;
    protected $location;
    protected $login_mode_id;
    protected $timestamps;
    protected $token;
    protected $token_duration;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($name,$uuid,$ip,$location,$login_mode_id,$timestamps,$token,$token_duration)
    {
        $this->name=$name;
        $this->uuid=$uuid;
        $this->ip=$ip;
        $this->location=$location;
        $this->login_mode_id=$login_mode_id;
        $this->timestamps=$timestamps;
        $this->token=$token;
        $this->token_duration=$token_duration;
    }

    public function getName(){
        return $this->name;
    }

    public function getUuid(){
        return $this->uuid;
    }

    public function getIp(){
        return $this->ip;
    }
    public function getLocation(){
        return $this->location;
    }

    public function getLogin_mode_id(){
        return $this->login_mode_id;
    }

    public function getTimestamps(){
        return $this->timestamps;
    }

    public function getToken(){
        return $this->token;
    }

    public function getToken_duration(){
        return $this->token_duration;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
