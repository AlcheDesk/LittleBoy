<?php

namespace App\Providers;

use Laravel\Passport\Passport;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();
        //password configurations
        Passport::routes();
        Passport::cookie(
            env('PASSPORT_COOKIE','meowlomo_api_token')
        );
        Passport::tokensExpireIn(
            now()->addMinutes(
                env('PASSPORT_TOKENS_EXPIRE_IN_MINS',3600)
                )
        );
        Passport::refreshTokensExpireIn(
            now()->addMinutes(
                env('PASSPORT_REFRESH_TOKENS_EXPIRE_IN_MINS',7200)
                )
        );
    }
}
