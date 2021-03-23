<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

class Handler extends ExceptionHandler {
	/**
	 * A list of the exception types that are not reported.
	 *
	 * @var array
	 */
	protected $dontReport = [
		//
	];

	/**
	 * A list of the inputs that are never flashed for validation exceptions.
	 *
	 * @var array
	 */
	protected $dontFlash = [
		'password',
		'password_confirmation',
	];

	/**
	 * Report or log an exception.
	 *
	 * @param  \Exception  $exception
	 * @return void
	 */
	public function report(Exception $exception) {
		parent::report($exception);
	}

	/**
	 * Render an exception into an HTTP response.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Exception  $exception
	 * @return \Illuminate\Http\Response
	 */
	public function render($request, Exception $exception) {
		if ($request->expectsJson()) {
			//add Accept: application/json in request header, this is for api error handling
			return $this->handleApiException($request, $exception);
		} else if (strpos($request->getUri(), '/api/') !== false) {
			// check if the full url contains the api path, if yes ,we mar kit as a action
			return $this->handleApiException($request, $exception);
		} else {
			$retval = parent::render($request, $exception); //this is for normal error handling
		}
		return $retval;

	}

	/**
	 * Handle the Api exception and response with custom response body
	 */
	private function handleApiException($request, Exception $exception) {

		/**
		 * we do the following
		 * 1: check the exception type
		 * 2: base on the exception type we put different content to the error body
		 * 3: construct the standard response format with the  error content body
		 *
		 * we have the following fields for the error body
		 * 1: statusCode
		 * 2: trance
		 * 3: message
		 * 4: code
		 * 5: uuid
		 * 6: date
		 * 7: type
		 * 8: url
		 */

		//default value for the fields
		$statusCode = 500;
//          $trace = $exception->getTrace();
		//          $code = $exception->getCode();
		$message = $exception->getMessage();
		$uuid = (string) Str::uuid();
		$date = Carbon::now()->format(env('DATE_TIME_FORMAT', "Y-m-d\TH:i:sP"));
		$type = 'API';
		$url = $request->fullUrl();

		//this is for 422
		if ($exception instanceof \Illuminate\Http\Exceptions\HttpResponseException) {
			$statusCode = 422;
		}
		//this is for 401
		if ($exception instanceof \Illuminate\Auth\AuthenticationException) {
			$statusCode = 401;
		}

		//this is for 403
		if ($exception instanceof ForbiddenException) {
			$statusCode = 403;
		}

		//this is for 422
		if ($exception instanceof \Illuminate\Validation\ValidationException) {
			$statusCode = 422;
		}

		$responseErrorBody = [];

		if (config('app.debug')) {
			$responseErrorBody['trace'] = $exception->getTrace();
			$responseErrorBody['code'] = $exception->getCode();
		}
		$responseErrorBody['statusCode'] = $statusCode;

		$responseErrorBody['message'] = $message;
		$responseErrorBody['uuid'] = $uuid;
		$responseErrorBody['date'] = $date;
		$responseErrorBody['type'] = $type;
		$responseErrorBody['url'] = $url;

		$responseBody = array(
			"metadata" => new \stdClass(),
			"data" => array(),
			"error" => $responseErrorBody,
		);

		return response()->json($responseBody, $statusCode);
	}
}
