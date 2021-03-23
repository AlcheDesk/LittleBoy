<?php
/**
 * Created by PhpStorm.
 * User: scott
 * Date: 1/24/2018
 * Time: 12:55 AM
 */
namespace App\Http\Controllers;

use Illuminate\Http\Request;

interface MLModelController
{

    public function delete_by_condition(Request $request);

    public function delete_by_id(Request $request, $id);

    public function insert(Request $request);

    public function select_by_condition(Request $request);

    public function select_by_id(Request $request, $id);

    public function update(Request $request);

    public function replace(Request $request);
}