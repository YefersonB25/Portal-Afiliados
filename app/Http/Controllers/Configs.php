<?php
namespace App\Http\Controllers;
require('../vendor/autoload.php');

use App\Http\Helpers\CommonUtils;
use Illuminate\Http\Request;
use Dotenv\Dotenv;
use Dotenv\Exception\InvalidPathException;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;

class Configs extends Controller
{
    public function index () {
        $setting = DB::table('portal_settings')->get();
        return view('config.config', ['setting' => $setting]);

    }

    public function getDecryptedData (Request $request ) {
       $var =  CommonUtils::getSetting($request->name);
        return response()->json(['success' => true, 'data' => $var]);

    }

    public function update (Request $request) {

        if (!empty($request)) {
           $val = ($request->isEncrypt == 1) ? Crypt::encryptString($request->val) : $request->val;

            $result = DB::table('portal_settings')
                        ->where('name', $request->name)
                        ->update(['val' => $val]);

            return response()->json(['success' => true, 'data' => $result]);
        }


    }

}
