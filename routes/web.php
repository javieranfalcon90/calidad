<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::middleware('auth')->group(function () {



Route::get('/', ['App\Http\Controllers\DashboardController', 'home'])->name('home');



Route::resource('fuentes', 'App\Http\Controllers\FuenteController')
        ->parameters(['fuentes' => 'fuente'])
        ->except(['show'])
        ->names('fuentes');

Route::resource('clasificaciones', 'App\Http\Controllers\ClasificacionController')
        ->parameters(['clasificaciones' => 'clasificacion'])
        ->except(['show'])
        ->names('clasificaciones');

Route::resource('procesos', 'App\Http\Controllers\ProcesoController')
        ->parameters(['procesos' => 'proceso'])
        ->except(['show'])
        ->names('procesos');

Route::resource('tipos', 'App\Http\Controllers\TipoController')
        ->parameters(['tipos' => 'tipo'])
        ->except(['show'])
        ->names('tipos');

Route::resource('responsables', 'App\Http\Controllers\ResponsableController')
        ->parameters(['responsables' => 'responsable'])
        ->except(['show'])
        ->names('responsables');

Route::resource('efectividades', 'App\Http\Controllers\EfectividadController')
        ->parameters(['efectividades' => 'efectividad'])
        ->except(['show'])
        ->names('efectividades');

Route::resource('niveles', 'App\Http\Controllers\NivelController')
        ->parameters(['niveles' => 'nivel'])
        ->except(['show'])
        ->names('niveles');

Route::resource('requisitos', 'App\Http\Controllers\RequisitoController')
        ->parameters(['requisitos' => 'fuente'])
        ->except(['show'])
        ->names('requisitos');




Route::resource('users', 'App\Http\Controllers\UserController')
        ->parameters(['users' => 'user'])
        ->except(['show'])
        ->names('users');

Route::resource('roles', 'App\Http\Controllers\RoleController')
        ->parameters(['roles' => 'role'])
        ->except(['show'])
        ->names('roles');

Route::resource('permissions', 'App\Http\Controllers\PermissionController')
        ->parameters(['permissions' => 'permission'])
        ->except(['show'])
        ->names('permissions');

Route::get('audits', ['App\Http\Controllers\AuditController', 'index'])->name('audits.index');


Route::get('notifications/{notification}/read', ['App\Http\Controllers\NotificationController', 'read'])->name('notifications.read');
Route::get('notifications/readall', ['App\Http\Controllers\NotificationController', 'readall'])->name('notifications.readall');
        


Route::resource('noconformidades', 'App\Http\Controllers\NoconformidadController')
        ->parameters(['noconformidades' => 'noconformidad'])
        ->names('noconformidades');
Route::post('noconformidades/{noconformidad}/cerrar', ['App\Http\Controllers\NoconformidadController', 'cerrar'])->name('noconformidades.cerrar');

Route::resource('riesgos', 'App\Http\Controllers\RiesgoController')
        ->parameters(['riesgos' => 'riesgo'])
        ->names('riesgos');
Route::post('riesgos/{riesgo}/cerrar', ['App\Http\Controllers\RiesgoController', 'cerrar'])->name('riesgos.cerrar');

Route::resource('analisis', 'App\Http\Controllers\AnalisisController')
        ->parameters(['analisis' => 'analisis'])
        ->except(['index', 'show'])
        ->names('analisis');

Route::resource('acciones', 'App\Http\Controllers\AccionController')
        ->parameters(['acciones' => 'accion'])
        ->except(['index'])
        ->names('acciones');
Route::post('acciones/{accion}/cerrar', ['App\Http\Controllers\AccionController', 'cerrar'])->name('acciones.cerrar');

Route::resource('seguimientos', 'App\Http\Controllers\SeguimientoController')
        ->parameters(['seguimientos' => 'seguimiento'])
        ->except(['index', 'show'])
        ->names('seguimientos');

Route::resource('valoraciones', 'App\Http\Controllers\ValoracionController')
        ->parameters(['valoraciones' => 'valoracion'])
        ->except(['index', 'show'])
        ->names('valoraciones');


Route::resource('oportunidades', 'App\Http\Controllers\OportunidadController')
        ->parameters(['oportunidades' => 'oportunidad'])
        ->names('oportunidades');
Route::post('oportunidades/{oportunidad}/cerrar', ['App\Http\Controllers\OportunidadController', 'cerrar'])->name('oportunidad.cerrar');




});