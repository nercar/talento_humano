<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\ParticipanteCurso;

class EmpleadosController extends Controller
{
	public function porDepartamento($iddpto, $empresa, $idcurso) {
		return DB::table("empleados")
			->select(
				"empleados.id AS cedula",
				"empleados.nombre AS nomemp",
				"empleados.apellido AS apeemp",
				"cargos.nombre AS nomcar",
				DB::raw("(SELECT id_curso FROM detalle_cursos
					WHERE id_curso = " . $idcurso . " AND id_empleado = empleados.id) AS idcurso"))
			->join('cargos', 'cargos.id', 'empleados.id_cargo')
			->where([ ['empleados.id_departamento', $iddpto],
					  ['empleados.id_empresa', $empresa],
					  ['empleados.activo', true],
					  ['cargos.id_empresa', $empresa]
					])
			->orderByRaw('empleados.nombre', 'empleados.apellido')
			->get();
	}

	public function personalInscrito($idcurso, $iddpto=0) {
		if($iddpto==0) {
			$resultado = ParticipanteCurso::where('id_curso', $idcurso)->get()->all();
		} else {
			$resultado = ParticipanteCurso::where([['id_curso',$idcurso],['id_departamento',$iddpto]])->get()->all();
		}
		return $resultado;
	}


}
