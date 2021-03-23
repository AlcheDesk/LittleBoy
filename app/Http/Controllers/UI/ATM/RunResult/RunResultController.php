<?php
namespace App\Http\Controllers\UI\ATM\RunResult;

use App\Http\Controllers\LanguageController;
use App\Http\Controllers\API\MeowlomoBaseController;
use Illuminate\Support\Facades\Auth;

class RunResultController extends MeowlomoBaseController {

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

	public function showProjectRunResult() {
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

		session(['title' => 'ProjectResult']);

		return view('UI.ATM.RunResult.ProjectRunResult.projectRunResult', [
			'message' => json_encode($message),
		]);
	}

	public function showRunResultProjectCharts($projectId) {
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

		session(['title' => 'ProjectResult'.'-'. $projectId]);

		return view('UI.ATM.RunResult.ProjectRunResult.projectCharts', [
			'message' => json_encode($message),
		]);
	}

	public function showProjectTestCaseRunResult($projectId) {
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

		session(['title' => 'ProjectResult'.'-'. $projectId]);

		return view('UI.ATM.RunResult.ProjectRunResult.testCaseRunResult', [
			'message' => json_encode($message),
		]);
	}

	public function showTestCaseRunRunResult($projectId, $testCaseId) {
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

		session(['title' => 'TestCaseResult'.'-'. $testCaseId]);

		return view('UI.ATM.RunResult.ProjectRunResult.runTestCaseRunResult', [
			'message' => json_encode($message),
		]);
	}

	public function showRunInstructionRunResult($projectId, $testCaseId, $runId) {
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

		session(['title' => 'ResultRun'.'-'. $runId]);

		return view('UI.ATM.RunResult.ProjectRunResult.instructionRunResult', [
			'message' => json_encode($message),
		]);
	}

	public function showApiInstructionResultLog($projectId, $testCaseId, $runId) {
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

		session(['title' => 'ResultRun'.'-'. $runId]);

		return view('UI.ATM.RunResult.ProjectRunResult.apiInstructionResultLog', [
			'message' => json_encode($message),
		]);
	}

	public function showRunListRunResult() {
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

		session(['title' => 'RunListResult']);

		return view('UI.ATM.RunResult.RunListRunResult.runListRunResult', [
			'message' => json_encode($message),
		]);
	}

	public function showRunListTestCaseRunResult($runListId) {
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

		session(['title' => 'RunListResult'.'-'. $runListId]);

		return view('UI.ATM.RunResult.RunListRunResult.testCaseRunResult', [
			'message' => json_encode($message),
		]);
	}

	public function showTestCaseRunResult() {
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

		session(['title' => 'TestCaseResult']);

		return view('UI.ATM.RunResult.TestCaseRunResult.testCaseRunResult', [
			'message' => json_encode($message),
		]);
	}
}
