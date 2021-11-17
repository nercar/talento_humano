<?php

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

// get inicio
Route::get('/', 'HomeController@index');
Route::get('/regresarintranet', 'HomeController@regresarIntranet');
Route::get('/ayuda', 'HomeController@ayuda');

// getters	----	Jefes	----
Route::get('/configurarjefes', 'JefesConfigController@index');
Route::get('/seldprtmntos/{idjefe}', 'JefesConfigController@listarDepartamentos');

// Cursos
Route::get('/cursosnuevos', 'CursosController@index');
Route::get('/cursosporenviar', 'CursosController@cursosporEnviar');
Route::get('/cursosporevaluar', 'CursosController@cursosporEvaluar');
Route::get('/cursosejecutados', 'CursosController@cursosEjecutados');
Route::get('/participantescurso/{origen}/{idcurso}/{idempresa?}', 'CursosController@participanteCurso');
Route::get('/verparticipantescurso/{idcurso}/{idempresa?}', 'CursosController@verParticipanteCurso');
Route::get('/asistenciacurso/{idcurso}', 'CursosController@asistentesCurso');

// Evaluacion
Route::get('/evaluarporjefes', 'EvaluarCursosController@index');
Route::get('/participantesporevaluar/{idcurso}', 'EvaluarCursosController@participantesXEvaluar');
Route::get('/evaluarcurso/{idcurso}/{idempleado}', 'EvaluarCursosController@evaluarParticipante');

// Evaluados
Route::get('/cursosevaluados', 'CursosEvaluadosController@index');
Route::get('/participantesevaluados/{idcurso}', 'CursosEvaluadosController@participantesEvaluados');
Route::get('/verevaluacion/{idcurso}/{idempleado}', 'CursosEvaluadosController@verEvaluacion');

// Estadisticas
Route::get('/estadisticas', 'EstadisticasController@index');
Route::get('/adiestramientos', 'EstadisticasController@adiestramiento');
Route::get('/indicadoresmedicion/{trimIni}/{trimFin}/{anio}', 'EstadisticasController@indicadoresMedicion');
Route::get('/indicadorespersonal/{trimIni}/{trimFin}/{anio}', 'EstadisticasController@indicadoresPersonal');
Route::get('/indicadorescumplimiento/{trimIni}/{trimFin}/{anio}', 'EstadisticasController@indicadoresCumplimiento');
Route::get('/indicadoresresultados/{trimIni}/{trimFin}/{anio}', 'EstadisticasController@indicadoresResultados');
Route::get('/indicadoresadiestramiento/{trimIni}/{trimFin}/{anio}', 'EstadisticasController@indicadoresAdiestramiento');

// posts	----	Jefes	----
Route::post('/inactivarJefe/{id}', 'JefesConfigController@inactivarJefe');
Route::post('/activarJefe/{id}', 'JefesConfigController@activarJefe');
Route::post('/editarJefe/{id}', 'JefesConfigController@editarJefe');

// Cursos
Route::post('/suspendercurso/{id}', 'CursosController@suspenderCurso');
Route::post('/resumircurso/{id}', 'CursosController@resumirCurso');
Route::post('/completarcurso/{id}', 'CursosController@completarCurso');
Route::post('/crearcurso', 'CursosController@nuevoCurso');
Route::post('/editarcurso/{id}', 'CursosController@editarCurso');
Route::post('/modificarasistencia/{idcurso}/{idempleado}/{opcion}', 'CursosController@modificaAsistencia');

// Detalle Cursos
Route::post('/conmutarParticipante/{idcurso}/{idemp}', 'DetallesCursosController@conmutarParticipante');

// Evaluacion
Route::post('/guardarevaluacion/{idcurso}/{idempleado}', 'EvaluarCursosController@guardarEvaluacion');
Route::post('/condicionparticipante', 'EvaluarCursosController@condicionParticipante');
