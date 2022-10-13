<?php

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('status', [UsuarioController::class, 'cambiarEstado'])->name('status');

// Route::post('posts', 'usuarioController@index');
// Route::group(['prefix' => 'post'], function () {
//     Route::post('add', 'PostController@add');
//     Route::get('edit/{id}', 'PostController@edit');
//     Route::post('update/{id}', 'PostController@update');
//     Route::delete('delete/{id}', 'PostController@delete');
// });

// Route::group(['middleware' => ['auth']], function () {
//     Route::resource('roles', RolController::class);
//     Route::resource('usuarios', UsuarioController::class);
//     Route::resource('blogs', BlogController::class);
// });