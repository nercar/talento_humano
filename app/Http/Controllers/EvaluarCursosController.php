<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ParticipanteCurso;
use App\DetalleCurso;
use App\EvaluarCurso;
use App\Departamento;
use App\Empleado;
use App\Cargo;
use App\Curso;

class EvaluarCursosController extends Controller
{
	public function index()
	{
		if($_SESSION['tipo_usr']==2) {
			$cursos = Curso::select('cursos.*')
						->distinct()
						->join('participantescursos as p', 'p.id_curso', '=' , 'cursos.id')
						->where([ ['cursos.estado', 3], ['p.id_jefe', $_SESSION['id_usr']], ['id_tipo', 1] ])
						->orderBy('nombre')
						->get();
		} else {
			$cursos = Curso::select('cursos.*')
						->distinct()
						->join('participantescursos as p', 'p.id_curso', '=' , 'cursos.id')
						->where([ ['cursos.estado', 3], ['id_tipo', 1] ])
						->orderBy('nombre')
						->get();
		}

		return view('evaluarporjefes')->with(compact('cursos', 'idjefe', 'nombre'));
	}

	public function participantesXEvaluar($idcurso)
	{
		$nombre = Curso::select('nombre')->where('id', $idcurso)->first();
		$nombre = $nombre->nombre;
		if($_SESSION['tipo_usr']==2) {
			$participantes = ParticipanteCurso::
							where([ ['id_curso', $idcurso], ['id_jefe', $_SESSION['id_usr']], ['evaluado', 0] ])
							->get();
		} else {
			$participantes = ParticipanteCurso::
							where([ ['id_curso', $idcurso], ['evaluado', 0] ])
							->get();
		}
		return view('participantesporevaluar')->with(compact('participantes', 'nombre'));
	}

	public function evaluarParticipante($idcurso, $idempleado)
	{
		$curso = Curso::where('id', $idcurso)->first();
		$tipocurso = $curso->tipo_medicion;
		$empleado = Empleado::where('id', $idempleado)->first();
		$cargo = Cargo::where('id', $empleado->id_cargo)->first();
		$departamento = Departamento::where('id', $empleado->id_departamento)->first();
		if($tipocurso==1) {
			return view('evaluarCurso')->with(compact('curso', 'empleado', 'cargo', 'departamento'));
		}
		else {
			return view('evaluarCursoISO')->with(compact('curso', 'empleado', 'cargo', 'departamento'));
		}
	}

	public function guardarEvaluacion(Request $request, $idcurso, $idempleado)
	{
		$fecha = date('Y-m-d', strtotime($request->input('fecha_eval')) );

		$arrayprg = json_decode(stripslashes($_POST['arrayPrgs']));
		$i = 1;
		foreach($arrayprg as $val){
			$evalcurso = new EvaluarCurso;
			$evalcurso->fecha = $fecha;
			$evalcurso->id_tipo = $request->input('id_tipo_eval');
			$evalcurso->id_curso = $request->input('id_curso_eval');
			$evalcurso->id_empleado = $request->input('id_empleado_eval');
			$evalcurso->id_pregunta = $i;
			$evalcurso->respuesta = $val;
			$evalcurso->save();
			$i++;
		}

		// Actualizar detalle_curso como evaluado
		$detallecurso = DetalleCurso::where([ ['id_curso', $idcurso], ['id_empleado', $idempleado] ])->first();
		$detallecurso->evaluado = true;
		$detallecurso->save();

		// Actualizar curso como evaluado si todos los participantes
		$detallecurso = DetalleCurso::where([ ['id_curso', $idcurso], ['evaluado', 0] ])->get();
		if(count($detallecurso)==0) {
			$curso = Curso::where('id', $idcurso)->first();
			$curso->estado = 4;
			$curso->save();
		}

		return '';
	}

	public function condicionParticipante(Request $request)
	{
		$detallecurso = DetalleCurso::where([
									['id_curso', $request->id_curso],
									['id_empleado', $request->id_empleado] ]
								)->first();
		$detallecurso->motivo = $request->select_condicion;
		$detallecurso->fecha_motivo = date("Y-m-d");
		$detallecurso->save();
		return '';
	}
}
