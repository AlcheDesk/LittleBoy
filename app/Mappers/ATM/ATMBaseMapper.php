<?php
/**
 * Created by PhpStorm.
 * User: scott.fu
 * Date: 2018/1/30
 * Time: 17:27
 */
namespace App\Mappers\ATM;

use App\Http\Controllers\Auth\Accounts\LoginRecordController;
use App\User;
use Firebase\JWT\JWT;
use GuzzleHttp\Client;
use function GuzzleHttp\json_encode;
use GuzzleHttp\Psr7\Response;
use function GuzzleHttp\Psr7\build_query;
use function GuzzleHttp\Psr7\parse_query;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Request;

class ATMBaseMapper {

	protected $baseUrl;
	protected $headers = [];

	// protected $serializer;
	function __construct() {
		// setup baseUrl and client
		if (Config::get('meowlomo.atm_port') == null) {
			$this->baseUrl = Config::get('meowlomo.atm_protocol') . ":" . Config::get('meowlomo.atm_host');
		} else {
			$this->baseUrl = Config::get('meowlomo.atm_protocol') . "://" . Config::get('meowlomo.atm_host') . ":" . Config::get('meowlomo.atm_port');
		}
	}

	public function client() {
		if(env('DISABLE_AUTH')){
			$this->headers = [
				'Accept' => 'application/json; charset=utf-8;',
				'Content-Type' => 'application/json; charset=utf-8',
			];
			return new Client([
				'headers' => $this->headers,
			]);
		}
		$key = Config::get('meowlomo.jwt_key');
		$time = time();
		$this->user = Auth::user();
		$accountUuids = User::find(Auth::id())->accountUUIDs();

		// if(strcmp(env('CLOUD_CONFIG'),'public')==0){

  //           $tenantInfo = new LoginRecordController();
  //           $tenant_id = $tenantInfo->get_tenant_id($this->user);

  //           $tenantId = $tenant_id;
		// } else{
		// 	if (strcmp($this->user->name,'meowlomo')==0){
  //               $tenantId = 1;
  //           } else{
  //               $tenantId = 1000;
  //           }
		// }
		$tenantId = $this->generateTenantId();

		Log::info(print_r($accountUuids, true));
		$token = array(
			"iat" => $time,
			"exp" => $time + Config::get('meowlomo.jwt_exp'),
			"aud" => Config::get('meowlomo.jwt_aud'),
			"sub" => json_encode([
				"username" => $this->user->name,
				"email" => $this->user->email,
				"uuid" => $this->user->uuid,
				"ipAddress" => Request::ip(),
				"accountUuids" => array_values($accountUuids),
				"tenantId" => $tenantId
				]),
		);
		Log::info(print_r($token, true));
		$jwt = JWT::encode($token, $key, Config::get('meowlomo.jwt_encryption_type'));
		Log::info("===jwt====".$jwt);
		$this->headers = [
			'Accept' => 'application/json; charset=utf-8;',
			'Content-Type' => 'application/json; charset=utf-8',
			Config::get('meowlomo.jwt_header_key') => Config::get('meowlomo.jwt_header_prefix') . " " . $jwt,
		];
		return new Client([
			'headers' => $this->headers,
		]);
	}

	public function generateTenantId() {
		$this->user = Auth::user();
		if(strcmp(env('CLOUD_CONFIG'),'public')==0){

            $tenantInfo = new LoginRecordController();
            $tenant_id = $tenantInfo->get_tenant_id($this->user);

            $tenantId = $tenant_id;
		} else{
			if (strcmp($this->user->name,'meowlomo')==0){
                $tenantId = 1;
            } else{
                $tenantId = 1000;
            }
		}
		return $tenantId;
	}

	public function generateUrl(string $customUrl, $query = null) {
		if ($query == null || $query == '') {
			return $this->baseUrl . $customUrl;
		} else {
			return $this->baseUrl . $customUrl . '?' . $query;
		}
	}

	public static function build_query(array $options = []): string {
		// page size
	    if (!isset($options['pageSize']) && isset($options['pageNumber'])) {
			$options['pageSize'] = Config::get('meowlomo.page_size', 25);

		}
		if (isset($options['pageSize']) && !isset($options['pageNumber']) && strcasecmp($options['pageSize'], 'all') !== 0 ) {
		    foreach (array_keys($options, 'pageSize') as $key) {
		        unset($options[$key]);
		    }
		}
		// mode
		if (!isset($options['mode'])) {
			$options['mode'] = 'PRODUCTION';
		}
		// convert to query string
		return build_query($options);
	}

	public static function parse_query($queryString): array
	{
		if ($queryString == null) {
			$queryString = '';
		}
		return parse_query($queryString);
	}

	public function getMeowlomoReponse(Response $response) {
		// check status return
		if ($response->getStatusCode() >= 200 && $response->getStatusCode() < 300) {
			$jsonStringBodyData = json_decode($response->getBody(), true);
			return $jsonStringBodyData;
		} else {
			return $response->getBody();
		}
	}

	public function serialize($objectArray) {
		return json_encode($objectArray, JSON_UNESCAPED_UNICODE);
	}

	public function deserialize(Response $response) {
		return json_decode($response->getBody(), JSON_UNESCAPED_UNICODE);
	}
}
