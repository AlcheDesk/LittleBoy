<?php
/**
 * Created by PhpStorm.
 * User: scott.fu
 * Date: 2018/1/29
 * Time: 21:06
 */
namespace App\Http\Controllers;

use Illuminate\Http\Request;

interface MLNoDeleteModelController
{

    public function insert(Request $request);

    public function select_by_condition(Request $request);

    public function select_by_id(Request $request, $id);

    public function update(Request $request);

    public function replace(Request $request);
}