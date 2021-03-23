<?php

Route::group([
	'namespace' => 'UI\\ATM\\ModulePro',
	'prefix' => 'atm',
	'middleware' => [
		'auth',
	],
], function () {

	Route::get('/ModulePro/EngineSetting', 'ModuleProController@showEngineSetting')->name('EngineSetting');
	Route::get('/ModulePro/EngineSetting/{engineId}/Properties', 'ModuleProController@showEngineProperties')->name('EngineProperties');

	Route::get('/ModulePro/DriverPacks', 'ModuleProController@showDriverPacks')->name('DriverPacks');
	Route::get('/ModulePro/DriverPacks/{packId}/PacksEngines', 'ModuleProController@showDriverPacksEngines')->name('PacksEngines');
	
	Route::get('/ModulePro/SystemRequirementsPacks', 'ModuleProController@showSystemRequirementsPacks')->name('SystemRequirementsPacks');
	Route::get('/ModulePro/SystemRequirementsPacks/{packId}/SystemRequirements', 'ModuleProController@showPacksSystemRequirements')->name('SystemRequirements');
});
