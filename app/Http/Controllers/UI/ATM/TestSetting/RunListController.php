<?php
namespace App\Http\Controllers\UI\ATM\TestSetting;

use App\Http\Controllers\LanguageController;
use App\Http\Controllers\API\MeowlomoBaseController;
use Illuminate\Support\Facades\Auth;

class RunListController extends MeowlomoBaseController {

	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	private $locale;

	public function __construct() {
		$this->middleware('auth');
		$this->locale = new LanguageController();
	}

	public function showRunList() {
		$permissions = Auth::user()->getAllPermissions()
			->filter(function ($value, $key) {
				if (strpos($value['name'], 'run_sets') !== false) {
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
		$lang = $this->locale->getRunListPageLangMessage();
		$message = [
			'lang' => $lang,
			'permissions' => $permissions,
		];

		session(['title' => 'RunList']);

		return view('UI.ATM.TestSettings.RunList.runList', [
			'message' => json_encode($message),
		]);
	}

	public function showRunListTestCase($rid) {
		$permissions = Auth::user()->getAllPermissions()
			->filter(function ($value, $key) {
				if (strpos($value['name'], 'run_set') !== false) {
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
		$lang = $this->locale->getRunListTestCasePageLangMessage();
		$message = [
			'lang' => $lang,
			'permissions' => $permissions,
		];

		session(['title' => 'RunList'.'-'. $rid]);

		return view('UI.ATM.TestSettings.RunList.runListTestCase', [
			'message' => json_encode($message),
		]);
	}
}
