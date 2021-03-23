<?php
namespace App\Http\Controllers\UI\ATM\TestSetting;

use App\Http\Controllers\LanguageController;
use App\Http\Controllers\API\MeowlomoBaseController;
use Illuminate\Support\Facades\Auth;

class TestCaseLibController extends MeowlomoBaseController {

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

	public function showTestCase() {
		$permissions = Auth::user()->getAllPermissions()
			->filter(function ($value, $key) {
				if (strpos($value['name'], 'test_case') !== false) {
					return true;
				}
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
		$lang = $this->locale->getTestCasePageLangMessage();
		$message = [
			'lang' => $lang,
			'permissions' => $permissions,
		];

		session(['title' => 'TestCase']);

		return view('UI.ATM.TestSettings.TestCaseLib.testCase', [
			'message' => json_encode($message),
		]);
	}
}
