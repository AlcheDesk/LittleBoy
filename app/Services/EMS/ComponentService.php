<?php
/**
 * Created by PhpStorm.
 * User: scott.fu
 * Date: 2018/1/23
 * Time: 18:44
 */
namespace App\Services\EMS;

use App\Mappers\EMS\ComponentMapper;
use App\Services\UuidService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ComponentService implements UuidService {

	private $mapper;

	public function __construct() {
		$this->mapper = new ComponentMapper();
	}

	public function deleteByConditionRequest(Request $request): string{
		// get the Model objects from mapper layer
		$jsonStringResponse = $this->mapper->deleteByOptions($this->mapper->parse_query($request->getQueryString()));
		Log::debug('Service layer ' . __CLASS__ . ' ' . __FUNCTION__ . ' return ' . var_export($jsonStringResponse, true));
		return $jsonStringResponse;
	}

	public function deleteByUuidRequest(Request $request, $uuid): string{
		// get the Model objects from mapper layer
		$jsonStringResponse = $this->mapper->deleteByUuid($uuid);
		Log::debug('Service layer ' . __CLASS__ . ' ' . __FUNCTION__ . ' return ' . var_export($jsonStringResponse, true));
		return $jsonStringResponse;
	}

	public function insertRequest(Request $request): string{
		// get the Model objects from mapper layer
		$jsonStringResponse = $this->mapper->insert($request->getContent());
		Log::debug('Service layer ' . __CLASS__ . ' ' . __FUNCTION__ . ' return ' . var_export($jsonStringResponse, true));
		return $jsonStringResponse;
	}

	public function selectByConditionRequest(Request $request): string{
		// get the Model objects from mapper layer
		$jsonStringResponse = $this->mapper->selectByOptions($this->mapper->parse_query($request->getQueryString()));
		Log::debug('Service layer ' . __CLASS__ . ' ' . __FUNCTION__ . ' return ' . var_export($jsonStringResponse, true));
		return $jsonStringResponse;
	}

	public function selectByUuidRequest(Request $request, $uuid): string{
		// get the Model objects from mapper layer
		$jsonStringResponse = $this->mapper->selectByUuid($this->mapper->parse_query($request->getQueryString()), $uuid);
		Log::debug('Service layer ' . __CLASS__ . ' ' . __FUNCTION__ . ' return ' . var_export($jsonStringResponse, true));
		return $jsonStringResponse;
	}

	public function updateRequest(Request $request): string{
		// get the Model objects from mapper layer
		$jsonStringResponse = $this->mapper->update($request->getContent());
		Log::debug('Service layer ' . __CLASS__ . ' ' . __FUNCTION__ . ' return ' . var_export($jsonStringResponse, true));
		return $jsonStringResponse;
	}

	public function replaceRequest(Request $request): string{
		// get the Model objects from mapper layer
		$jsonStringResponse = $this->mapper->replace($request->getContent());
		Log::debug('Service layer ' . __CLASS__ . ' ' . __FUNCTION__ . ' return ' . var_export($jsonStringResponse, true));
		return $jsonStringResponse;
	}
}
