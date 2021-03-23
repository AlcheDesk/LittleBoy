<?php

namespace App\Providers;

use Illuminate\Support\Facades\Event;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use App\Listeners\FileUploadListener;
use App\Listeners\FileDeleteListener;
use App\Listeners\FileRenameListener;
use App\Listeners\FileResizeListener;
use App\Listeners\FileCropListener;
use UniSharp\LaravelFilemanager\Events\ImageWasResized;
use UniSharp\LaravelFilemanager\Events\ImageWasUploaded;
//use UniSharp\LaravelFilemanager\Events\ImageWasDeleted;
use UniSharp\LaravelFilemanager\Events\ImageWasRenamed;
//use UniSharp\LaravelFilemanager\Events\ImageWasCropped;
use Illuminate\Support\Facades\Log;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],

        //添加对文件上传事件的监听
        ImageWasUploaded::class => [
            FileUploadListener::class,
        ],

        //添加对文件重命名事件的监听
        ImageWasRenamed::class => [
            FileUploadListener::class,
        ],

        //添加登录事件的监听器
        'App\Events\LoginEvent' => [
            'App\Listeners\LoginListener',
        ],

        //添加文件删除的监听器
        'App\Events\ImageWasDeleted' => [
            FileUploadListener::class,
        ],
        //添加文件缩放的监听器
        'App\Events\ImageWasResized' => [
            FileUploadListener::class,
        ],
        //添加文件裁剪的监听器
        'App\Events\ImageWasCropped' => [
            FileUploadListener::class,
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}
