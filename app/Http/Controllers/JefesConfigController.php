<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\JefesDepartamento;
use App\Departamento;
use App\Empresa;

class JefesConfigController extends Controller
{
	public function index()
	{
		$jefes = JefesDepartamento::orderBy('cargo')->get();
		return view('jefesConfig')->with(compact('jefes'));
	}

	public function inactivarJefe(Request $request, $idjefe)
	{
		$Jefe = JefesDepartamento::where('id', $idjefe)->first();
		$Jefe->activo = false;
		$Jefe->save();
		return '';
	}

	public function activarJefe(Request $request, $idjefe)
	{
		$Jefe = JefesDepartamento::where('id', $idjefe)->first();
		$Jefe->activo = true;
		$Jefe->save();
		return '';
	}
	public function editarJefe(Request $request, $idjefe)
	{
		$jefe = JefesDepartamento::where('id', $idjefe)->first();
		$jefe->cargo  = $request->input('nombre_editar');
		$jefe->nombre = $request->input('jefe_editar');
		$jefe->correo = $request->input('email_editar');
		$jefe->save();
		return '';
	}

	public function listarDepartamentos(Request $request, $idjefe)
	{
		$empresas = Empresa::where('activo', true)->get();
		$jefe = JefesDepartamento::where('id', $idjefe)->first();
		return view('seldepartamentos')->with(compact('empresas', 'jefe'));
	}

}
