<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ParticipanteCurso;
use App\CursoCantPart;
use App\EvaluarCurso;
use App\Departamento;
use App\Empleado;
use App\Cargo;
use App\Curso;
use App\Tipo;

class CursosEvaluadosController extends Controller
{
	public function index()
	{
		$tipos = Tipo::where('activo', true)->get();
		
		if($_SESSION['tipo_usr']==2) {
			$participantes = ParticipanteCurso::select('id_curso')
							->where([ ['estado', 4], ['id_jefe', $_SESSION['id_usr']] ])->get();
			$cursos = CursoCantPart::whereIn('id', $participantes)->get();
		} else {
			$cursos = CursoCantPart::where('estado', 4)->get();
		}
		$parameters = [
			'cursos' => $cursos,
			'tipos'  => $tipos,
			'texto'  => 'Todos los Tipos',
		];
		return view('cursosevaluados')->with($parameters);
	}

	public function participantesEvaluados($idcurso)
	{
		$nombre = Curso::select('nombre')->where('id', $idcurso)->first();
		$nombre = $nombre->nombre;
		$participantes = ParticipanteCurso::
						where([ ['id_curso', $idcurso], ['evaluado', 1] ])
						->get();
		$iddpto = '';
		return view('participantesevaluados')->with(compact('participantes', 'nombre', 'iddpto'));
	}

	public function verEvaluacion($idcurso, $idempleado)
	{
		$curso = Curso::where('id', $idcurso)->first();
		$tipocurso = $curso->id_tipo;
		$empleado = Empleado::where('id', $idempleado)->first();
		$cargo = Cargo::where('id', $empleado->id_cargo)->first();
		$departamento = Departamento::where('id', $empleado->id_departamento)->first();
		$respuestas = EvaluarCurso::where([ ['id_curso', $idcurso], ['id_empleado', $idempleado] ])->get();
		if($tipocurso==1) {
			$totalvalor = EvaluarCurso::where([ ['id_curso', $idcurso], ['id_empleado', $idempleado] ])
							->whereBetween('id_pregunta', [1, 6])->sum('respuesta');
		}
		else {
			$totalvalor = EvaluarCurso::where([ ['id_curso', $idcurso], ['id_empleado', $idempleado] ])
							->whereBetween('id_pregunta', [3, 7])->sum('respuesta');
		}
		$totalvalor = ($totalvalor);
		if($tipocurso==1) {
			return view('verevaluacionISO')
					->with(compact('curso', 'empleado', 'cargo', 'departamento', 'respuestas', 'totalvalor'));
		}
		else {
			return view('verevaluacion')
					->with(compact('curso', 'empleado', 'cargo', 'departamento', 'respuestas', 'totalvalor'));
		}
	}
}
