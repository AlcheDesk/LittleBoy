<?php
/**
 * User: tryndamere.wang
 * Date: 2018/12/20
 * Time: 10:39
 */
namespace App\Mappers\ATM;

use GuzzleHttp\Psr7\Request;
use Illuminate\Support\Facades\Log;

class AlarmSetMapper extends ATMBaseMapper {

	public function getAlarmSetByRunSetId($id, $concurrentRequest = false): string{
		// generate the url
		$url = $this->generateUrl("/api/scheduler/runSets/" . $id . "/triggers/");
		if ($concurrentRequest) {
			return new Request('GET', $url);
		}
		// sent to the data source server
		$response = $this->client()->get($url);
		// check the response
		if ($response->getStatusCode() >= 200 && $response->getStatusCode() < 300) {
			// return the meowlomo response as array
			return $response->getBody();
		} else {
			$responseArray = json_decode($response->getBody(), true);
			Log::error('Unsuccessful response from ATM ' . __CLASS__ . ' ' . __FUNCTION__ . ' with http status: ' . $response->getStatusCode() . ' and Error message: ' . $responseArray['error']);
			return $response->getBody(); // return $responseArray;
		}
	}

	public function addOrPatchAlarmSetByRunSetId(string $jsonStringBody, $id, $concurrentRequest = false): string{
		// generate the url
		$url = $this->generateUrl("/api/scheduler/runSets/" . $id . "/triggers/");

		if ($concurrentRequest) {
			return new Request('PUT', $url, $this->headers, $jsonStringBody);
		}
		// sent to the data source server
		$response = $this->client()->put($url, [
			'body' => $jsonStringBody,
		]);
		// check the response
		if ($response->getStatusCode() >= 200 && $response->getStatusCode() < 300) {
			// return the meowlomo response as array
			return $response->getBody();
		} else {
			$responseArray = json_decode($response->getBody(), true);
			Log::error('Unsuccessful response from ATM ' . __CLASS__ . ' ' . __FUNCTION__ . ' with http status: ' . $response->getStatusCode() . ' and Error message: ' . $responseArray['error']);
			return $response->getBody(); // return $responseArray;
		}
	}

	public function deleteAlarmSetByRunSetIdAndTriggerUUID($id, $uuid, $concurrentRequest = false): string{
		// generate the url
		$url = $this->generateUrl("/api/scheduler/runSets/" . $id . "/triggers/" . $uuid);
		if ($concurrentRequest) {
			return new Request('DELETE', $url);
		}
		// sent to the data source server
		$response = $this->client()->delete($url);
		// check the response
		if ($response->getStatusCode() >= 200 && $response->getStatusCode() < 300) {
			// return the meowlomo response as array
			return $response->getBody();
		} else {
			$responseArray = json_decode($response->getBody(), true);
			Log::error('Unsuccessful response from ATM ' . __CLASS__ . ' ' . __FUNCTION__ . ' with http status: ' . $response->getStatusCode() . ' and Error message: ' . $responseArray['error']);
			return $response->getBody(); // return $responseArray;
		}
	}
}
