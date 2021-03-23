<?php
/**
 * User: tryndamere.wang
 * Date: 2018/12/20
 * Time: 10:39
 */
namespace App\Services\ATM;

use App\Mappers\ATM\AlarmSetMapper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class AlarmSetService {

	private $mapper;

	public function __construct() {
		$this->mapper = new AlarmSetMapper();
	}

	public function getAlarmSetByRunSetId(Request $request, $id) : string {
		$jsonStringResponse = $this->mapper->getAlarmSetByRunSetId($id);
		Log::debug('Service layer ' . __CLASS__ . ' ' . __FUNCTION__ . ' return ' . var_export($jsonStringResponse, true));
		return $jsonStringResponse;
	}

	public function addOrPatchAlarmSetByRunSetId(Request $request, $id) : string {
		$jsonStringResponse = $this->mapper->addOrPatchAlarmSetByRunSetId($request->getContent(), $id);
		Log::debug('Service layer ' . __CLASS__ . ' ' . __FUNCTION__ . ' return ' . var_export($jsonStringResponse, true));
		return $jsonStringResponse;
	}

	public function deleteAlarmSetByRunSetIdAndTriggerUUID($id, $uuid) : string {
		$jsonStringResponse = $this->mapper->deleteAlarmSetByRunSetIdAndTriggerUUID($id, $uuid);
		Log::debug('Service layer ' . __CLASS__ . ' ' . __FUNCTION__ . ' return ' . var_export($jsonStringResponse, true));
		return $jsonStringResponse;
	}
}
