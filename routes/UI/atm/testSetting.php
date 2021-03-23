<?php

Route::group([
	'namespace' => 'UI\\ATM\\TestSetting',
	'prefix' => 'atm',
	'middleware' => [
		'auth',
	],
], function () {
	Route::get('/TestSetting/Project', 'ProjectLibController@showProject')->name('Project');

	Route::get('/TestSetting/Project/{pid}/TestCase/', 'ProjectLibController@showProjectTestCase')->name('ProjectTestCase');

	Route::get('/TestSetting/Project/{pid}/TestCase/{tid}/Instruction', 'ProjectLibController@showTestCaseInstruction')->name('TestCaseInstruction');

	Route::get('/TestSetting/Project/{pid}/TestCase/{tid}/ApiTest', 'ProjectLibController@showTestCaseApiInstruction')->name('TestCaseApiInstruction');

	Route::get('/TestSetting/Project/{pid}/Application/', 'ProjectLibController@showProjectApplication')->name('ProjectApplication');

	Route::get('/TestSetting/Project/{pid}/Application/{aid}/Section', 'ProjectLibController@showApplicationSection')->name('ApplicationSection');

	Route::get('/TestSetting/Project/{pid}/Application/{aid}/Section/{sid}/Element', 'ProjectLibController@showSectionElement')->name('SectionElement');

	Route::get('/TestSetting/Project/{pid}/ApiElement/', 'ProjectLibController@showProjectApiElement')->name('ProjectApiElement');

	Route::get('/TestSetting/Project/{pid}/ApiElementAdd/', 'ProjectLibController@showProjectApiElementEdit')->name('ProjectApiElement');

	Route::get('/TestSetting/Project/{pid}/ApiElementEdit/', 'ProjectLibController@showProjectApiElementEdit')->name('ProjectApiElement');

	Route::get('/TestSetting/Project/SystemSetting', 'ProjectLibController@showSystemSetting')->name('ProjectApiElement');

	//TestCaselib
	Route::get('/TestSetting/TestCase', 'TestCaseLibController@showTestCase')->name('TestCase');

	//RunList
	Route::get('/TestSetting/RunList', 'RunListController@showRunList')->name('RunList');
	Route::get('/TestSetting/RunList/{rid}/TestCase', 'RunListController@showRunListTestCase')->name('RunListTestCase');

	//Instruction Template
	Route::get('/TestSetting/InstructionBundle', 'InstructionBundleController@showInstructionBundle')->name('InstructionBundle');
	Route::get('/TestSetting/InstructionBundle/{iid}/InstructionBundleEntry', 'InstructionBundleController@showInstructionBundleEntry')->name('InstructionBundleEntry');

	//folder
	Route::get('/TestSetting/Folder', 'FolderController@showFolder')->name('Folder');

	Route::get('/TestSetting/Folder/{fid}/TestCase/', 'FolderController@showFolderTestCase')->name('FolderTestCase');

});