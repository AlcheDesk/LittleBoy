<?php

namespace App\help;

use Anhskohbo\NoCaptcha\Facades\NoCaptcha as noCaptchaFacade;

class NoCaptcha extends noCaptchaFacade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'nocaptcha';
    }
}
