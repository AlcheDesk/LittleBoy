<?php

// count
Route::group([
	'namespace' => 'API\\ATM\\',
	'prefix' => 'count',
	'middleware' => [
		'auth:api', 'atm',
	],
], function () {
	Route::get('/aliases', 'CountController@getAliasNumber');
	Route::get('/apiSchemas', 'CountController@getApiSchemaNumber');
	Route::get('/applications', 'CountController@getApplicationNumber');
	Route::get('/drivers', 'CountController@getDriverNumber');
	Route::get('/driverPacks', 'CountController@getDriverPackNumber');
	Route::get('/driverPropertys', 'CountController@getDriverPropertyNumber');
	Route::get('/elements', 'CountController@getElementNumber');
	Route::get('/executionLogs', 'CountController@getExecutionLogNumber');
	Route::get('/elementTypes', 'CountController@getElementTypeNumber');
	Route::get('/elementActions', 'CountController@getElementActionNumber');
	Route::get('/elementLocatorTypes', 'CountController@getElementLocatorTypeNumber');
	Route::get('/files', 'CountController@getFileNumber');
	Route::get('/testCaseShareFolders', 'CountController@getTestCaseShareFolderNumber');
	Route::get('/fileTypes', 'CountController@getFileTypeNumber');
	Route::get('/groups', 'CountController@getGroupNumber');
	Route::get('/instructions', 'CountController@getInstructionNumber');
	Route::get('/instructionBundles', 'CountController@getInstructionBundleNumber');
	Route::get('/instructionOptions', 'CountController@getInstructionOptionNumber');
	Route::get('/instructionResults', 'CountController@getInstructionResultNumber');
	Route::get('/instructionTypes', 'CountController@getInstructionTypeNumber');
	Route::get('/instructionOverwrites', 'CountController@getInstructionOverwriteNumber');
	Route::get('/projects', 'CountController@getProjectNumber');
	Route::get('/projectTypes', 'CountController@getProjectTypeNumber');
	Route::get('/propertys', 'CountController@getPropertyNumber');
	Route::get('/runs', 'CountController@getRunNumber');
	Route::get('/runSets', 'CountController@getRunSetNumber');
	Route::get('/sections', 'CountController@getSectionNumber');
	Route::get('/systemRequirementPacks', 'CountController@getSystemRequirementPackNumber');
	Route::get('/stepLogs', 'CountController@getStepLogNumber');
	Route::get('/stepLogTypes', 'CountController@getStepLogTypeNumber');
	Route::get('/storages', 'CountController@getStorageNumber');
	Route::get('/systemRequirements', 'CountController@getSystemRequirementNumber');
	Route::get('/testCases', 'CountController@getTestCaseNumber');
	Route::get('/testCases/{id}/testCases', 'CountController@validateTestCaseDelete');
	Route::get('/testCaseFolders', 'CountController@getTestCaseFolderNumber');
	Route::get('/testCaseReference', 'CountController@getTestCaseReferenceNumber');
	Route::get('/testCaseOptions', 'CountController@getTestCaseOptionNumber');
	Route::get('/testCaseOverwrites', 'CountController@getTestCaseOverwriteNumber');
	Route::get('/tags', 'CountController@getTagsRelationTestCaseNumber');
	Route::get('/runSetTestCaseLinks', 'CountController@getRunSetTestCaseLinkNumber');
	Route::get('/emailNotificationTargets', 'CountController@getEmailNotificationTargetNumber');
});
