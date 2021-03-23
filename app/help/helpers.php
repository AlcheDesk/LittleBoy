<?php

if (!function_exists('recaptcha')) {

	/**
	 * @param string $config
	 * @return mixed
	 */
	function recaptcha($config = 'default') {
		return app('imgCaptcha')->create($config);
	}
}

if (!function_exists('recaptcha_src')) {
	/**
	 * @param string $config
	 * @return string
	 */
	function recaptcha_src($config = 'default') {
		return app('imgCaptcha')->src($config);
	}
}

if (!function_exists('recaptcha_img')) {

	/**
	 * @param string $config
	 * @return mixed
	 */
	function recaptcha_img($config = 'default') {
		return app('imgCaptcha')->img($config);
	}
}

if (!function_exists('recaptcha_check')) {
	/**
	 * @param $value
	 * @return bool
	 */
	function recaptcha_check($value) {
		return app('imgCaptcha')->check($value);
	}
}

if (!function_exists('recaptcha_api_check')) {
	/**
	 * @param $value
	 * @return bool
	 */
	function recaptcha_api_check($value, $key) {
		return app('imgCaptcha')->check_api($value, $key);
	}
}
