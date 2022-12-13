<?php

namespace  App\Helpers;

use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;

class CommonUtils
{
    public static function getSetting($name)
    {
        $setting = DB::table('portal_settings')->where('name', $name)->first();
        if (!empty($setting)) {
            return ($setting->isEncrypt == 1) ? Crypt::decryptString($setting->val) : $setting->val;
        }
        return "";
    }
}
