<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ErrorController extends Controller
{
    public function error404 (){
        return response()->view('error_pages.404Error', [], 404);
    }
}
