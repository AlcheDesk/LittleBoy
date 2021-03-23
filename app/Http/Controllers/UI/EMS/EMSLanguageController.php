<?php

namespace App\Http\Controllers\UI\EMS;

use App\Http\Controllers\API\MeowlomoBaseController;

class EMSLanguageController extends MeowlomoBaseController {

	public function getLangMessage($arr) {
		$lang = [];
		foreach ($arr as $key => $value) {
			$lang[$key] = [];
			foreach ($value as $k => $v) {

				$lang[$key][$v] = __('EMS' . '.' . $key . '.' . $v);

			}
		}
		return $lang;
	}

	public function getControlCenterLangMessage() {

		$arr = config('lang.info.EMS.' . 'controll_center');

		$lang = $this->getLangMessage($arr);

		return $lang;
	}

	public function getWorkLangMessage() {

		$arr = config('lang.info.EMS.' . 'work');

		$lang = $this->getLangMessage($arr);

		return $lang;
	}

	public function getTaskLangMessage() {

		$arr = config('lang.info.EMS.' . 'task');

		$lang = $this->getLangMessage($arr);

		return $lang;
	}

	public function getExecutionUnitLangMessage() {

		$arr = config('lang.info.EMS.' . 'execution_unit');

		$lang = $this->getLangMessage($arr);

		return $lang;
	}

}
