<?php
/**
 * Created by PhpStorm.
 * User: scott.fu
 * Date: 2018/1/30
 * Time: 12:02
 */
namespace App\Mappers\ATM;

use GuzzleHttp\Psr7\Request;
use Illuminate\Support\Facades\Log;

class ProjectMapper extends ATMBaseMapper {

	public function countByOptions(array $options = [], $concurrentRequest = false): string{
		$options[] = 'count';
		// generate the url
		$url = $this->generateUrl("/api/projects", $this->build_query($options));
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
		$url = $this->generateUrl("/api/projects", $this->build_query($options));
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
		$url = $this->generateUrl("/api/projects/" . $id);
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
		$url = $this->generateUrl("/api/projects");

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
		$url = $this->generateUrl("/api/projects/", $this->build_query($options));
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
		$url = $this->generateUrl("/api/projects/" . $id, $this->build_query($options));
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
		$url = $this->generateUrl("/api/projects");

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
		$url = $this->generateUrl("/api/projects");

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

	// ===== project application link start =====
	public function deleteApplicationFromProject(array $options = [], $projectId, $concurrentRequest = false): string{
		// generate the link url
		$url = $this->generateUrl("/api/projects/" . $projectId . "/applications", $this->build_query($options));
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

	public function unlinkApplicationFromProject(array $options = [], $projectId, $concurrentRequest = false): string{
		// generate the url
		$url = $this->generateUrl("/api/projects/" . $projectId . "/applications", $this->build_query($options));
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

	public function insertApplicationAndLinkToProject(string $jsonStringBody, $projectId, $concurrentRequest = false): string{
		// generate the url
		$url = $this->generateUrl("/api/projects/" . $projectId . "/applications");

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

	public function getApplicationByProjectId(array $options = [], $projectId, $concurrentRequest = false): string{
		// generate the url
		$url = $this->generateUrl("/api/projects/" . $projectId . "/applications", $this->build_query($options));
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

	public function updateApplicationFromProject(string $jsonStringBody, $projectId, $concurrentRequest = false): string{
		// generate the url
		$url = $this->generateUrl("/api/projects/" . $projectId . "/applications");

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

	public function replaceOrInsertApplicationByProject(string $jsonStringBody, $projectId, $concurrentRequest = false): string{
		// generate the url
		$url = $this->generateUrl("/api/projects/" . $projectId . "/applications");

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

	public function linkApplicationToProject(string $jsonStringBody, $projectId, $concurrentRequest = false): string{
		// generate the url
		$url = $this->generateUrl("/api/projects/" . $projectId . "/applications");
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

	// =====project application link end =====

	// ===== project testCase link start =====
	public function deleteTestCaseFromProject(array $options = [], $projectId, $concurrentRequest = false): string{
		// generate the link url
		$url = $this->generateUrl("/api/projects/" . $projectId . "/testCases", $this->build_query($options));
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

	public function unlinkTestCaseFromProject(array $options = [], $projectId, $concurrentRequest = false): string{
		// generate the url
		$url = $this->generateUrl("/api/projects/" . $projectId . "/testCases", $this->build_query($options));
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

	public function insertTestCaseAndLinkToProject(string $jsonStringBody, $projectId, $concurrentRequest = false): string{
		// generate the url
		$url = $this->generateUrl("/api/projects/" . $projectId . "/testCases");

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

	public function getTestCaseByProjectId(array $options = [], $projectId, $concurrentRequest = false): string{
		// generate the url
		$url = $this->generateUrl("/api/projects/" . $projectId . "/testCases", $this->build_query($options));
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

	public function updateTestCaseFromProject(string $jsonStringBody, $projectId, $concurrentRequest = false): string{
		// generate the url
		$url = $this->generateUrl("/api/projects/" . $projectId . "/testCases");

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

	public function replaceOrInsertTestCaseByProject(string $jsonStringBody, $projectId, $concurrentRequest = false): string{
		// generate the url
		$url = $this->generateUrl("/api/projects/" . $projectId . "/testCases");

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

	public function linkTestCaseToProject(string $jsonStringBody, $projectId, $concurrentRequest = false): string{
		// generate the url
		$url = $this->generateUrl("/api/projects/" . $projectId . "/testCases");
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

	// =====project testCase link end =====

	// ===== project element link start =====
	public function deleteElementFromProject(array $options = [], $projectId, $concurrentRequest = false): string{
		// generate the link url
		$url = $this->generateUrl("/api/projects/" . $projectId . "/elements", $this->build_query($options));
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

	public function unlinkElementFromProject(array $options = [], $projectId, $concurrentRequest = false): string{
		// generate the url
		$url = $this->generateUrl("/api/projects/" . $projectId . "/elements", $this->build_query($options));
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

	public function insertElementAndLinkToProject(string $jsonStringBody, $projectId, $concurrentRequest = false): string{
		// generate the url
		$url = $this->generateUrl("/api/projects/" . $projectId . "/elements");

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

	public function getElementByProjectId(array $options = [], $projectId, $concurrentRequest = false): string{
		// generate the url
		$url = $this->generateUrl("/api/projects/" . $projectId . "/elements", $this->build_query($options));
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

	public function updateElementFromProject(string $jsonStringBody, $projectId, $concurrentRequest = false): string{
		// generate the url
		$url = $this->generateUrl("/api/projects/" . $projectId . "/elements");

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

	public function replaceOrInsertElementByProject(string $jsonStringBody, $projectId, $concurrentRequest = false): string{
		// generate the url
		$url = $this->generateUrl("/api/projects/" . $projectId . "/elements");

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

	public function linkElementToProject(string $jsonStringBody, $projectId, $concurrentRequest = false): string{
		// generate the url
		$url = $this->generateUrl("/api/projects/" . $projectId . "/elements");
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

	// =====project element link end =====
}
