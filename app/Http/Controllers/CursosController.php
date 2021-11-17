<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Curso;
use App\Tipo;
use App\Empleado;
use App\Empresa;
use App\Departamento;
use App\Cargo;
use App\DetalleCurso;
use App\CursoCantPart;
use App\ParticipanteCurso;

class CursosController extends Controller
{
	public function index()
	{
		$tipos = Tipo::where('activo', true)->get();
		$cursos = CursoCantPart::where('estado', 1)->get();
		$parameters = [
			'cursos' => $cursos,
			'tipos'  => $tipos,
			'texto'  => 'Todos los Tipos',
		];
		return view('cursosnuevos')->with($parameters);
	}

	public function cursosporEnviar()
	{
		$tipos = Tipo::where('activo', true)->get();
		$cursos = CursoCantPart::where('estado', 2)->get();
		$parameters = [
			'cursos' => $cursos,
			'tipos'  => $tipos,
			'texto'  => 'Todos los Tipos',
		];
		return view('cursosporenviar')->with($parameters);
	}

	public function cursosporEvaluar()
	{
		$tipos = Tipo::where('activo', true)->get();
		$cursos = CursoCantPart::where('estado', 3)->get();
		$parameters = [
			'cursos' => $cursos,
			'tipos'  => $tipos,
			'texto'  => 'Todos los Tipos',
		];
		return view('cursosporevaluar')->with($parameters);
	}

	public function cursosEjecutados()
	{
		$tipos = Tipo::where('activo', true)->get();
		$cursos = CursoCantPart::where([
					['suspendido', 0],['participantes', '>', 0],['fecha_desde', '<', date("Y-m-d")] ])->get();
		$parameters = [
			'cursos' => $cursos,
			'tipos'  => $tipos,
			'texto'  => 'Todos los Tipos',
		];
		return view('cursosejecutados')->with($parameters);
	}

	public function cursosEvaluados()
	{
		$tipos = Tipo::where('activo', true)->get();
		$cursos = CursoCantPart::where('estado', 4)->get();
		$parameters = [
			'cursos' => $cursos,
			'tipos'  => $tipos,
			'texto'  => 'Todos los Tipos',
		];
		return view('cursosevaluados')->with($parameters);
	}

	public function nuevoCurso(Request $request)
	{
	 	$reglas = [
			'nombre_nuevo'  => 'required|min:10',
			'fechad_nuevo'  => 'required|date',
			'fechah_nuevo'  => 'required|date|after_or_equal:fechad_nuevo',
			'tipo_nuevo'    => 'required|exists:tipos,id',
			'horario_nuevo' => 'required',
			'tiempo_nuevo'  => 'required',
			'entidad_nuevo' => 'required|min:5',
			'orador_nuevo'  => 'required|min:5'
		];

		$mensajes = [
			'nombre_nuevo.required'		=> 'Debe ingresar un nombre de curso válido',
			'nombre_nuevo.min'			=> 'El nombre del curso debe tener al menos 10 caracteres',
			'fechad_nuevo.required'		=> 'Debe ingresar una fecha válida',
			'fechah_nuevo.required'		=> 'Debe ingresar una fecha válida',
			'fechah_nuevo.after'		=> 'Debe ingresar una fecha mayor a la fecha desde',
			'horario_nuevo.required'	=> 'Debe ingresar un horario válido',
			'tiempo_nuevo.required'		=> 'Debe ingresar una duración válida',
			'entidad_nuevo.required'	=> 'Debe ingresar una entidad didáctica válida'	,
			'entidad_nuevo.min'			=> 'El nombre de la Entidad debe tener al menos 10 caracteres',
			'orador_nuevo.required'		=> 'Debe ingresar un nombre de instructor válido',
			'orador_nuevo.min'			=> 'El nombre del Instructor debe tener al menos 5 caracteres'
		];

		$validar = \Validator::make($request->all(), $reglas, $mensajes);

		if ($validar->fails())
		{
			return response()->json(['errors_ne'=>$validar->errors()->all()]);
		}

		$fechad = date('Y-m-d', strtotime($request->input('fechad_nuevo')) );
		$fechah = date('Y-m-d', strtotime($request->input('fechah_nuevo')) );

		$curso = new Curso;
		$curso->nombre = $request->input('nombre_nuevo');
		$curso->fecha_desde = $fechad;
		$curso->fecha_hasta = $fechah;
		$curso->id_tipo = $request->input('tipo_nuevo');
		$curso->estado = 1;
		$curso->tiempo = $request->input('tiempo_nuevo');
		$curso->origen = $request->input('origen_nuevo');
		$curso->tipo_medicion = $request->input('tipo_m_nuevo');
		$curso->orador = $request->input('orador_nuevo');
		$curso->entidad = $request->input('entidad_nuevo');
		$curso->horario = $request->input('horario_nuevo');
		$curso->save();
		return '';
	}

	public function editarCurso(Request $request, $id)
	{
		$reglas = [
			'nombre_editar'  => 'required|min:10',
			'fechad_editar'  => 'required|date',
			'fechah_editar'  => 'required|date|after_or_equal:fechad_editar',
			'tipo_editar'    => 'required|exists:tipos,id',
			'horario_editar' => 'required',
			'tiempo_editar'  => 'required',
			'entidad_editar' => 'required|min:10',
			'orador_editar'  => 'required|min:5'
		];

		$mensajes = [
			'nombre_editar.required'		=> 'Debe ingresar un nombre de curso válido',
			'nombre_editar.min'				=> 'El nombre del curso debe tener al menos 10 caracteres',
			'fechad_editar.required'		=> 'Debe ingresar una fecha válida',
			'fechah_editar.required'		=> 'Debe ingresar una fecha válida',
			'fechah_editar.after_or_equal'	=> 'Debe ingresar una fecha igual o mayor a la fecha desde',
			'horario_editar.required'		=> 'Debe ingresar un horario válido',
			'tiempo_editar.required'		=> 'Debe ingresar una duración válida',
			'entidad_editar.required'		=> 'Debe ingresar una entidad didáctica válida'	,
			'entidad_editar.min'			=> 'El nombre de la Entidad debe tener al menos 10 caracteres',
			'orador_editar.required'		=> 'Debe ingresar un nombre de instructor válido',
			'orador_editar.min'				=> 'El nombre del Instructor debe tener al menos 5 caracteres'
		];

		$validar = \Validator::make($request->all(), $reglas, $mensajes);

		if ($validar->fails())
		{
			return response()->json(['errors_ed'=>$validar->errors()->all()]);
		}

		$fechad = date('Y-m-d', strtotime($request->input('fechad_editar')) );
		$fechah = date('Y-m-d', strtotime($request->input('fechah_editar')) );

		$curso = Curso::where('id', $id)->first();
		$curso->nombre = $request->input('nombre_editar');
		$curso->fecha_desde = $fechad;
		$curso->fecha_hasta = $fechah;
		$curso->id_tipo = $request->input('tipo_editar');
		$curso->tiempo = $request->input('tiempo_editar');
		$curso->origen = $request->input('origen_editar');
		$curso->tipo_medicion = $request->input('tipo_m_editar');
		$curso->orador = $request->input('orador_editar');
		$curso->entidad = $request->input('entidad_editar');
		$curso->horario = $request->input('horario_editar');
		$curso->save();
		return '';
	}

	public function participanteCurso(Request $request, $origen, $idcurso, $idempresa=0)
	{
		$cursos = Curso::where('id', $idcurso)->select('id', 'nombre')->first();
		$empresas = Empresa::where('activo', true)->get();
		$parameters = [
			'cursos'		=> $cursos,
			'empresas'		=> $empresas,
			'idempresa'		=> $idempresa,
			'origen'		=> $origen,
		];
		return view('participantecurso')->with($parameters);
	}

	public function verparticipanteCurso($idcurso, $idempresa=0)
	{
		$cursos = Curso::where('id', $idcurso)->select('id', 'nombre')->first();
		$empresas = Empresa::where('activo', true)->get();
		$departamentos = Departamento::where('departamentos.activo', true)
						->select('departamentos.id', 'departamentos.nombre')
						->join('empleados', 'empleados.id_departamento', 'departamentos.id')
						->where('empleados.id_empresa', $idempresa)
						->orderBy('departamentos.nombre')->distinct()->get();
		$parameters = [
			'cursos' => $cursos,
			'empresas' => $empresas,
			'departamentos' => $departamentos,
			'idempresa' => $idempresa,
		];
		return view('verparticipantecurso')->with($parameters);
	}

	public function asistentesCurso($idcurso)
	{
		$nombre = Curso::select('nombre')->where('id', $idcurso)->first();
		$nombre = $nombre->nombre;
		$asistentes = ParticipanteCurso::where('id_curso', $idcurso)->get()->all();
		$iddpto = '';
		return view('asistentescurso')->with(compact('idcurso', 'nombre', 'asistentes', 'iddpto'));
	}

	public function suspenderCurso($id)
	{
		$curso = Curso::where('id', $id)->first();
		$curso->suspender = true;
		$curso->save();
		return '';
	}

	public function resumirCurso($id)
	{
		$curso = Curso::where('id', $id)->first();
		$curso->suspender = false;
		$curso->save();
		return '';
	}

	public function completarCurso($id)
	{
		$curso = Curso::where('id', $id)->first();
		$curso->estado = 2;
		$curso->save();
		return '';
	}

	public function modificaAsistencia($idcurso, $idempleado, $opcion)
	{
		$curso = DetalleCurso::where([ ['id_curso', $idcurso], ['id_empleado', $idempleado] ])->first();
		$curso->asistio = ($opcion==1);
		$curso->save();
		return '';
	}
}