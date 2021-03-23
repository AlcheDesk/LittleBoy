<?php

namespace App\Http\Controllers\UI\RBAC;

use App\Http\Controllers\Controller;

class RBACLanguageController extends Controller {
	//
	
	public function __construct() {
		$this->basic = config('lang.info.RBAC.basic');
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
		$item = config('lang.type.' . $langType . '.' . 'RBAC' . '.' . $str);
		return $item;
	} 

	public function getBasicLangMessage($str) {
		$lang = [];
		foreach ($this->basic as $key => $value) {
			$lang[$key] = [];
			foreach ($value as $k => $v) {

				if (is_array($v)) {
					foreach ($v as $p) {
						$lang[$key][$k][$p] = __('RBAC' . '.' . $key . '.' . $k . '.' . $p, ['name' => $str]);
					}
				} else {
					$lang[$key][$v] = __('RBAC' . '.' . $key . '.' . $v);
				}

			}
		}
		return $lang;
	}

	public function getAllLangMessage(String $strType) {
		
		$str = $this->getStrItem($strType);
		
		$array = config('lang.info.RBAC.' . $strType);

		$lang = $this->getBasicLangMessage($str);

		foreach ($array as $key => $value) {

			foreach ($value as $k => $v) {

				if (is_array($v)) {
					foreach ($v as $p) {
						$lang[$key][$k][$p] = __('RBAC' . '.' . $key . '.' . $k . '.' . $p, ['name' => $str]);
					}
				} else {
					$lang[$key][$v] = __('RBAC' . '.' . $key . '.' . $v);
				}

			}
		}

		return $lang;
	}

	public function getAuthManagePageLangMessage() {

		$strType = 'system_permission';

		$lang = $this->getAllLangMessage($strType);

		return $lang;
	}

	public function getGroupManagementPageLangMessage() {

		$strType = 'group';

		$lang = $this->getAllLangMessage($strType);

		return $lang;
	}

	public function getUserManagementPageLangMessage() {

		$strType = 'user';

		$lang = $this->getAllLangMessage($strType);

		return $lang;
	}

	public function getGroupUserManagementPageLangMessage() {

		$strType = 'group_user';

		$lang = $this->getAllLangMessage($strType);

		return $lang;
	}

	public function getGroupPermissionManagementPageLangMessage() {

		$strType = 'group_permission';

		$lang = $this->getAllLangMessage($strType);

		return $lang;
	}

	public function getUserLogPageLangMessage() {

		$strType = 'record';

		$lang = $this->getAllLangMessage($strType);

		return $lang;
	}
}
