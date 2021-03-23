<?php
namespace App\Http\Controllers\UI\ATM\ModulePro;

use App\Http\Controllers\LanguageController;
use App\Http\Controllers\API\MeowlomoBaseController;
use Illuminate\Support\Facades\Auth;

class ModuleProController extends MeowlomoBaseController {

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

	public function showEngineSetting() {
		$permissions = Auth::user()->getAllPermissions()
			->filter(function ($value, $key) {
				if (strpos($value['name'], 'drivers') !== false) {
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
		$lang = $this->locale->getEnginePageLangMessage();
		$message = [
			'lang' => $lang,
			'permissions' => $permissions,
		];

		session(['title' => 'EngineSetting']);

		return view('UI.ATM.ModulePro.EngineSetting.engineSetting', [
			'message' => json_encode($message),
		]);
	}

	public function showEngineProperties($engineId) {
		$permissions = Auth::user()->getAllPermissions()
			->filter(function ($value, $key) {
				if (strpos($value['name'], 'drivers_properties') !== false) {
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
		$lang = $this->locale->getEnginePropertyPageLangMessage();
		$message = [
			'lang' => $lang,
			'permissions' => $permissions,
		];

		session(['title' => 'EngineSetting'.'-'. $engineId]);

		return view('UI.ATM.ModulePro.EngineSetting.engineProperty', [
			'message' => json_encode($message),
		]);
	}

	public function showDriverPacks() {
		$permissions = Auth::user()->getAllPermissions()
			->filter(function ($value, $key) {
				if (strpos($value['name'], 'drivers_packs') !== false) {
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
		$lang = $this->locale->getEnginePackagePageLangMessage();
		$message = [
			'lang' => $lang,
			'permissions' => $permissions,
		];

		session(['title' => 'DriverPacks']);

		return view('UI.ATM.ModulePro.EnginePackageManagement.enginePackageManagement', [
			'message' => json_encode($message),
		]);
	}

	public function showDriverPacksEngines($packId) {
		$permissions = Auth::user()->getAllPermissions()
			->filter(function ($value, $key) {
				if (strpos($value['name'], 'drivers_pack_drivers') !== false) {
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
		$lang = $this->locale->getEnginePageLangMessage();
		$message = [
			'lang' => $lang,
			'permissions' => $permissions,
		];

		session(['title' => 'DriverPacks'.'-'. $packId]);

		return view('UI.ATM.ModulePro.EnginePackageManagement.packEngines', [
			'message' => json_encode($message),
		]);
	}

	public function showSystemRequirementsPacks() {
		$permissions = Auth::user()->getAllPermissions()
			->filter(function ($value, $key) {
				if (strpos($value['name'], 'system_requirements_packs') !== false) {
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
		$lang = $this->locale->getSystemRequirementsPacksPageLangMessage();
		$message = [
			'lang' => $lang,
			'permissions' => $permissions,
		];

		session(['title' => 'SystemRequirementsPacks']);

		return view('UI.ATM.ModulePro.SystemRequirements.SystemRequirementsPacks', [
			'message' => json_encode($message),
		]);
	}

	public function showPacksSystemRequirements($packId) {
		$permissions = Auth::user()->getAllPermissions()
			->filter(function ($value, $key) {
				if (strpos($value['name'], 'system_requirements') !== false) {
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
		$lang = $this->locale->getPacksSystemRequirementsPageLangMessage();
		$message = [
			'lang' => $lang,
			'permissions' => $permissions,
		];

		session(['title' => 'SystemRequirementsPacks'.'-'. $packId]);

		return view('UI.ATM.ModulePro.SystemRequirements.PacksSystemRequirements', [
			'message' => json_encode($message),
		]);
	}
}
