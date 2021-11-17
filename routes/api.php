<?php

use Illuminate\Http\Request;

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

Route::get('/empleados/{iddpto}/{empresa}/{idcurso}', 'EmpleadosController@porDepartamento');
Route::get('/personalinscrito/{idcurso}/{id_departamento?}', 'EmpleadosController@personalInscrito');
Route::get('/estaInscritoCurso/{idcurso}/{id_empleado}', 'EmpleadosController@estaInscritoCurso');
Route::get('/cursosxmedicion/{trimIni}/{trimFin}/{anio}', 'EstadisticasController@cursosXmedicion');
Route::get('/cursosxmedir/{trimIni}/{trimFin}/{anio}', 'EstadisticasController@cursosXmedir');

Route::get('/departamentos/{empresa}', 'DepartamentosController@porEmpresa');
Route::post('/conmutarJefe/{iddpto}/{idjefe}/{idempresa}/{accion}', 'DepartamentosController@conmutarJefe');