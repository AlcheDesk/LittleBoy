<?php
/**
 * User: tryndamere.wang
 * Date: 2018/12/20
 * Time: 10:39
 */
namespace App\Mappers\ATM;

use GuzzleHttp\Psr7\Request;
use Illuminate\Support\Facades\Log;

class ResultReportMapper extends ATMBaseMapper {

	public function getResultReportProject(array $options = [], $concurrentRequest = false): string{
		$options[] = 'count';
		// generate the url
		$url = $this->generateUrl("/api/resultReports/projects", $this->build_query($options));
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

	public function getResultReportProjectById(array $options = [], $id, $concurrentRequest = false): string{
		$options[] = 'count';
		// generate the url
		$url = $this->generateUrl("/api/resultReports/projects/" . $id, $this->build_query($options));
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

	public function getResultReportChartByProjectId(array $options = [], $id, $concurrentRequest = false): string{
		$options[] = 'count';
		// generate the url
		$url = $this->generateUrl("/api/projectReportInfo/" . $id . "?ref", $this->build_query($options));
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

	public function getResultReportTestCaseByProjectId(array $options = [], $id, $concurrentRequest = false): string{
		$options[] = 'count';
		// generate the url
		$url = $this->generateUrl("/api/resultReports/projects/" . $id . "/testCaseExecutionInfo", $this->build_query($options));
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

// duplicate routes here, we use these routes in RunSetResultService.php instead

	// public function getRunListReports(array $options = [], $concurrentRequest = false): string
	// {
	//     $options[] = 'count';
	//     // generate the url
	//     $url = $this->generateUrl("/api/runSetResults", $this->build_query($options));
	//     // return as request
	//     if ($concurrentRequest) {
	//         return new Request('GET', $url);
	//     }
	//     // sent to the data source server
	//     $response = $this->client()->get($url);
	//     // check the response
	//     if ($response->getStatusCode() >= 200 && $response->getStatusCode() < 300) {
	//         // return the meowlomo response as array
	//         return $response->getBody();
	//     } else {
	//         $responseArray = json_decode($response->getBody(), true);
	//         Log::error('Unsuccessful response from ATM ' . __CLASS__ . ' ' . __FUNCTION__ . ' with http status: ' . $response->getStatusCode() . ' and Error message: ' . $responseArray['error']);
	//         return $response->getBody(); // return $responseArray;
	//     }
	// }

	// public function getRunListReportById(array $options = [], $id, $concurrentRequest = false): string
	// {
	//     $options[] = 'count';
	//     // generate the url
	//     $url = $this->generateUrl("/api/runSetResults/" . $id, $this->build_query($options));
	//     // return as request
	//     if ($concurrentRequest) {
	//         return new Request('GET', $url);
	//     }
	//     // sent to the data source server
	//     $response = $this->client()->get($url);
	//     // check the response
	//     if ($response->getStatusCode() >= 200 && $response->getStatusCode() < 300) {
	//         // return the meowlomo response as array
	//         return $response->getBody();
	//     } else {
	//         $responseArray = json_decode($response->getBody(), true);
	//         Log::error('Unsuccessful response from ATM ' . __CLASS__ . ' ' . __FUNCTION__ . ' with http status: ' . $response->getStatusCode() . ' and Error message: ' . $responseArray['error']);
	//         return $response->getBody(); // return $responseArray;
	//     }
	// }

// duplicate routes end

	public function getResultReportRunByRunSetResultId(array $options = [], $id, $concurrentRequest = false): string{
		$options[] = 'count';
		// generate the url
		$url = $this->generateUrl("/api/resultReports/runSetResults/" . $id . "/runs", $this->build_query($options));
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

	public function getResultReportTestCase(array $options = [], $concurrentRequest = false): string{
		$options[] = 'count';
		// generate the url
		$url = $this->generateUrl("/api/resultReports/testCases", $this->build_query($options));
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

	public function getResultReportTestCaseById(array $options = [], $id, $concurrentRequest = false): string{
		$options[] = 'count';
		// generate the url
		// $url = $this->generateUrl("/api/resultReports/testCases/" . $id, $this->build_query($options));
		$url = $this->generateUrl("/api/testCaseExecutionInfo/" . $id, $this->build_query($options));

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

	public function getResultReportRunByTestCaseId(array $options = [], $id, $concurrentRequest = false): string{
		$options[] = 'count';
		// generate the url
		$url = $this->generateUrl("/api/resultReports/testCases/" . $id . "/runs", $this->build_query($options));
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

	public function getResultReportRunById(array $options = [], $id, $concurrentRequest = false): string{
		$options[] = 'count';
		// generate the url
		$url = $this->generateUrl("/api/resultReports/runs/" . $id, $this->build_query($options));
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

	public function getResultReportInstructionResultByRunId(array $options = [], $id, $concurrentRequest = false): string{
		$options[] = 'count';
		// generate the url
		$url = $this->generateUrl("/api/resultReports/runs/" . $id . "/instructionResults", $this->build_query($options));
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

	public function getResultReportStepLogByInstructionResultId(array $options = [], $id, $concurrentRequest = false): string{
		$options[] = 'count';
		// generate the url
		$url = $this->generateUrl("/api/resultReports/instructionResults/" . $id . "/stepLogs", $this->build_query($options));
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
