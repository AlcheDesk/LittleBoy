<?php
/**
 * Created by PhpStorm.
 * User: scott
 * Date: 1/24/2018
 * Time: 12:55 AM
 */
namespace App\Services;

use Illuminate\Http\Request;

interface UuidService {

	public function deleteByConditionRequest(Request $request): string;

	public function deleteByUuidRequest(Request $request, $uuid): string;

	public function insertRequest(Request $request): string;

	public function selectByConditionRequest(Request $request): string;

	public function selectByUuidRequest(Request $request, $uuid): string;

	public function updateRequest(Request $request): string;

	public function replaceRequest(Request $request): string;
}
