<?php
/**
 * Created by PhpStorm.
 * User: tryndamere.wang
 * Date: 2018/12/18
 * Time: 15:19
 */
namespace App\Mappers\ATM;

use GuzzleHttp\Psr7\Request;
use Illuminate\Support\Facades\Log;

class ApiUnitCallMapper extends ATMBaseMapper {

	public function apiUnitCall(string $jsonStringBody, $concurrentRequest = false): string{
		// generate the url
		$url = $this->generateUrl("/api/apiUnitCalls");

		if ($concurrentRequest) {
			return new Request('POST', $url, $this->headers, $jsonStringBody);
		}
		// sent to the data source server
		$response = $this->client()->post($url, [
			'body' => $jsonStringBody,
		]);
		// check the response
		if ($response->getStatusCode() >= 200 && $response->getStatusCode() < 300) {
			// return the meowlomo response as array
			return $response->getBody();
		} else {
			$responseArray = json_decode($response->getBody(), false);
			Log::error('Unsuccessful response from ATM ' . __CLASS__ . ' ' . __FUNCTION__ . ' with http status: ' . $response->getStatusCode() . ' and Error message: ' . $responseArray['error']);
			return $response->getBody(); // return $responseArray;
		}
	}
}
