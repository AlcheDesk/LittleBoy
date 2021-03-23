<?php
/**
 * Created by PhpStorm.
 * User: liu
 * Time: 2018/01/31 16:21
 */
namespace App\Services\ATM;

use App\Mappers\ATM\CountMapper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class CountService {

	private $mapper;

	public function __construct() {
		$this->mapper = new CountMapper();
	}

	public function getAliasNumber(Request $request) : string {
		$jsonStringResponse = $this->mapper->getAliasNumber($this->mapper->parse_query($request->getQueryString()));
		Log::debug('Service layer ' . __CLASS__ . ' ' . __FUNCTION__ . ' return ' . var_export($jsonStringResponse, true));
		return $jsonStringResponse;
	}

	public function getApplicationNumber(Request $request) : string {
		$jsonStringResponse = $this->mapper->getApplicationNumber($this->mapper->parse_query($request->getQueryString()));
		Log::debug('Service layer ' . __CLASS__ . ' ' . __FUNCTION__ . ' return ' . var_export($jsonStringResponse, true));
		return $jsonStringResponse;
	}

	public function getDriverNumber(Request $request) : string {
		$jsonStringResponse = $this->mapper->getDriverNumber($this->mapper->parse_query($request->getQueryString()));
		Log::debug('Service layer ' . __CLASS__ . ' ' . __FUNCTION__ . ' return ' . var_export($jsonStringResponse, true));
		return $jsonStringResponse;
	}

	public function getDriverPackNumber(Request $request) : string {
		$jsonStringResponse = $this->mapper->getDriverPackNumber($this->mapper->parse_query($request->getQueryString()));
		Log::debug('Service layer ' . __CLASS__ . ' ' . __FUNCTION__ . ' return ' . var_export($jsonStringResponse, true));
		return $jsonStringResponse;
	}

	public function getDriverPropertyNumber(Request $request) : string {
		$jsonStringResponse = $this->mapper->getDriverPropertyNumber($this->mapper->parse_query($request->getQueryString()));
		Log::debug('Service layer ' . __CLASS__ . ' ' . __FUNCTION__ . ' return ' . var_export($jsonStringResponse, true));
		return $jsonStringResponse;
	}

	public function getElementNumber(Request $request) : string {
		$jsonStringResponse = $this->mapper->getElementNumber($this->mapper->parse_query($request->getQueryString()));
		Log::debug('Service layer ' . __CLASS__ . ' ' . __FUNCTION__ . ' return ' . var_export($jsonStringResponse, true));
		return $jsonStringResponse;
	}

	public function getExecutionLogNumber(Request $request) : string {
		$jsonStringResponse = $this->mapper->getExecutionLogNumber($this->mapper->parse_query($request->getQueryString()));
		Log::debug('Service layer ' . __CLASS__ . ' ' . __FUNCTION__ . ' return ' . var_export($jsonStringResponse, true));
		return $jsonStringResponse;
	}

	public function getElementTypeNumber(Request $request) : string {
		$jsonStringResponse = $this->mapper->getElementTypeNumber($this->mapper->parse_query($request->getQueryString()));
		Log::debug('Service layer ' . __CLASS__ . ' ' . __FUNCTION__ . ' return ' . var_export($jsonStringResponse, true));
		return $jsonStringResponse;
	}

	public function getElementActionNumber(Request $request) : string {
		$jsonStringResponse = $this->mapper->getElementActionNumber($this->mapper->parse_query($request->getQueryString()));
		Log::debug('Service layer ' . __CLASS__ . ' ' . __FUNCTION__ . ' return ' . var_export($jsonStringResponse, true));
		return $jsonStringResponse;
	}

	public function getElementLocatorTypeNumber(Request $request) : string {
		$jsonStringResponse = $this->mapper->getElementLocatorTypeNumber($this->mapper->parse_query($request->getQueryString()));
		Log::debug('Service layer ' . __CLASS__ . ' ' . __FUNCTION__ . ' return ' . var_export($jsonStringResponse, true));
		return $jsonStringResponse;
	}

	public function getFileNumber(Request $request) : string {
		$jsonStringResponse = $this->mapper->getFileNumber($this->mapper->parse_query($request->getQueryString()));
		Log::debug('Service layer ' . __CLASS__ . ' ' . __FUNCTION__ . ' return ' . var_export($jsonStringResponse, true));
		return $jsonStringResponse;
	}

	public function getFileTypeNumber(Request $request) : string {
		$jsonStringResponse = $this->mapper->getFileTypeNumber($this->mapper->parse_query($request->getQueryString()));
		Log::debug('Service layer ' . __CLASS__ . ' ' . __FUNCTION__ . ' return ' . var_export($jsonStringResponse, true));
		return $jsonStringResponse;
	}

	public function getGroupNumber(Request $request) : string {
		$jsonStringResponse = $this->mapper->getGroupNumber($this->mapper->parse_query($request->getQueryString()));
		Log::debug('Service layer ' . __CLASS__ . ' ' . __FUNCTION__ . ' return ' . var_export($jsonStringResponse, true));
		return $jsonStringResponse;
	}

	public function getInstructionNumber(Request $request) : string {
		$jsonStringResponse = $this->mapper->getInstructionNumber($this->mapper->parse_query($request->getQueryString()));
		Log::debug('Service layer ' . __CLASS__ . ' ' . __FUNCTION__ . ' return ' . var_export($jsonStringResponse, true));
		return $jsonStringResponse;
	}

	public function getInstructionBundleNumber(Request $request) : string {
		$jsonStringResponse = $this->mapper->getInstructionBundleNumber($this->mapper->parse_query($request->getQueryString()));
		Log::debug('Service layer ' . __CLASS__ . ' ' . __FUNCTION__ . ' return ' . var_export($jsonStringResponse, true));
		return $jsonStringResponse;
	}

	public function getInstructionOptionNumber(Request $request) : string {
		$jsonStringResponse = $this->mapper->getInstructionOptionNumber($this->mapper->parse_query($request->getQueryString()));
		Log::debug('Service layer ' . __CLASS__ . ' ' . __FUNCTION__ . ' return ' . var_export($jsonStringResponse, true));
		return $jsonStringResponse;
	}

	public function getInstructionResultNumber(Request $request) : string {
		$jsonStringResponse = $this->mapper->getInstructionResultNumber($this->mapper->parse_query($request->getQueryString()));
		Log::debug('Service layer ' . __CLASS__ . ' ' . __FUNCTION__ . ' return ' . var_export($jsonStringResponse, true));
		return $jsonStringResponse;
	}

	public function getInstructionTypeNumber(Request $request) : string {
		$jsonStringResponse = $this->mapper->getInstructionTypeNumber($this->mapper->parse_query($request->getQueryString()));
		Log::debug('Service layer ' . __CLASS__ . ' ' . __FUNCTION__ . ' return ' . var_export($jsonStringResponse, true));
		return $jsonStringResponse;
	}

	public function getInstructionOverwriteNumber(Request $request) : string {
		$jsonStringResponse = $this->mapper->getInstructionOverwriteNumber($this->mapper->parse_query($request->getQueryString()));
		Log::debug('Service layer ' . __CLASS__ . ' ' . __FUNCTION__ . ' return ' . var_export($jsonStringResponse, true));
		return $jsonStringResponse;
	}

	public function getProjectNumber(Request $request) : string {
		$jsonStringResponse = $this->mapper->getProjectNumber($this->mapper->parse_query($request->getQueryString()));
		Log::debug('Service layer ' . __CLASS__ . ' ' . __FUNCTION__ . ' return ' . var_export($jsonStringResponse, true));
		return $jsonStringResponse;
	}

	public function getProjectTypeNumber(Request $request) : string {
		$jsonStringResponse = $this->mapper->getProjectTypeNumber($this->mapper->parse_query($request->getQueryString()));
		Log::debug('Service layer ' . __CLASS__ . ' ' . __FUNCTION__ . ' return ' . var_export($jsonStringResponse, true));
		return $jsonStringResponse;
	}

	public function getPropertyNumber(Request $request) : string {
		$jsonStringResponse = $this->mapper->getPropertyNumber($this->mapper->parse_query($request->getQueryString()));
		Log::debug('Service layer ' . __CLASS__ . ' ' . __FUNCTION__ . ' return ' . var_export($jsonStringResponse, true));
		return $jsonStringResponse;
	}

	public function getRunNumber(Request $request) : string {
		$jsonStringResponse = $this->mapper->getRunNumber($this->mapper->parse_query($request->getQueryString()));
		Log::debug('Service layer ' . __CLASS__ . ' ' . __FUNCTION__ . ' return ' . var_export($jsonStringResponse, true));
		return $jsonStringResponse;
	}

	public function getRunSetNumber(Request $request) : string {
		$jsonStringResponse = $this->mapper->getRunSetNumber($this->mapper->parse_query($request->getQueryString()));
		Log::debug('Service layer ' . __CLASS__ . ' ' . __FUNCTION__ . ' return ' . var_export($jsonStringResponse, true));
		return $jsonStringResponse;
	}

	public function getSectionNumber(Request $request) : string {
		$jsonStringResponse = $this->mapper->getSectionNumber($this->mapper->parse_query($request->getQueryString()));
		Log::debug('Service layer ' . __CLASS__ . ' ' . __FUNCTION__ . ' return ' . var_export($jsonStringResponse, true));
		return $jsonStringResponse;
	}

	public function getStepLogNumber(Request $request) : string {
		$jsonStringResponse = $this->mapper->getStepLogNumber($this->mapper->parse_query($request->getQueryString()));
		Log::debug('Service layer ' . __CLASS__ . ' ' . __FUNCTION__ . ' return ' . var_export($jsonStringResponse, true));
		return $jsonStringResponse;
	}

	public function getStepLogTypeNumber(Request $request) : string {
		$jsonStringResponse = $this->mapper->getStepLogTypeNumber($this->mapper->parse_query($request->getQueryString()));
		Log::debug('Service layer ' . __CLASS__ . ' ' . __FUNCTION__ . ' return ' . var_export($jsonStringResponse, true));
		return $jsonStringResponse;
	}

	public function getStorageNumber(Request $request) : string {
		$jsonStringResponse = $this->mapper->getStorageNumber($this->mapper->parse_query($request->getQueryString()));
		Log::debug('Service layer ' . __CLASS__ . ' ' . __FUNCTION__ . ' return ' . var_export($jsonStringResponse, true));
		return $jsonStringResponse;
	}

	public function getSystemRequirementNumber(Request $request) : string {
		$jsonStringResponse = $this->mapper->getSystemRequirementNumber($this->mapper->parse_query($request->getQueryString()));
		Log::debug('Service layer ' . __CLASS__ . ' ' . __FUNCTION__ . ' return ' . var_export($jsonStringResponse, true));
		return $jsonStringResponse;
	}

	public function getSystemRequirementPackNumber(Request $request) : string {
		$jsonStringResponse = $this->mapper->getSystemRequirementPackNumber($this->mapper->parse_query($request->getQueryString()));
		Log::debug('Service layer ' . __CLASS__ . ' ' . __FUNCTION__ . ' return ' . var_export($jsonStringResponse, true));
		return $jsonStringResponse;
	}

	public function getTestCaseNumber(Request $request) : string {
		$jsonStringResponse = $this->mapper->getTestCaseNumber($this->mapper->parse_query($request->getQueryString()));
		Log::debug('Service layer ' . __CLASS__ . ' ' . __FUNCTION__ . ' return ' . var_export($jsonStringResponse, true));
		return $jsonStringResponse;
	}

	public function getTestCaseFolderNumber(Request $request) : string {
		$jsonStringResponse = $this->mapper->getTestCaseFolderNumber($this->mapper->parse_query($request->getQueryString()));
		Log::debug('Service layer ' . __CLASS__ . ' ' . __FUNCTION__ . ' return ' . var_export($jsonStringResponse, true));
		return $jsonStringResponse;
	}

	public function getTestCaseReferenceNumber(Request $request) : string {
		$jsonStringResponse = $this->mapper->getTestCaseReferenceNumber($this->mapper->parse_query($request->getQueryString()));
		Log::debug('Service layer ' . __CLASS__ . ' ' . __FUNCTION__ . ' return ' . var_export($jsonStringResponse, true));
		return $jsonStringResponse;
	}

	public function getTestCaseOptionNumber(Request $request) : string {
		$jsonStringResponse = $this->mapper->getTestCaseOptionNumber($this->mapper->parse_query($request->getQueryString()));
		Log::debug('Service layer ' . __CLASS__ . ' ' . __FUNCTION__ . ' return ' . var_export($jsonStringResponse, true));
		return $jsonStringResponse;
	}

	public function getTestCaseOverwriteNumber(Request $request) : string {
		$jsonStringResponse = $this->mapper->getTestCaseOverwriteNumber($this->mapper->parse_query($request->getQueryString()));
		Log::debug('Service layer ' . __CLASS__ . ' ' . __FUNCTION__ . ' return ' . var_export($jsonStringResponse, true));
		return $jsonStringResponse;
	}

	public function getTagsRelationTestCaseNumber(Request $request) : string {
		$jsonStringResponse = $this->mapper->getTagsRelationTestCaseNumber($this->mapper->parse_query($request->getQueryString()));
		Log::debug('Service layer ' . __CLASS__ . ' ' . __FUNCTION__ . ' return ' . var_export($jsonStringResponse, true));
		return $jsonStringResponse;
	}

	public function getRunSetTestCaseLinkNumber(Request $request) : string {
		$jsonStringResponse = $this->mapper->getRunSetTestCaseLinkNumber($this->mapper->parse_query($request->getQueryString()));
		Log::debug('Service layer ' . __CLASS__ . ' ' . __FUNCTION__ . ' return ' . var_export($jsonStringResponse, true));
		return $jsonStringResponse;
	}

	public function getEmailNotificationTargetNumber(Request $request) : string {
		$jsonStringResponse = $this->mapper->getEmailNotificationTargetNumber($this->mapper->parse_query($request->getQueryString()));
		Log::debug('Service layer ' . __CLASS__ . ' ' . __FUNCTION__ . ' return ' . var_export($jsonStringResponse, true));
		return $jsonStringResponse;
	}

	public function getTestCaseShareFolderNumber(Request $request) : string {
		$jsonStringResponse = $this->mapper->getTestCaseShareFolderNumber($this->mapper->parse_query($request->getQueryString()));
		Log::debug('Service layer ' . __CLASS__ . ' ' . __FUNCTION__ . ' return ' . var_export($jsonStringResponse, true));
		return $jsonStringResponse;
	}

	public function validateTestCaseDelete(Request $request, $id) : string {
		$jsonStringResponse = $this->mapper->validateTestCaseDelete($this->mapper->parse_query($request->getQueryString()), $id);
		Log::debug('Service layer ' . __CLASS__ . ' ' . __FUNCTION__ . ' return ' . var_export($jsonStringResponse, true));
		return $jsonStringResponse;
	}
}
