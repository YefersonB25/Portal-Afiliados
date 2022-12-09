<?php

use Illuminate\Support\Facades\Route;
//agregamos los siguientes controladores
use App\Http\Controllers\HomeController;
use App\Http\Controllers\RolController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\FacturaController;
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

Auth::routes();

//? Usuarios-Clientes
Route::prefix('usuarios')->controller(UsuarioController::class)->middleware('auth')->group(function () {
    Route::get('/', 'index', 'can:/usuario.index')->name('usuario.index');
    Route::get('config/{id}', 'checkout')->name('check');
    Route::get('confirmar/{usuario}/{estado}', 'confirmarDatos')->name('usuario.estado');
    Route::delete('eliminar/{idUsuario?}', 'destroy', 'can:/usuario.index')->name('usuario.eliminar');
    Route::post('userAsociado', 'createUserAsociado')->name('userAsociado.create');
    Route::post('filtros', 'filtros')->name('user.filtros');

});

Route::get('forgot-password', [AuthController::class, 'email'])->name('forgot-password');


//? Perfil - Usuarios Asociados
Route::prefix('profile')->controller(PerfilController::class)->middleware('auth')->group(function () {
    Route::get('/', 'index')->name('profile');
    Route::get('userAsociado/{id}', 'eliminarUserAsociado')->name('userAsociado.delete');
    Route::put('{id}', 'update')->name('profile.update');
});

//? Consulta OTM
Route::prefix('consultaOTM')->controller(ConsultarAfiliadoController::class)->middleware('auth')->group(function () {
    Route::get('/', 'index')->name('consultar');
    Route::get('afiliado/{id}', 'consultaOTM')->name('consultar.afiliado');
});

//? Consultar code
Route::get('customers', [FacturaController::class, 'index', 'can:/blog'])->name('blogs.index')->middleware('auth');

Route::group(['middleware' => ['auth'], 'can:/profile'], function () {
    Route::resource('roles', RolController::class);
});

$router->group(['namespace' => '\Rap2hpoutre\LaravelLogViewer'], function () use ($router) {
    $router->get('logs', 'LogViewerController@index');
});
