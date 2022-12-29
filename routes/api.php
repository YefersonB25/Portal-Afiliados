<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ConsultarAfiliadoController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\RolController;
use App\Http\Controllers\UsuarioAsociadoController;
use App\Http\Controllers\UsuarioController;
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


/**
 * Healthcheck
 *
 * Check that the service is up. If everything is okay, you'll get a 200 OK response.
 *
 * Otherwise, the request will fail with a 400 error, and a response listing the failed services.
 *
 * @response 400 scenario="Service is unhealthy" {"status": "down", "services": {"database": "up", "redis": "down"}}
 * @responseField status The status of this API (`up` or `down`).
 * @responseField services Map of each downstream service and their status (`up` or `down`).
 */

// Route::post('status', [UsuarioController::class, 'cambiarEstado'])->name('status');

//!Comente las "auth:sanctum" ya que las api las estas usando en la vista y genera problemas de autenticacion, revisar!

// Route::middleware(['auth:sanctum', 'abilities:check-status,place-orders'])->controller(ConsultarAfiliadoController::class)->group(function () {
Route::controller(ConsultarAfiliadoController::class)->group(function () {
    Route::post('facturas/total', 'TotalAmount')->name('total');
    Route::post('invoiceLines', 'getInvoiceLines')->name('invoice.lines');
    Route::post('facturas/pagadas', 'customers')->name('falturas.pagadas');
    Route::post('facturas/transporte', 'getShipmentOtm')->name('falturas.transporte');
    Route::post('facturas/transporte/detalle', 'getShipmentDetalle')->name('falturas.transporte.detalle');
    Route::post('suppliernumber', 'getSupplierNumber')->name('supplier.number');
    Route::get('SelectSuppliernumber', 'SelectSupplierNumber')->name('selectSupplier.number');
    Route::post('consultaOTM/afiliado', 'consultaOTM')->name('afiliado.consulta');
    Route::post('proveedor', 'proveedorEncargado')->name('proveedor.encargado');
});

// Route::middleware(['auth:sanctum', 'abilities:check-status,place-orders'])->controller(UsuarioController::class)->group( function () {
Route::controller(UsuarioController::class)->group(function () {
    Route::delete('user/deleted', 'destroy')->name('usuario.eliminar');
});

// Route::middleware(['auth:sanctum', 'abilities:check-status,place-orders'])->controller(RolController::class)->group( function () {
Route::controller(RolController::class)->group(function () {
    Route::delete('rol/deleted', 'destroy')->name('roles.eliminar');
});

Route::post('/auth/register', [AuthController::class, 'register']);

Route::post('/auth/login', [AuthController::class, 'login']);

// Route::group(['middleware' => ['auth:sanctum']], function () {
// Route::group(['middleware' => ['auth:sanctum']], function () {
Route::post('suppliers', [ConsultarAfiliadoController::class, 'suppliers']);
// Route::middleware(['auth:sanctum', 'abilities:check-status,place-orders'])->post('suppliers', [ConsultarAfiliadoController::class, 'suppliers']);
// Route::middleware(['auth:sanctum', 'abilities:check-status,place-orders'])->put('/user/updated', [AuthController::class, 'update']);
Route::put('/user/updated', [AuthController::class, 'update']);
Route::post('/auth/logout', [AuthController::class, 'logout']);
// });
