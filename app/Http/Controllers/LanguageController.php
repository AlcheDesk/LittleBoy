<?php
namespace App\Http\Controllers;

class LanguageController extends Controller {
/**
 * Show the application dashboard.
 *
 * @return \Illuminate\Http\Response
 */

	public function __construct() {
		$this->basic = config('lang.info.ATM.basic');
	}

	public function setLocale($locale) {
		session(['lang' => $locale]);
		return back()->withInput();
	}

	public function getLocale() {
		$locale = session('lang');
		return $locale;
	}

	public function getStrItem($str) {
		$langType = $this->getLocale();
		$item = config('lang.type.' . $langType . '.' . 'ATM' . '.' . $str);
		return $item;
	} 

	public function getBasicLangMessage($str) {
		$lang = [];
		foreach ($this->basic as $key => $value) {
			$lang[$key] = [];
			foreach ($value as $k => $v) {

				if (is_array($v)) {
					foreach ($v as $p) {
						$lang[$key][$k][$p] = __('info' . '.' . $key . '.' . $k . '.' . $p, ['name' => $str]);
					}
				} else {
					$lang[$key][$v] = __('info' . '.' . $key . '.' . $v);
				}

			}
		}
		return $lang;
	}

	public function getAllLangMessage(String $strType) {
		
		$str = $this->getStrItem($strType);
		
		$array = config('lang.info.ATM.' . $strType);

		$lang = $this->getBasicLangMessage($str);

		foreach ($array as $key => $value) {

			foreach ($value as $k => $v) {

				if (is_array($v)) {
					foreach ($v as $p) {
						$lang[$key][$k][$p] = __('info' . '.' . $key . '.' . $k . '.' . $p, ['name' => $str]);
					}
				} else {
					$lang[$key][$v] = __('info' . '.' . $key . '.' . $v);
				}

			}
		}

		return $lang;
	}

	//instruction bundle
	public function getInstructionBundlePageLangMessage() {

		$strType = 'instruction_bundle';

		$lang = $this->getAllLangMessage($strType);

		return $lang;
	}

	public function getInstructionBundleEntryPageLangMessage() {

		$strType = 'bundle_entry';

		$lang = $this->getAllLangMessage($strType);

		return $lang;
	}

	//projectLib
	public function getProjectLibPageLangMessage() {

		$strType = 'project_lib';

		$lang = $this->getAllLangMessage($strType);

		return $lang;
	}

	public function getTestCasePageLangMessage() {

		$strType = 'test_case';

		$lang = $this->getAllLangMessage($strType);
		
		$strTypeTag = 'test_case_tag';
		$langType = $this->getLocale();
		$item = config('lang.type.' . $langType . '.'  . $strTypeTag);
		$lang['dialog']['title']['delete_tag'] = __('info.dialog.title.delete', ['name' => $item]);

		return $lang;
	}

	public function getTestCaseInstructionPageLangMessage() {
		$strType = 'instruction';

		$lang = $this->getAllLangMessage($strType);

		return $lang;
	}

	public function getApiEditLangMessage() {
		$strType = 'api_instruction';

		$lang = $this->getAllLangMessage($strType);

		return $lang;
	}

	public function getApiElementManageLangMessage() {
		$strType = 'api_element';

		$lang = $this->getAllLangMessage($strType);

		return $lang;
	}

	public function getApiElementEditLangMessage() {
		$strType = 'api_element_edit';

		$lang = $this->getAllLangMessage($strType);

		return $lang;
	}

	//application
	public function getApplicationPageLangMessage() {
		$strType = 'application';

		$lang = $this->getAllLangMessage($strType);

		return $lang;
	}

	public function getSectionPageLangMessage() {
		$strType = 'section';

		$lang = $this->getAllLangMessage($strType);

		return $lang;
	}

	public function getElementPageLangMessage() {
		$strType = 'element';

		$lang = $this->getAllLangMessage($strType);

		return $lang;
	}

	//runlist
	public function getRunListPageLangMessage() {
		$strType = 'run_list';

		$lang = $this->getAllLangMessage($strType);
		
		$strTypeTag = 'run_list_tag';
		$langType = $this->getLocale();
		$item = config('lang.type.' . $langType . '.'  . $strTypeTag);
		$lang['dialog']['title']['delete_tag'] = __('info.dialog.title.delete', ['name' => $item]);

		return $lang;
	}

	public function getRunListTestCasePageLangMessage() {
		$strType = 'run_list_test_case';

		$lang = $this->getAllLangMessage($strType);

		return $lang;
	}

	//modulePro

	public function getEnginePageLangMessage() {
		$strType = 'engine';

		$lang = $this->getAllLangMessage($strType);

		return $lang;
	}

	public function getEnginePropertyPageLangMessage() {
		$strType = 'engine_property';

		$lang = $this->getAllLangMessage($strType);

		return $lang;
	}

	public function getEnginePackagePageLangMessage() {
		$strType = 'engine_package';

		$lang = $this->getAllLangMessage($strType);

		return $lang;
	}

	public function getRunStatusPageLangMessage() {
		$strType = 'run_status';

		$lang = $this->getAllLangMessage($strType);

		return $lang;
	}

	public function getSystemRequirementsPacksPageLangMessage() {
		$strType = 'system_requirements_packs';

		$lang = $this->getAllLangMessage($strType);

		return $lang;
	}

	public function getPacksSystemRequirementsPageLangMessage() {
		$strType = 'packs_system_requirements';

		$lang = $this->getAllLangMessage($strType);

		return $lang;
	}


	//runResult

	public function getRunResultPageLangMessage() {
		$strType = 'run_result';

		$lang = $this->getAllLangMessage($strType);

		return $lang;
	}

	public function getSystemSettingPageLangMessage() {
		$strType = 'system_set';

		$lang = $this->getAllLangMessage($strType);

		return $lang;
	}

	//folder
	public function getFolderPageLangMessage() {
		$strType = 'folder';

		$lang = $this->getAllLangMessage($strType);

		return $lang;
	}

	public function getFolderTestCasePageLangMessage() {
		$strType = 'folder_test_case';

		$lang = $this->getAllLangMessage($strType);

		return $lang;
	}

}