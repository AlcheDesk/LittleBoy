<?php
/**
 * Created by sublime.
 * User: dawang
 * Date: 2019/9/4
 * Time: 14:08
 */
namespace App\Services\ATM;

use App\Mappers\ATM\ContentTypesMapper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ContentTypesService {

	private $mapper;
	private $runRedisUtilService;
	private $instructionResultRedisUtilService;

	public function __construct() {
		$this->mapper = new ContentTypesMapper();
	}

	public function selectByCondition(Request $request) : string {
		// get the Model objects from mapper layer
		$jsonStringResponse = $this->mapper->selectByOptions($this->mapper->parse_query($request->getQueryString()));
		Log::debug('Service layer ' . __CLASS__ . ' ' . __FUNCTION__ . ' return ' . var_export($jsonStringResponse, true));
		return $jsonStringResponse;
	}
}
