<?php
namespace App\Http\Controllers\UI\ATM\RunStatus;

use App\Http\Controllers\LanguageController;
use App\Http\Controllers\API\MeowlomoBaseController;
use Illuminate\Support\Facades\Auth;

class RunStatusController extends MeowlomoBaseController {

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

	public function showProjectRunStatus() {
		$permissions = Auth::user()->getAllPermissions()
			->filter(function ($value, $key) {
				if (strpos($value['name'], 'view_run_status') !== false) {
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
		$lang = $this->locale->getRunStatusPageLangMessage();
		$message = [
			'lang' => $lang,
			'permissions' => $permissions,
		];

		session(['title' => 'ProjectStatus']);

		return view('UI.ATM.RunState.ProjectRunState.projectRunState', [
			'message' => json_encode($message),
		]);
	}

	public function showProjectTestCaseRunStatus($projectId) {
		$permissions = Auth::user()->getAllPermissions()
			->filter(function ($value, $key) {
				if (strpos($value['name'], 'view_run_status') !== false) {
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
		$lang = $this->locale->getRunStatusPageLangMessage();
		$message = [
			'lang' => $lang,
			'permissions' => $permissions,
		];

		session(['title' => 'ProjectStatus'.'-'. $projectId]);

		return view('UI.ATM.RunState.ProjectRunState.testCaseRunState', [
			'message' => json_encode($message),
		]);
	}

	public function showRunListRunStatus() {
		$permissions = Auth::user()->getAllPermissions()
			->filter(function ($value, $key) {
				if (strpos($value['name'], 'view_run_status') !== false) {
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
		$lang = $this->locale->getRunStatusPageLangMessage();
		$message = [
			'lang' => $lang,
			'permissions' => $permissions,
		];

		session(['title' => 'RunListStatus']);

		return view('UI.ATM.RunState.RunListRunState.runListRunState', [
			'message' => json_encode($message),
		]);
	}

	public function showRunListTestCaseRunStatus($runListId) {
		$permissions = Auth::user()->getAllPermissions()
			->filter(function ($value, $key) {
				if (strpos($value['name'], 'view_run_status') !== false) {
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
		$lang = $this->locale->getRunStatusPageLangMessage();
		$message = [
			'lang' => $lang,
			'permissions' => $permissions,
		];

		session(['title' => 'RunListStatus'.'-'. $runListId]);

		return view('UI.ATM.RunState.RunListRunState.testCaseRunState', [
			'message' => json_encode($message),
		]);
	}

	public function showTestCaseRunStatus() {
		$permissions = Auth::user()->getAllPermissions()
			->filter(function ($value, $key) {
				if (strpos($value['name'], 'view_run_status') !== false) {
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
		$lang = $this->locale->getRunStatusPageLangMessage();
		$message = [
			'lang' => $lang,
			'permissions' => $permissions,
		];

		session(['title' => 'TestCaseStatus']);

		return view('UI.ATM.RunState.TestCaseRunState.testCaseRunState', [
			'message' => json_encode($message),
		]);
	}
}
