<?php
/**
 * Created by PhpStorm.
 * User: scott.fu
 * Date: 2018/1/23
 * Time: 18:44
 */
namespace App\Services\ATM;

use App\Mappers\ATM\InstructionBundleMapper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class InstructionBundleService {

	private $mapper;

	public function __construct() {
		$this->mapper = new InstructionBundleMapper();
	}

	public function deleteById(Request $request, $id) : string {
		// get the Model objects from mapper layer
		$jsonStringResponse = $this->mapper->deleteById($id);
		Log::debug('Service layer ' . __CLASS__ . ' ' . __FUNCTION__ . ' return ' . var_export($jsonStringResponse, true));
		return $jsonStringResponse;
	}

	public function insert(Request $request) : string {
		$jsonStringResponse = $this->mapper->insert($request->getContent());
		Log::debug('Service layer ' . __CLASS__ . ' ' . __FUNCTION__ . ' return ' . var_export($jsonStringResponse, true));
		return $jsonStringResponse;
	}

	public function selectByCondition(Request $request) : string {
		// get the Model objects from mapper layer
		$jsonStringResponse = $this->mapper->selectByOptions($this->mapper->parse_query($request->getQueryString()));
		Log::debug('Service layer ' . __CLASS__ . ' ' . __FUNCTION__ . ' return ' . var_export($jsonStringResponse, true));
		return $jsonStringResponse;
	}

	public function selectById(Request $request, $id) : string {
		// get the Model objects from mapper layer
		$jsonStringResponse = $this->mapper->selectById($this->mapper->parse_query($request->getQueryString()), $id);
		Log::debug('Service layer ' . __CLASS__ . ' ' . __FUNCTION__ . ' return ' . var_export($jsonStringResponse, true));
		return $jsonStringResponse;
	}

	public function update(Request $request) : string {
		// get the Model objects from mapper layer
		$jsonStringResponse = $this->mapper->update($request->getContent());
		Log::debug('Service layer ' . __CLASS__ . ' ' . __FUNCTION__ . ' return ' . var_export($jsonStringResponse, true));
		return $jsonStringResponse;
	}

	//instructionBundleEntry
	public function getInstructionBundleEntryByBundleId(Request $request, $bundleId) : string {
		$jsonStringResponse = $this->mapper->getInstructionBundleEntryByBundleId($this->mapper->parse_query($request->getQueryString()), $bundleId);
		Log::debug('Service layer ' . __CLASS__ . ' ' . __FUNCTION__ . ' return ' . var_export($jsonStringResponse, true));
		return $jsonStringResponse;
	}

	public function insertInstructionBundleEntryByBundleId(Request $request, $bundleId) : string {
		$jsonStringResponse = $this->mapper->insertInstructionBundleEntryByBundleId($request->getContent(), $bundleId);
		Log::debug('Service layer ' . __CLASS__ . ' ' . __FUNCTION__ . ' return ' . var_export($jsonStringResponse, true));
		return $jsonStringResponse;
	}

	public function deleteInstructionBundleEntryByBundleId(Request $request, $id) : string {
		$jsonStringResponse = $this->mapper->deleteInstructionBundleEntryByBundleId($id);
		Log::debug('Service layer ' . __CLASS__ . ' ' . __FUNCTION__ . ' return ' . var_export($jsonStringResponse, true));
		return $jsonStringResponse;
	}

	public function updateInstructionBundleEntry(Request $request) : string {
		// get the Model objects from mapper layer
		$jsonStringResponse = $this->mapper->updateInstructionBundleEntry($request->getContent());
		Log::debug('Service layer ' . __CLASS__ . ' ' . __FUNCTION__ . ' return ' . var_export($jsonStringResponse, true));
		return $jsonStringResponse;
	}
}
