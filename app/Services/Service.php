<?php
namespace App\Services;

use Illuminate\Http\Request;

interface Service
{

    public function deleteByCondition(Request $request) : string;

    public function deleteById(Request $request, $id) : string;

    public function insert(Request $request) : string;

    public function selectByCondition(Request $request) : string;

    public function selectById(Request $request, $id) : string;

    public function update(Request $request) : string;

    public function replace(Request $request) : string;
}
