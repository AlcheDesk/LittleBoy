<?php

namespace App\Http\Controllers\UI\ATM\TestSetting;

use App\Http\Controllers\LanguageController;
use App\Http\Controllers\API\MeowlomoBaseController;
use Illuminate\Support\Facades\Auth;

class InstructionBundleController extends MeowlomoBaseController {

	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 *
	 */

	private $locale;

	public function __construct() {
		$this->middleware('auth');
		$this->locale = new LanguageController();
	}

	public function showInstructionBundle() {
		$permissions = Auth::user()->getAllPermissions()
			->filter(function ($value, $key) {
				if (strpos($value['name'], 'instruction_bundle') !== false) {
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
		$lang = $this->locale->getInstructionBundlePageLangMessage();
		$message = [
			'lang' => $lang,
			'permissions' => $permissions,
		];

		session(['title' => 'InstructionBulder']);

		return view('UI.ATM.TestSettings.InstructionBundle.instructionBundle', [
			'message' => json_encode($message),
		]);
	}

	public function showInstructionBundleEntry($iid) {
		$permissions = Auth::user()->getAllPermissions()
			->filter(function ($value, $key) {
				if (strpos($value['name'], 'instruction_bundle_entry') !== false) {
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
		$lang = $this->locale->getInstructionBundleEntryPageLangMessage();
		$message = [
			'lang' => $lang,
			'permissions' => $permissions,
		];

		session(['title' => 'InstructionBulder'.'-'. $iid]);

		return view('UI.ATM.TestSettings.InstructionBundle.instructionBundleEntry', [
			'message' => json_encode($message),
		]);
	}
}
