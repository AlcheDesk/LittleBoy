<?php

namespace App\Http\Controllers\Util;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Tremby\LaravelGitVersion\GitVersionHelper;

class InfoController extends Controller
{   
    public function getGitVersion(Request $request)
    {
        $gitVersion = GitVersionHelper::getVersion();
        $responseContent = array("gitVersion"=>$gitVersion);
        Log::debug('Controller layer ' . __CLASS__ . ' ' . __FUNCTION__ . ' return ' . var_export($responseContent, true));
        return response($responseContent, 200)->header('Content-Type', 'application/json; charset=utf8');
    }

}