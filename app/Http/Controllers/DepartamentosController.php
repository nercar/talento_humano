<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Departamento;
use App\JefesDepartamento;

class DepartamentosController extends Controller
{
	public function porEmpresa($idempresa)
	{
		$departamentos = Departamento::where([ ["departamentos.activo", true], ["departamentos.id_empresa", $idempresa] ])
						->select(
								"departamentos.id",
								"departamentos.nombre",
								"departamentos.id_jefe",
								"jefes_departamentos.nombre as jefe",
								"jefes_departamentos.cargo",
								DB::raw("(SELECT COUNT(1) FROM empleados
									WHERE id_departamento = departamentos.id AND activo = true) AS cant_empl"))
						->join("empleados", "empleados.id_departamento", "departamentos.id")
						->leftJoin("jefes_departamentos", "jefes_departamentos.id", "departamentos.id_jefe")
						->where([ ["empleados.id_empresa", $idempresa], ["empleados.activo", true] ])
						->orderBy("jefes_departamentos.nombre", "ASC")
						->orderBy("departamentos.nombre", "ASC")
						->distinct()->get();
		return $departamentos;
	}

	public function conmutarJefe($iddpto, $idjefe, $idempresa, $accion)
	{
		if($accion==0) {
			$idjefe = Null;
		}

		$departamento = Departamento::where([ ['id', $iddpto], ['id_empresa', $idempresa] ])
							->update(['id_jefe' => $idjefe]);

		$jefe = ['nombre'=>'', 'cargo'=>''];
		if($accion==1) {
			$jefe = JefesDepartamento::select('nombre', 'cargo')->where('id', $idjefe)->first();
		}

		return $jefe;
	}
}
