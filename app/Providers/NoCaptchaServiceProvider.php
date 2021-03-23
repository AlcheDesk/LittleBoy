<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Anhskohbo\NoCaptcha\NoCaptchaServiceProvider as nocapServiceProvider;
use Anhskohbo\NoCaptcha\NoCaptcha;

class NoCaptchaServiceProvider extends nocapServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Bootstrap the application events.
     */
    public function boot()
    {
        $app = $this->app;

        $this->bootConfig();

        $app['validator']->extend('captcha', function ($attribute, $value) use ($app) {
            return $app['nocaptcha']->verifyResponse($value, $app['request']->getClientIp());
        });

        if ($app->bound('form')) {
            $app['form']->macro('captcha', function ($attributes = []) use ($app) {
                return $app['nocaptcha']->display($attributes, $app->getLocale());
            });
        }
    }

    /**
     * Booting configure.
     */
    protected function bootConfig()
    {
        $path = base_path().'/vendor/anhskohbo/no-captcha/src/config/captcha.php';

        $this->mergeConfigFrom($path, 'nocaptcha');

        if (function_exists('config_path')) {
            $this->publishes([$path => config_path('nocaptcha.php')]);
        }
    }

    /**
     * Register the service provider.
     */
    public function register()
    {
        $this->app->singleton('nocaptcha', function ($app) {
            return new NoCaptcha(
                $app['config']['captcha.secret'],
                $app['config']['captcha.sitekey'],
                $app['config']['captcha.options']
            );
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['nocaptcha'];
    }
}
