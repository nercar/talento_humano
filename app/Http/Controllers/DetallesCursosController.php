<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\DetalleCurso;

class DetallesCursosController extends Controller
{
	public function conmutarParticipante($idcurso, $idemp)
	{
		$detallecurso = DetalleCurso::where([ ['id_curso', $idcurso], ['id_empleado', $idemp] ])->first();

		if($detallecurso) {
			$detallecurso->delete();
		} else {
			$detallecurso = new DetalleCurso;
			$detallecurso->id_curso = $idcurso;
			$detallecurso->id_empleado = $idemp;
			$detallecurso->save();
		}

		return '';
	}
}
