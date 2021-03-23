<?php

namespace App\Http\Controllers\UI\EMS;

use App\Http\Controllers\API\MeowlomoBaseController;
use Illuminate\Support\Facades\Auth;

class EMSController extends MeowlomoBaseController {

	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	private $locale;

	public function __construct() {
		$this->locale = new EMSLanguageController();
	}

	public function showControlCenter() {
		// $permissions = Auth::user()->getAllPermissions()
		// 	->filter(function ($value, $key) {
		// 		if (strpos($value['name'], 'run_sets') !== false) {
		// 			return true;
		// 		}
		// 	})
		// 	->flatten()
		// 	->pluck('name')
		// 	->map(function ($name) {
		// 		return [
		// 			$name => true,
		// 		];
		// 	})
		// 	->collapse()
		// 	->all();
		$lang = $this->locale->getControlCenterLangMessage();
		$message = [
			'lang' => $lang,
			// 'permissions' => $permissions,
		];
		return view('UI.EMS.page.controlCenter', [
			'message' => json_encode($message),
		]);
	}

	public function showWork() {
		$permissions = Auth::user()->getAllPermissions()
			->filter(function ($value, $key) {
				if (strpos($value['name'], 'view_ems_test_case_details') !== false) {
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
		$lang = $this->locale->getWorkLangMessage();
		$message = [
			'lang' => $lang,
			'permissions' => $permissions,
		];
		return view('UI.EMS.page.work', [
			'message' => json_encode($message),
		]);
	}

	public function showTask() {
		// $permissions = Auth::user()->getAllPermissions()
		// 	->filter(function ($value, $key) {
		// 		if (strpos($value['name'], 'run_sets') !== false) {
		// 			return true;
		// 		}
		// 	})
		// 	->flatten()
		// 	->pluck('name')
		// 	->map(function ($name) {
		// 		return [
		// 			$name => true,
		// 		];
		// 	})
		// 	->collapse()
		// 	->all();
		$lang = $this->locale->getTaskLangMessage();
		$message = [
			'lang' => $lang,
			// 'permissions' => $permissions,
		];
		return view('UI.EMS.page.task', [
			'message' => json_encode($message),
		]);
	}

	public function showExecutionUnit() {
		// $permissions = Auth::user()->getAllPermissions()
		// 	->filter(function ($value, $key) {
		// 		if (strpos($value['name'], 'run_sets') !== false) {
		// 			return true;
		// 		}
		// 	})
		// 	->flatten()
		// 	->pluck('name')
		// 	->map(function ($name) {
		// 		return [
		// 			$name => true,
		// 		];
		// 	})
		// 	->collapse()
		// 	->all();
		$lang = $this->locale->getExecutionUnitLangMessage();
		$message = [
			'lang' => $lang,
			// 'permissions' => $permissions,
		];
		return view('UI.EMS.page.executionUnit', [
			'message' => json_encode($message),
		]);
	}
}
