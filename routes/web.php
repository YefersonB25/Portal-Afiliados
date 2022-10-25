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

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
// Route::middleware(['auth:sanctum', 'verified', 'can:/portal/fourkitesReport'])->get('/portal/automatizacion_cliente/fourkitesReport', ReportFourkites::class)->name('/portal/automatizacion_cliente/fourkitesReport');

//? Usuarios-Clientes
Route::get('usuarios/confirmar/{idUsuario?}', [UsuarioController::class, 'cambiarEstadoDatosConfirm'])->name('usuario.confirmar')->middleware('auth');
Route::get('usuarios/rechazar/{idUsuario?}', [UsuarioController::class, 'cambiarEstadoDatosRechaz'])->name('usuario.rechazar')->middleware('auth');
Route::get('usuarios', [UsuarioController::class, 'index'], 'can:/usuario.index')->name('usuario.index')->middleware('auth');
Route::get('usuarios/eliminar/{idUsuario?}', [UsuarioController::class, 'destroy'], 'can:/usuario.index')->name('usuario.eliminar')->middleware('auth');
Route::get('usuarios/config/{id}', [UsuarioController::class, 'checkout'])->name('check')->middleware('auth');


//? Perfil - Usuarios Asociados
Route::get('profile', [PerfilController::class, 'index'])->name('profile');
Route::put('profile/{id}', [PerfilController::class, 'update'])->name('profile.update')->middleware('auth');
Route::post('profile/userAsociado', [UsuarioController::class, 'createUserAsociado'])->name('userAsociado.create')->middleware('auth');
Route::get('profile/userAsociado/{id}', [UsuarioAsociadoController::class, 'elininarUserAsociado'])->name('userAsociado.delete')->middleware('auth');

//? Consulta OTM
Route::get('consultaOTM', [ConsultarAfiliadoController::class, 'index'])->name('consultar')->middleware('auth');
Route::get('consultaOTM/afiliado/{identif}', [ConsultarAfiliadoController::class, 'consultaOTM'])->name('consultar.afiliado')->middleware('auth');

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
