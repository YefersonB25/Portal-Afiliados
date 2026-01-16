<?php

namespace App\Http\Helpers;

use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;

class CommonUtils
{
    public static function getSetting($name)
    {
        $setting = DB::table('portal_settings')->where('name', $name)->first();
        if (!empty($setting)) {
            $value = $setting->val;
            if ($setting->isEncrypt == 1) {
                return Crypt::decryptString($value);
            }

            if (is_string($value) && $value !== '') {
                try {
                    return Crypt::decryptString($value);
                } catch (\Throwable $th) {
                    return $value;
                }
            }

            return $value;
        }
        return "";
    }
}
