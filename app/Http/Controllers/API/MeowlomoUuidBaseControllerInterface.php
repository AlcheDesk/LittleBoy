<?php
namespace App\Http\Controllers\API;

use Illuminate\Http\Request;

interface MeowlomoUuidBaseControllerInterface
{

    public function deleteByCondition(Request $request);

    public function deleteByUuid(Request $request, $uuid);

    public function insert(Request $request);

    public function selectByCondition(Request $request);

    public function selectByUuid(Request $request, $uuid);

    public function update(Request $request);

    public function replace(Request $request);
}