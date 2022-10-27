<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ConsultarAfiliadoController;
use App\Http\Controllers\HomeController;
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

Route::controller(ConsultarAfiliadoController::class)->group(function () {
    Route::post('facturas/total', 'TotalAmount')->name('total');
    Route::post('invoiceLines', 'getInvoiceLines')->name('invoice.lines');
    Route::post('facturas/pagadas', 'customers')->name('falturas.pagadas');
    Route::post('suppliernumber', 'getSupplierNumber')->name('supplier.number');
    Route::post('consultaOTM/afiliado', 'consultaOTM')->name('afiliado.consulta');
});






// Route::post('profile/userAsociado', [UsuarioAsociadoController::class, 'create'])->name('userAsociado.create');

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('status', [UsuarioController::class, 'cambiarEstado'])->name('status');


Route::post('/auth/register', [AuthController::class, 'register']);

Route::post('/auth/login', [AuthController::class, 'login']);

Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::get('/me', function (Request $request) {
        return auth()->user();
    });

    Route::middleware('auth:sanctum')->post('suppliers', [ConsultarAfiliadoController::class, 'suppliers']);
    // Route::middleware('auth:sanctum')->get('customers', [ConsultarAfiliadoController::class, 'customers']);

    Route::post('/auth/logout', [AuthController::class, 'logout']);
});


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
