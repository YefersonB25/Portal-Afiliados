<?php

use Illuminate\Support\Facades\Route;
//agregamos los siguientes controladores
use App\Http\Controllers\RolController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Configs;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\FacturaController;
use App\Http\Controllers\ConsultarAfiliadoController;
use App\Http\Controllers\ErrorController;
use App\Http\Controllers\FormController;
use App\Http\Controllers\PasswordController;
use App\Http\Controllers\PerfilController;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('auth/login');
})->name('auth.login');

// Route::get('/{view?}', 'IndexController@index')
//     ->where('view', '(.*)')
//     ->name('log-viewer.index');

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home')->middleware('verified');

Auth::routes(['verify' => true]);

//? Usuarios-Clientes
Route::prefix('portal/users')->controller(UsuarioController::class)->middleware('auth')->group(function () {
    Route::get('/', 'index', 'can:/usuario.index')->name('usuario.index');
    Route::get('config/{id}', 'checkout')->name('check');
    route::get('edit/{id}', 'edit')->name('edit');
    Route::get('confirmar/{usuario}/{estado}', 'confirmarDatos')->name('usuario.estado');
    Route::post('userAsociado', 'createUserAsociado')->name('userAsociado.create');
    Route::post('/', 'filtros')->name('user.filtros');
    Route::delete('/deleted', 'destroy')->name('usuario.eliminar');
    Route::get('/confimacion', 'confirmarUser')->name('consultar.proveedorLocal');
    Route::post('/change-password', 'changePassword')->name('change-password.update');
    Route::get('/testinvoice', 'test')->name('consultar.invoicetest');
});
Route::resource('portal/usuarios', UsuarioController::class);

Route::get('forgot-password', [AuthController::class, 'email'])->name('forgot-password');

// Route::delete('/deleted', 'destroy')->name('usuario.eliminar');

//? Perfil - Usuarios Asociados
Route::prefix('profile')->controller(PerfilController::class)->middleware('auth')->group(function () {
    Route::get('/', 'index')->name('profile');
    Route::get('userAsociado/{id}', 'eliminarUserAsociado')->name('userAsociado.delete');
    Route::get('userAsociadoRestore/{id}', 'reasignarUserAsociado')->name('userAsociado.restore');
    Route::put('{id}', 'update')->name('profile.update');
    Route::post('/photoUpdate', 'photoUpdate')->name('photo-profile.updatePhoto');

});

//? Consulta OTM
Route::prefix('consultaOTM')->controller(ConsultarAfiliadoController::class)->middleware('auth')->group(function () {
    Route::get('/', 'index')->name('consultar');
    Route::get('afiliado/{id}', 'consultaOTM')->name('consultar.afiliado');
});

Route::controller(ConsultarAfiliadoController::class)->middleware('auth')->group(function () {
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

//? Consultar code
Route::prefix('customers')->controller(FacturaController::class)->middleware('auth')->group(function () {
    Route::get('{id}', 'index')->name('blogs.index');
});

Route::middleware('auth', 'can:/roles')->group(function () {
    Route::resource('portal/roles', RolController::class);

    Route::delete('portal/roles/deleted', [RolController::class, 'destroy'])->name('roles.eliminar');
});

Route::prefix('portal/setting')->controller(Configs::class)->middleware('auth')->group(function () {
    Route::get('/', 'index', 'can:/usuario.index')->name('setting');
    Route::post('/date', 'getDecryptedData', 'can:/usuario.index')->name('setting.date');
    Route::post('/', 'update', 'can:/usuario.index')->name('setting.update');
    Route::get('/create', 'create', 'can:/usuario.index')->name('setting.create');
    Route::post('/store', 'store', 'can:/usuario.index')->name('setting.store');
    Route::get('/system', 'configSistem', 'can:/usuario.index')->name('setting.system');
    Route::get('/system/modific', 'configSistemModificacion', 'can:/usuario.index')->name('setting.system.modific');
    Route::get('/statistics', 'statistics', 'can:/usuario.index')->name('setting.statistics');
    Route::get('/statistics/affiliate', 'listarAfiliados', 'can:/usuario.index')->name('setting.affiliate');
    Route::get('/statistics/countLogin', 'countLogin', 'can:/usuario.index')->name('setting.statistics.countLogin');
    Route::get('/statistics/actionHome', 'countActionHome', 'can:/usuario.index')->name('setting.statistics.actionHome');
    Route::get('/statistics/filter', 'filter', 'can:/usuario.index')->name('setting.statistics.filter');
});

Route::get('/refresh-captcha', [FormController::class, 'refreshCaptcha'])->name('refresh.captcha');

Route::prefix('error')->controller(ErrorController::class)->middleware('auth')->group(function () {
    Route::get('/404', 'error404')->name('error404');
});

Route::post('/enviar-contrasena', [PasswordController::class, 'enviarContrasenaPorCorreo'])->name('enviar-contrasena');

// $router->group(['namespace' => '\Rap2hpoutre\LaravelLogViewer', 'can:/usuario.index'], function () use ($router) {
//     $router->get('portal/setting/log-viewer', 'IndexController@index')->name('setting.logs');
// });
