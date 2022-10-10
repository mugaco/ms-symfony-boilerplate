<?php

use App\Helpers\Response as MiRes;


if (!function_exists('response')) {
    function response()
    {
        return new MiRes;
    }
}

