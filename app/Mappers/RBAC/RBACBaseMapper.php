<?php
/**
 * Created by PhpStorm.
 * User: scott.fu
 * Date: 2018/1/30
 * Time: 17:27
 */
namespace App\Mappers\RBAC;

use Firebase\JWT\JWT;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use function GuzzleHttp\Psr7\build_query;
use function GuzzleHttp\Psr7\parse_query;

class RBACBaseMapper {

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
		$key = Config::get('meowlomo.jwt_key');
		$time = time();
		$this->user = Auth::user();
		$token = array(
			"iat" => $time,
			"exp" => $time + Config::get('meowlomo.jwt_exp'),
			"aud" => Config::get('meowlomo.jwt_aud'),
			"sub" => json_encode([
				"username" => $this->user->name,
				"email" => $this->user->email,
				"uuid" => $this->user->uuid,
			], JSON_FORCE_OBJECT),
		);
		$jwt = JWT::encode($token, $key, Config::get('meowlomo.jwt_encryption_type'));
		$this->headers = [
			'Accept' => 'application/json; charset=utf-8;',
			'Content-Type' => 'application/json; charset=utf-8',
			Config::get('meowlomo.jwt_header_key') => Config::get('meowlomo.jwt_header_prefix') . " " . $jwt,
		];
		return new Client([
			'headers' => $this->headers,
		]);
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
		if (!isset($options['pageSize'])) {
			$options['pageSize'] = Config::get('meowlomo.page_size');
		}
		// mode
		if (!isset($options['mode'])) {
			$options['mode'] = 'PRODUCTION';
		}
		// if (!isset($options['ALL'])) {
		// $options['ALL'] = 'TRUE';
		// }

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
}
