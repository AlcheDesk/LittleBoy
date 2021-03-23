<?php

namespace App\Providers;

use Mews\Captcha\Captcha;
use Mews\Captcha\CaptchaServiceProvider as CaServiceProvider;

class CaptchaServiceProvider extends CaServiceProvider {

	/*
	 * Boot the service provider.s
	 *
	 * @return null
	 */
	public function boot() {
		// Publish configuration files
		$this->publishes([
			base_path() . '/vendor/mews/captcha/config/captcha.php' => config_path('captcha.php'),
		], 'config');

		// HTTP routing
		if (strpos($this->app->version(), 'Lumen') !== false) {
			$this->app->get('captcha[/api/{config}]', 'Mews\Captcha\LumenCaptchaController@getCaptchaApi');
			$this->app->get('captcha[/{config}]', 'Mews\Captcha\LumenCaptchaController@getCaptcha');
		} else {
			if ((double) $this->app->version() >= 5.2) {
				$this->app['router']->get('captcha/api/{config?}', '\Mews\Captcha\CaptchaController@getCaptchaApi')->middleware('web');
				$this->app['router']->get('captcha/{config?}', '\Mews\Captcha\CaptchaController@getCaptcha')->middleware('web');
			} else {
				$this->app['router']->get('captcha/api/{config?}', '\Mews\Captcha\CaptchaController@getCaptchaApi');
				$this->app['router']->get('captcha/{config?}', '\Mews\Captcha\CaptchaController@getCaptcha');
			}
		}

		// Validator extensions
		$this->app['validator']->extend('recaptcha', function ($attribute, $value, $parameters) {
			return recaptcha_check($value);
		});

		// Validator extensions
		$this->app['validator']->extend('recaptcha_api', function ($attribute, $value, $parameters) {
			return recaptcha_api_check($value, $parameters[0]);
		});
	}

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register() {
		/* // Merge configs
		$this->mergeConfigFrom(
		__DIR__.'/../config/captcha.php', 'captcha'
		);*/

		// Bind captcha
		$this->app->bind('imgCaptcha', function ($app) {
			return new Captcha(
				$app['Illuminate\Filesystem\Filesystem'],
				$app['Illuminate\Config\Repository'],
				$app['Intervention\Image\ImageManager'],
				$app['Illuminate\Session\Store'],
				$app['Illuminate\Hashing\BcryptHasher'],
				$app['Illuminate\Support\Str']
			);
		});
	}
}
