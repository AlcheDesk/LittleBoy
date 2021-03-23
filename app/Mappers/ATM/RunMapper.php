<?php
/**
 * Created by PhpStorm.
 * User: scott.fu
 * Date: 2018/1/30
 * Time: 12:02
 */
namespace App\Mappers\ATM;

use App\Mappers\BaseMapper;
use GuzzleHttp\Psr7\Request;
use Illuminate\Support\Facades\Log;

class RunMapper extends ATMBaseMapper implements BaseMapper {

	public function countByOptions(array $options = [], $concurrentRequest = false): string{
		$options[] = 'count';
		// generate the url
		$url = $this->generateUrl("/api/runs", $this->build_query($options));
		// return as request
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

	public function deleteByOptions(array $options = [], $concurrentRequest = false): string{
		// generate the url
		$url = $this->generateUrl("/api/runs", $this->build_query($options));
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

	public function deleteById($id, $concurrentRequest = false): string{
		// generate the url
		$url = $this->generateUrl("/api/runs/" . $id);
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

	public function insert(string $jsonStringBody, $concurrentRequest = false): string{
		// generate the url
		$url = $this->generateUrl("/api/runs");

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
			$responseArray = json_decode($response->getBody(), true);
			Log::error('Unsuccessful response from ATM ' . __CLASS__ . ' ' . __FUNCTION__ . ' with http status: ' . $response->getStatusCode() . ' and Error message: ' . $responseArray['error']);
			return $response->getBody(); // return $responseArray;
		}
	}

	public function selectByOptions(array $options = [], $concurrentRequest = false): string{
		// generate the url
		$url = $this->generateUrl("/api/runs/", $this->build_query($options));
		// return as request
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

	public function selectById(array $options = [], $id, $concurrentRequest = false): string{
		// generate the url
		$url = $this->generateUrl("/api/runs/" . $id, $this->build_query($options));
		// return as request
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

	public function update(string $jsonStringBody, $concurrentRequest = false): string{
		// generate the url
		$url = $this->generateUrl("/api/runs");

		if ($concurrentRequest) {
			return new Request('PATCH', $url, $this->headers, $jsonStringBody);
		}
		// sent to the data source server
		$response = $this->client()->patch($url, [
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

	public function replace(string $jsonStringBody, $concurrentRequest = false): string{
		// generate the url
		$url = $this->generateUrl("/api/runs");

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

	// ===== run instructionResult link start =====
	public function deleteInstructionResultFromRun(array $options = [], $runId, $concurrentRequest = false): string{
		// generate the link url
		$url = $this->generateUrl("/api/runs/" . $runId . "/instructionResults", $this->build_query($options));
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

	public function unlinkInstructionResultFromRun(array $options = [], $runId, $concurrentRequest = false): string{
		// generate the url
		$url = $this->generateUrl("/api/runs/" . $runId . "/instructionResults", $this->build_query($options));
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

	public function insertInstructionResultAndLinkToRun(string $jsonStringBody, $runId, $concurrentRequest = false): string{
		// generate the url
		$url = $this->generateUrl("/api/runs/" . $runId . "/instructionResults");

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
			$responseArray = json_decode($response->getBody(), true);
			Log::error('Unsuccessful response from ATM ' . __CLASS__ . ' ' . __FUNCTION__ . ' with http status: ' . $response->getStatusCode() . ' and Error message: ' . $responseArray['error']);
			return $response->getBody(); // return $responseArray;
		}
	}

	public function getInstructionResultByRunId(array $options = [], $runId, $concurrentRequest = false): string{
		// generate the url
		$url = $this->generateUrl("/api/runs/" . $runId . "/instructionResults", $this->build_query($options));
		// return as request
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

	public function updateInstructionResultFromRun(string $jsonStringBody, $runId, $concurrentRequest = false): string{
		// generate the url
		$url = $this->generateUrl("/api/runs/" . $runId . "/instructionResults");

		if ($concurrentRequest) {
			return new Request('PATCH', $url, $this->headers, $jsonStringBody);
		}
		// sent to the data source server
		$response = $this->client()->patch($url, [
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

	public function replaceOrInsertInstructionResultByRun(string $jsonStringBody, $runId, $concurrentRequest = false): string{
		// generate the url
		$url = $this->generateUrl("/api/runs/" . $runId . "/instructionResults");

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

	public function linkInstructionResultToRun(string $jsonStringBody, $runId, $concurrentRequest = false): string{
		// generate the url
		$url = $this->generateUrl("/api/runs/" . $runId . "/instructionResults");
		if ($concurrentRequest) {
			return new Request('PUT', $url, $this->headers, $jsonStringBody);
		}
		// sent to the data source server
		$response = $this->client()->put($url);
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

	// =====run instructionResult link end =====

	// ===== run executionLog link start =====
	public function deleteExecutionLogFromRun(array $options = [], $runId, $concurrentRequest = false): string{
		// generate the link url
		$url = $this->generateUrl("/api/runs/" . $runId . "/executionLogs", $this->build_query($options));
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

	public function insertExecutionLogAndLinkToRun(string $jsonStringBody, $runId, $concurrentRequest = false): string{
		// generate the url
		$url = $this->generateUrl("/api/runs/" . $runId . "/executionLogs");

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
			$responseArray = json_decode($response->getBody(), true);
			Log::error('Unsuccessful response from ATM ' . __CLASS__ . ' ' . __FUNCTION__ . ' with http status: ' . $response->getStatusCode() . ' and Error message: ' . $responseArray['error']);
			return $response->getBody(); // return $responseArray;
		}
	}

	public function getExecutionLogByRunId(array $options = [], $runId, $concurrentRequest = false): string{
		// generate the url
		$url = $this->generateUrl("/api/runs/" . $runId . "/executionLogs", $this->build_query($options));
		// return as request
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

	public function updateExecutionLogFromRun(string $jsonStringBody, $runId, $concurrentRequest = false): string{
		// generate the url
		$url = $this->generateUrl("/api/runs/" . $runId . "/executionLogs");

		if ($concurrentRequest) {
			return new Request('PATCH', $url, $this->headers, $jsonStringBody);
		}
		// sent to the data source server
		$response = $this->client()->patch($url, [
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

	public function replaceOrInsertExecutionLogByRun(string $jsonStringBody, $runId, $concurrentRequest = false): string{
		// generate the url
		$url = $this->generateUrl("/api/runs/" . $runId . "/executionLogs");

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
	// =====run executionLog link end =====

	public function getTaskByRunId(array $options = [], $runId, $concurrentRequest = false): string{
		// generate the url
		$url = $this->generateUrl("/api/runs/" . $runId . "/tasks", $this->build_query($options));
		// return as request
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

	public function selectExecutionInfoById(array $options = [], $id, $concurrentRequest = false): string{
		// generate the url
		$url = $this->generateUrl("/api/runExecutionInfo/" . $id, $this->build_query($options));
		// return as request
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
}
