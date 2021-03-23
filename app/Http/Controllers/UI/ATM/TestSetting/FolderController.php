<?php

namespace App\Http\Controllers\UI\ATM\TestSetting;

use App\Http\Controllers\LanguageController;
use App\Http\Controllers\API\MeowlomoBaseController;
use Illuminate\Support\Facades\Auth;

class FolderController extends MeowlomoBaseController {
	//

	private $locale;

	public function __construct() {
		$this->middleware('auth');
		$this->locale = new LanguageController();
	}

	public function showFolder() {
		$permissions = Auth::user()->getAllPermissions()
			->filter(function ($value, $key) {
				if (strpos($value['name'], 'folder') !== false) {
					return true;
				}
			})
			->flatten()
			->pluck('name')
			->map(function ($name) {
				return [
					$name => true,
				];
			})
			->collapse()
			->all();
		$lang = $this->locale->getFolderPageLangMessage();
		$message = [
			'lang' => $lang,
			'permissions' => $permissions,
		];

		session(['title' => 'Folder']);

		return view('UI.ATM.TestSettings.Folder.folder', [
			'message' => json_encode($message),
		]);
	}

	public function showFolderTestCase($fid) {
		$permissions = Auth::user()->getAllPermissions()
			->filter(function ($value, $key) {
				if (strpos($value['name'], 'folder_testcase') !== false) {
					return true;
				}
			})
			->flatten()
			->pluck('name')
			->map(function ($name) {
				return [
					$name => true,
				];
			})
			->collapse()
			->all();
		$lang = $this->locale->getFolderTestCasePageLangMessage();
		$message = [
			'lang' => $lang,
			'permissions' => $permissions,
		];

		session(['title' => 'Folder'.'-'. $fid]);

		return view('UI.ATM.TestSettings.Folder.folderTestCase', [
			'message' => json_encode($message),
		]);
	}

}
