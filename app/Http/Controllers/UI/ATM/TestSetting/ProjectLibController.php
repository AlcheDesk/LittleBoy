<?php
namespace App\Http\Controllers\UI\ATM\TestSetting;

use App\Http\Controllers\LanguageController;
use App\Http\Controllers\API\MeowlomoBaseController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;

class ProjectLibController extends MeowlomoBaseController {

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

	public function showProject() {
		$permissions = Auth::user()->getAllPermissions()
			->filter(function ($value, $key) {
				if (strpos($value['name'], 'projects') !== false) {
					return true;
				}
				if (strpos($value['name'], 'system') !== false) {
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
		$lang = $this->locale->getProjectLibPageLangMessage();
		$message = [
			'lang' => $lang,
			'permissions' => $permissions,
		];

		session(['title' => 'Project']);

		return view('UI.ATM.TestSettings.ProjectLib.project', [
			'message' => json_encode($message),
		]);
	}

	public function showProjectTestCase($pid) {
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

		session(['title' => 'Project'.'-'. $pid]);

		return view('UI.ATM.TestSettings.ProjectLib.projectTestCase', [
			'message' => json_encode($message),
		]);
	}

	public function showTestCaseInstruction($pid, $tid) {
		$permissions = Auth::user()->getAllPermissions()
			->filter(function ($value, $key) {
				if (strpos($value['name'], 'instruction') !== false) {
					return true;
				}
				if (strpos($value['name'], 'run_test_case') !== false) {
					return true;
				}
				if (strpos($value['name'], 'overwrites') !== false) {
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
		$lang = $this->locale->getTestCaseInstructionPageLangMessage();
        $hiddenIns = Config::get('meowlomo.hidden_instruction_keys') ?? '';
		$message = [
			'lang' => $lang,
			'permissions' => $permissions,
            'hiddenInstructions' => $hiddenIns ? array_filter(explode(',', $hiddenIns)) : []
		];

		session(['title' => 'TestCase'.'-'. $tid]);

		return view('UI.ATM.TestSettings.ProjectLib.testCaseInstruction', [
			'message' => json_encode($message),
		]);
	}

	public function showTestCaseApiInstruction($pid, $tid) {
		$permissions = Auth::user()->getAllPermissions()
			->filter(function ($value, $key) {
				if (strpos($value['name'], 'instruction') !== false) {
					return true;
				}
				if (strpos($value['name'], 'run_test_case') !== false) {
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
		$lang = $this->locale->getApiEditLangMessage();
		$message = [
			'lang' => $lang,
			'permissions' => $permissions,
		];

		session(['title' => 'TestCase'.'-'. $tid]);

		return view('UI.ATM.TestSettings.ProjectLib.testCaseApiInstruction', [
			'message' => json_encode($message),
		]);
	}

	public function showProjectApplication($pid) {
		$permissions = Auth::user()->getAllPermissions()
			->filter(function ($value, $key) {
				if (strpos($value['name'], 'application') !== false) {
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
		$lang = $this->locale->getApplicationPageLangMessage();
		$message = [
			'lang' => $lang,
			'permissions' => $permissions,
		];

		session(['title' => 'Project'.'-'. $pid]);

		return view('UI.ATM.TestSettings.ProjectLib.projectApplication', [
			'message' => json_encode($message),
		]);
	}

	public function showApplicationSection($pid, $aid) {
		$permissions = Auth::user()->getAllPermissions()
			->filter(function ($value, $key) {
				if (strpos($value['name'], 'section') !== false) {
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
		$lang = $this->locale->getSectionPageLangMessage();
		$message = [
			'lang' => $lang,
			'permissions' => $permissions,
		];

		session(['title' => 'Application'.'-'. $aid]);

		return view('UI.ATM.TestSettings.ProjectLib.applicationSection', [
			'message' => json_encode($message),
		]);
	}

	public function showSectionElement($pid, $aid, $sid) {
		$permissions = Auth::user()->getAllPermissions()
			->filter(function ($value, $key) {
				if (strpos($value['name'], 'element') !== false) {
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
		$lang = $this->locale->getElementPageLangMessage();
		$message = [
			'lang' => $lang,
			'permissions' => $permissions,
		];

		session(['title' => 'Section'.'-'. $sid]);

		return view('UI.ATM.TestSettings.ProjectLib.sectionElement', [
			'message' => json_encode($message),
		]);
	}

	public function showProjectApiElement($pid) {
		$permissions = Auth::user()->getAllPermissions()
			->filter(function ($value, $key) {
				if (strpos($value['name'], 'element') !== false) {
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
		$lang = $this->locale->getApiElementManageLangMessage();
		$message = [
			'lang' => $lang,
			'permissions' => $permissions,
		];

		session(['title' => 'Project'.'-'. $pid]);

		return view('UI.ATM.TestSettings.ProjectLib.projectApiElement', [
			'message' => json_encode($message),
		]);
	}

	public function showProjectApiElementEdit($pid) {
		$permissions = Auth::user()->getAllPermissions()
			->filter(function ($value, $key) {
				if (strpos($value['name'], 'element') !== false) {
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
		$lang = $this->locale->getApiElementEditLangMessage();
		$message = [
			'lang' => $lang,
			'permissions' => $permissions,
		];

		session(['title' => 'Project'.'-'. $pid]);

		return view('UI.ATM.TestSettings.ProjectLib.projectApiElementEdit', [
			'message' => json_encode($message),
		]);
	}

	public function showSystemSetting() {
		$permissions = Auth::user()->getAllPermissions()
			->filter(function ($value, $key) {
				if (strpos($value['name'], 'system') !== false) {
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
		$lang = $this->locale->getSystemSettingPageLangMessage();
		$message = [
			'lang' => $lang,
			'permissions' => $permissions,
		];

		session(['title' => 'SystemSetting']);

		return view('UI.ATM.TestSettings.ProjectLib.SystemSetting', [
			'message' => json_encode($message),
		]);
	}
}
