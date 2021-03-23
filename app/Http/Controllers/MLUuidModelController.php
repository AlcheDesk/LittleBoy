<?php
/**
 * Created by PhpStorm.
 * User: scott
 * Date: 1/24/2018
 * Time: 12:55 AM
 */
namespace App\Http\Controllers;

use Illuminate\Http\Request;

interface MLUuidModelController
{

    public function delete_by_condition(Request $request);

    public function delete_by_uuid(Request $request, $uuid);

    public function insert(Request $request);

    public function select_by_condition(Request $request);

    public function select_by_uuid(Request $request, $uuid);

    public function update(Request $request);

    public function replace(Request $request);
}