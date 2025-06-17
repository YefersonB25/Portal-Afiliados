<?php

namespace App\Http\Helpers;

use Carbon\Carbon;
use DateTime;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class GetClientIp
{

    /* public static function getUserIpAddress()
    {
        if (!empty($_SERVER['HTTP_CLIENT_IP']))
            return $_SERVER['HTTP_CLIENT_IP'];

        if (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))
            return $_SERVER['HTTP_X_FORWARDED_FOR'];

        return $_SERVER['REMOTE_ADDR'];
    } */

    public static function getUserIpAddress()
    {
        $ip = request()->header('X-Forwarded-For') ?? request()->ip();

        // En caso de múltiples IPs en X-Forwarded-For
        if (strpos($ip, ',') !== false) {
            $ip = explode(',', $ip)[0];
        }

        return trim($ip);
    }

}
