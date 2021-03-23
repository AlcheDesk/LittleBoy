<?php
namespace App\Http\Controllers\UI\ATM\DebugResult;

use App\Http\Controllers\LanguageController;
use App\Http\Controllers\API\MeowlomoBaseController;
use Illuminate\Support\Facades\Auth;

class DebugResultController extends MeowlomoBaseController {

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

	public function showProjectDebugResult() {
		$permissions = Auth::user()->getAllPermissions()
			->filter(function ($value, $key) {
				if (strpos($value['name'], 'view_run_result') !== false) {
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
		$lang = $this->locale->getRunResultPageLangMessage();
		$message = [
			'lang' => $lang,
			'permissions' => $permissions,
		];

		session(['title' => 'ProjectDebugResult']);

		return view('UI.ATM.DebugResult.ProjectDebugResult.projectDebugResult', [
			'message' => json_encode($message),
		]);
	}

	public function showProjectTestCaseDebugResult($projectId) {
		$permissions = Auth::user()->getAllPermissions()
			->filter(function ($value, $key) {
				if (strpos($value['name'], 'view_run_result') !== false) {
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
		$lang = $this->locale->getRunResultPageLangMessage();
		$message = [
			'lang' => $lang,
			'permissions' => $permissions,
		];

		session(['title' => 'ProjectDebugResult'.'-'. $projectId]);

		return view('UI.ATM.DebugResult.ProjectDebugResult.testCaseDebugResult', [
			'message' => json_encode($message),
		]);
	}

	public function showTestCaseRunDebugResult($projectId, $testCaseId) {
		$permissions = Auth::user()->getAllPermissions()
			->filter(function ($value, $key) {
				if (strpos($value['name'], 'view_run_result') !== false) {
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
		$lang = $this->locale->getRunResultPageLangMessage();
		$message = [
			'lang' => $lang,
			'permissions' => $permissions,
		];

		session(['title' => 'TestCaseDebugResult'.'-'. $projectId]);

		return view('UI.ATM.DebugResult.ProjectDebugResult.runTestCaseDebugResult', [
			'message' => json_encode($message),
		]);
	}

	public function showRunInstructionDebugResult($projectId, $testCaseId, $runId) {
		$permissions = Auth::user()->getAllPermissions()
			->filter(function ($value, $key) {
				if (strpos($value['name'], 'view_run_result') !== false) {
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
		$lang = $this->locale->getRunResultPageLangMessage();
		$message = [
			'lang' => $lang,
			'permissions' => $permissions,
		];

		session(['title' => 'DebugRun'.'-'. $runId]);

		return view('UI.ATM.DebugResult.ProjectDebugResult.instructionDebugResult', [
			'message' => json_encode($message),
		]);
	}

	public function showApiInstructionDebugResultLog($projectId, $testCaseId, $runId) {
		$permissions = Auth::user()->getAllPermissions()
			->filter(function ($value, $key) {
				if (strpos($value['name'], 'view_run_result') !== false) {
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
		$lang = $this->locale->getRunResultPageLangMessage();
		$message = [
			'lang' => $lang,
			'permissions' => $permissions,
		];

		session(['title' => 'DebugRun'.'-'. $runId]);

		return view('UI.ATM.DebugResult.ProjectDebugResult.apiInstructionDebugResultLog', [
			'message' => json_encode($message),
		]);
	}

	public function showRunListDebugResult() {
		$permissions = Auth::user()->getAllPermissions()
			->filter(function ($value, $key) {
				if (strpos($value['name'], 'view_run_result') !== false) {
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
		$lang = $this->locale->getRunResultPageLangMessage();
		$message = [
			'lang' => $lang,
			'permissions' => $permissions,
		];

		session(['title' => 'RunListDebugResult']);

		return view('UI.ATM.DebugResult.RunListDebugResult.runListDebugResult', [
			'message' => json_encode($message),
		]);
	}

	public function showRunListTestCaseDebugResult($runListId) {
		$permissions = Auth::user()->getAllPermissions()
			->filter(function ($value, $key) {
				if (strpos($value['name'], 'view_run_result') !== false) {
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
		$lang = $this->locale->getRunResultPageLangMessage();
		$message = [
			'lang' => $lang,
			'permissions' => $permissions,
		];

		session(['title' => 'RunListDebugResult'.'-'. $runListId]);

		return view('UI.ATM.DebugResult.RunListDebugResult.testCaseDebugResult', [
			'message' => json_encode($message),
		]);
	}

	public function showTestCaseDebugResult() {
		$permissions = Auth::user()->getAllPermissions()
			->filter(function ($value, $key) {
				if (strpos($value['name'], 'view_run_result') !== false) {
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
		$lang = $this->locale->getRunResultPageLangMessage();
		$message = [
			'lang' => $lang,
			'permissions' => $permissions,
		];

		session(['title' => 'TestCaseDebugResult']);

		return view('UI.ATM.DebugResult.TestCaseDebugResult.testCaseDebugResult', [
			'message' => json_encode($message),
		]);
	}
}
