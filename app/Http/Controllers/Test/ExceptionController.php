<?php
namespace App\Http\Controllers\Test;

use App\Exceptions\ForbiddenException;
use Illuminate\Http\Request;

class ExceptionController
{

    public function forbidden(Request $request)
    {
        throw new ForbiddenException('this is the exception from the test controller.');
    }
}
