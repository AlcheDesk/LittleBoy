<?php

// testCaseFolder
Route::group([
	'namespace' => 'API\\ATM\\',
	'prefix' => 'scheduler/runSets',
	'middleware' => [
		'auth:api', 'atm',
	],
], function () {
	Route::get('/{id}/triggers/', 'AlarmSetController@getAlarmSetByRunSetId');
	Route::put('/{id}/triggers/', 'AlarmSetController@addOrPatchAlarmSetByRunSetId');
	Route::delete('/{id}/triggers/{uuid}/', 'AlarmSetController@deleteAlarmSetByRunSetIdAndTriggerUUID');
});
