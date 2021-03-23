<?php
namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;
use Ramsey\Uuid\Uuid;

class MeowlomoBaseController extends Controller {
	protected $noRequestBodyHttpMethod = array("GET", "HEAD", "OPTIONS", "DELETE");

	protected function invalidJsonRequestCall(string $className = '', string $functionName = '') {
		$errorArray = array();
		$errorArray['statusCode'] = 400;
		$errorArray['type'] = 'API';
		$errorArray['message'] = 'the request body is not a valid json';
		$errorArray['uuid'] = Uuid::uuid4();
		$errorArray['date'] = Carbon::now()->toIso8601String();
		$responseArray = ['metadate' => null, 'data' => array(), 'error' => $errorArray];
		$jsonStringResponse = json_encode($responseArray, JSON_UNESCAPED_UNICODE);
		Log::error('Controller layer ' . $className . ' ' . $functionName . ' return ' . var_export($jsonStringResponse, true));
		return response($jsonStringResponse, 400)->header('Content-Type', 'application/json; charset=utf8');
	}
}
