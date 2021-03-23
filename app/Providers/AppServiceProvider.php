<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Laravel\Passport\Passport;

class AppServiceProvider extends ServiceProvider {
	/**
	 * Bootstrap any application services.
	 *
	 * @return void
	 */
	public function boot() {

	    //passport
        Passport::routes();
		//
		$this->loadTranslationsFrom(base_path('resources') . '/lang' . session('lang'), 'laravel-filemanager');
		//重写资源路由
		$fileDelete = new \App\Http\Controllers\filemanager\DeleteController($this->app['router']);
		$this->app->bind('UniSharp\LaravelFilemanager\Controllers\DeleteController', function () use ($fileDelete) {
			return $fileDelete;
		});
		$fileResize = new \App\Http\Controllers\filemanager\ResizeController($this->app['router']);
		$this->app->bind('UniSharp\LaravelFilemanager\Controllers\ResizeController', function () use ($fileResize) {
			return $fileResize;
		});
		$fileCrop = new \App\Http\Controllers\filemanager\CropController($this->app['router']);
		$this->app->bind('UniSharp\LaravelFilemanager\Controllers\CropController', function () use ($fileCrop) {
			return $fileCrop;
		});
		$downLoad = new \App\Http\Controllers\filemanager\DownloadController($this->app['router']);
		$this->app->bind('UniSharp\LaravelFilemanager\Controllers\DownloadController', function () use ($downLoad) {
			return $downLoad;
		});
	}

	/**
	 * Register any application services.
	 *
	 * @return void
	 */
	public function register() {
		//
	}
}
