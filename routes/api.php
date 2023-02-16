<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ConsultarAfiliadoController;
use App\Http\Controllers\RolController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\WebserviceOtmController;
use Illuminate\Support\Facades\Request;
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

Route::prefix('invoice')->controller(AuthController::class)->middleware(['auth:sanctum', 'ability:check-status,place-orders'])->group(function () {
    Route::get('/afiliate-supplier', 'invoiceSuppliers');
    Route::get('/transportation', 'getShipmentOtm');
    Route::get('/transportation/details', 'getShipmentDetalle');
    Route::get('/lines', 'getInvoiceLines');
});

Route::prefix('amount')->controller(AuthController::class)->middleware(['auth:sanctum', 'ability:check-status,place-orders'])->group(function () {
    Route::get('/invoice/worth', 'TotalAmount');
});

Route::get('suppliers', [AuthController::class, 'supplierNumber']);

Route::prefix('users')->controller(AuthController::class)->middleware(['auth:sanctum', 'ability:check-status,place-orders'])->group(function () {
    Route::get('/validation/otm/erp', 'consultaOTM');
    Route::get('/dad', 'proveedorEncargado');
    Route::get('/edit', 'edit');
    Route::put('/updated', 'update');
    Route::get('/profile', 'profile');
});

Route::prefix('permission')->controller(AuthController::class)->middleware(['auth:sanctum', 'ability:check-status,place-orders'])->group(function () {
    Route::get('/', 'permission');
});

Route::prefix('role')->controller(AuthController::class)->middleware(['auth:sanctum', 'ability:check-status,place-orders'])->group(function () {
    Route::get('/', 'role');
    Route::get('/create', 'createRole');
    Route::get('/edit', 'editRole');
    Route::get('/updated', 'updateRole');
});


Route::prefix('auth')->controller(AuthController::class)->group(function () {
    Route::post('/register', 'register');
    Route::post('/login', 'login');
    Route::post('/logout', 'logout');
});


// Prueba Api OrderReleases OTM
Route::post('webservice/orderReleases/create', [WebserviceOtmController::class, 'store'])
    ->middleware('auth.basic');



// Route::middleware(['auth:sanctum', 'abilities:check-status,place-orders'])->controller(RolController::class)->group( function () {
    // Route::controller(RolController::class)->group(function () {
    //     Route::delete('rol/deleted', 'destroy')->name('roles.eliminar');
    // });


// Route::group(['middleware' => ['auth:sanctum']], function () {
// Route::group(['middleware' => ['auth:sanctum']], function () {
// Route::middleware(['auth:sanctum', 'abilities:check-status,place-orders'])->post('suppliers', [ConsultarAfiliadoController::class, 'suppliers']);
// Route::middleware(['auth:sanctum', 'abilities:check-status,place-orders'])->put('/user/updated', [AuthController::class, 'update']);
// });
