<?php
namespace App\Http\Controllers\API;

use Illuminate\Http\Request;

interface MeowlomoBaseControllerInterface
{

    public function deleteByCondition(Request $request);

    public function deleteById(Request $request, $id);

    public function insert(Request $request);

    public function selectByCondition(Request $request);

    public function selectById(Request $request, $id);

    public function update(Request $request);

    public function replace(Request $request);
}