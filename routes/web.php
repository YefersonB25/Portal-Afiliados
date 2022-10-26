<?php

use Illuminate\Support\Facades\Route;
//agregamos los siguientes controladores
use App\Http\Controllers\HomeController;
use App\Http\Controllers\RolController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\ConsultarAfiliadoController;
use App\Http\Controllers\PerfilController;
use App\Http\Controllers\UsuarioAsociadoController;

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
});

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// Auth::routes();
// Route::middleware(['auth:sanctum', 'verified', 'can:/portal/fourkitesReport'])->get('/portal/automatizacion_cliente/fourkitesReport', ReportFourkites::class)->name('/portal/automatizacion_cliente/fourkitesReport');

//? Usuarios-Clientes
Route::prefix('usuarios')->controller(UsuarioController::class)->middleware('auth')->group(function () {
    Route::get('/', 'index', 'can:/usuario.index')->name('usuario.index');
    Route::get('config/{id}', 'checkout')->name('check');
    Route::get('confirmar/{idUsuario?}', 'cambiarEstadoDatosConfirm')->name('usuario.confirmar');
    Route::get('rechazar/{idUsuario?}', 'cambiarEstadoDatosRechaz')->name('usuario.rechazar');
    Route::get('eliminar/{idUsuario?}', 'destroy', 'can:/usuario.index')->name('usuario.eliminar');
    Route::post('userAsociado', 'createUserAsociado')->name('userAsociado.create');
    Route::get('userAsociado/{id}', 'elininarUserAsociado')->name('userAsociado.delete');
});

//? Perfil - Usuarios Asociados
Route::prefix('profile')->controller(PerfilController::class)->middleware('auth')->group(function () {
    Route::get('/', 'index')->name('profile');
    Route::put('{id}', 'update')->name('profile.update');
});

//? Consulta OTM
Route::prefix('consultaOTM')->controller(ConsultarAfiliadoController::class)->middleware('auth')->group(function () {
    Route::get('/', 'index')->name('consultar');
    Route::get('afiliado/{identif}', 'consultaOTM')->name('consultar.afiliado');
});
// Route::get('usuarios{idUsuario?}', [UsuarioController::class, 'cambiarEstadoDatosRechaz'])->name('usuario')->middleware('auth');
// Route::get('usuarios/rechazar/{idUsuario?}', [UsuarioController::class, 'edit'])->name('usuario')->middleware('auth');

//? Consultar code
Route::get('customers', [BlogController::class, 'index', 'can:/blog'])->name('blogs.index')->middleware('auth');

//y creamos un grupo de rutas protegidas para los controladores
//Route::group(['middleware' => ['auth'], 'can:/blog'], function () {
//    Route::resource('blogs',  BlogController::class);
//});

Route::group(['middleware' => ['auth'], 'can:/profile'], function () {
    Route::resource('roles', RolController::class);
    // Route::resource('usuarios', UsuarioController::class);
});

$router->group(['namespace' => '\Rap2hpoutre\LaravelLogViewer'], function () use ($router) {
    $router->get('logs', 'LogViewerController@index');
});
