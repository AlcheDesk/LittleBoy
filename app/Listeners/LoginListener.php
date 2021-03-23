<?php

namespace App\Listeners;

use App\Events\LoginEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\DB;

class LoginListener implements ShouldQueue
{
    /**
     * 失败重试次数
     * @var integer
     */
    public $tries = 1;

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  LoginEvent  $event
     * @return void
     */
    public function handle(LoginEvent $event)
    {
        //获取事件中保存的信息
        $name=$event->getName();
        $uuid=$event->getUuid();
        $ip=$event->getIp();
        $location=$event->getLocation();
        $login_mode_id=$event->getLogin_mode_id();
        $timestamps=$event->getTimestamps();
        $token=$event->getToken();
        $token_duration=$event->getToken_duration();

       DB::table('login_record')->insertGetId(
            ['name' => $name, 'uuid' => $uuid, 'ip' => $ip, 'location' => $location, 
            'login_mode_id' => $login_mode_id, 'timestamps' => $timestamps, 'token' => $token, 
            'token_duration' => $token_duration ]
        );
    }
}
