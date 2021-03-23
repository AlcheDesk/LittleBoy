<?php
namespace App\Mappers\ATM;

use GuzzleHttp\Psr7\Request;
use Illuminate\Support\Facades\Log;

class FolderMapper extends ATMBaseMapper {

	public function deleteByOptions(array $options = [], $concurrentRequest = false): string{
		// generate the url
		$url = $this->generateUrl("/api/testCaseShareFolders", $this->build_query($options));
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
		$url = $this->generateUrl("/api/testCaseShareFolders/" . $id);
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
		$url = $this->generateUrl("/api/testCaseShareFolders");

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
		$url = $this->generateUrl("/api/testCaseShareFolders/", $this->build_query($options));
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
		$url = $this->generateUrl("/api/testCaseShareFolders/" . $id, $this->build_query($options));
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
		$url = $this->generateUrl("/api/testCaseShareFolders");

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
		$url = $this->generateUrl("/api/testCaseShareFolders");

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

	// =====folder application link end =====

	// ===== folder testCase link start =====
	public function deleteTestCaseFromFolder(array $options = [], $id, $concurrentRequest = false): string{
		// generate the link url
		$url = $this->generateUrl("/api/testCaseShareFolderTestCaseLinks/" . $id, $this->build_query($options));
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

	public function insertTestCaseAndLinkToFolder(string $jsonStringBody, $folderId, $concurrentRequest = false): string{
		// generate the url
		$url = $this->generateUrl("/api/testCaseShareFolders/" . $folderId . "/testCases");

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

	public function getTestCaseByFolderId(array $options = [], $folderId, $concurrentRequest = false): string{
		// generate the url
		$url = $this->generateUrl("/api/testCaseShareFolders/" . $folderId . "/testCaseShareFolderTestCaseLinks", $this->build_query($options));
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

	public function replaceOrInsertTestCaseByFolder(string $jsonStringBody, $concurrentRequest = false): string{
		// generate the url
		$url = $this->generateUrl("/api/testCaseShareFolderTestCaseLinks/");

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

}
