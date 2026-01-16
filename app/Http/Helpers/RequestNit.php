<?php

namespace App\Http\Helpers;

use Illuminate\Support\Facades\Crypt;

class RequestNit
{
    public static function getNit($document)
    {
        $document = trim((string) $document);

        if ($document === '') {
            return $document;
        }

        if (str_contains($document, '-')) {
            return $document;
        }

        if (!is_numeric($document)) {
            return $document;
        }
        $arr = array(
            1 => 3, 4 => 17, 7 => 29, 10 => 43, 13 => 59, 2 => 7, 5 => 19,
            8 => 37, 11 => 47, 14 => 67, 3 => 13, 6 => 23, 9 => 41, 12 => 53, 15 => 71
        );
        $x = 0;
        $y = 0;
        $z = strlen($document);
        $dv = '';

        for ($i = 0; $i < $z; $i++) {
            $y = substr($document, $i, 1);
            $x += ($y * $arr[$z - $i]);
        }

        $y = $x % 11;

        if ($y > 1) {
            $dv = 11 - $y;
            $identificacion = $document . "-" . $dv;
        } else {
            $dv = $y;
            $identificacion = $document . "-" . $dv;
        }
        return $identificacion;
    }
}
