<?php
/**
 * Created by PhpStorm.
 * User: scott.fu
 * Date: 2018/1/24
 * Time: 10:52
 */

return [

	/*
	|--------------------------------------------------------------------------
	| ATM Configuration
	|--------------------------------------------------------------------------
	| Please put meowlomo ATM server information in this section.
	| the required fields are atm_protocol, atm_host, atm_port
	|
	 */

	'atm_protocol' => env('ATM_PROTOCOL', 'http'),
	'atm_host' => env('ATM_HOST', 'atm-app'),
	'atm_port' => env('ATM_PORT', '8080'),

	'ems_protocol' => env('EMS_PROTOCOL', 'http'),
	'ems_host' => env('EMS_HOST', 'ems-app'),
	'ems_port' => env('EMS_PORT', '8090'),

	'page_size' => env('PAGE_SIZE', '25'),

	'date_time_format' => env('DATE_TIME_FORMAT', 'Y-m-d\TH:i:sP'),

	'jwt_key' => env('JWT_KEY', "meowlomo_token"),
	'jwt_exp' => env('JWT_EXP', '7200'),
	'jwt_encryption_type' => env('JWT_ENCRYPTION_TYPE', 'HS512'),
	'jwt_aud' => env('JWT_AUD', 'meowlomo littleboy'),
	'jwt_header_key' => env('JWT_HEADER_KEY', 'Authorization'),
	'jwt_header_prefix' => env('JWT_HEADER_PREFIX', 'Bearer '),

    'hidden_instruction_keys' => env('HIDDEN_INSTRUCTION_KEY', 'email,rpc_dubbo,string_util')
];
