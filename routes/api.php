<?php

use App\Http\Controllers\ConsultarAfiliadoController;
use App\Http\Controllers\UsuarioAsociadoController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('consultaOTM/afiliado', [ConsultarAfiliadoController::class, 'consultaOTM'])->name('afiliado.consulta');
Route::post('profile/userAsociado', [UsuarioAsociadoController::class, 'create'])->name('userAsociado.create');

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
