<?php
namespace App\Services\RBAC;

use App\Mappers\RBAC\UserManagementMapper;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class UserManagementService {

	private $mapper;

	public function __construct() {
		$this->mapper = new UserManagementMapper();
	}
	public function selectByConditionRequest(Request $request): string{
		// get the Model objects from mapper layer
		$id = $request->query('id');
		$users = User::findOrFail($id);
		$userUuid = $users->uuid;
		$query = $request->getQueryString() . '&' . 'userUuid=' . $userUuid;
		$jsonStringResponse = $this->mapper->selectByOptions($this->mapper->parse_query($query));
		Log::debug('Service layer ' . __CLASS__ . ' ' . __FUNCTION__ . ' return ' . var_export($jsonStringResponse, true));
		return $jsonStringResponse;
	}
}
