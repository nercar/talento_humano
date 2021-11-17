<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\CursoCantPart;
use App\ParticipanteCurso;

class EstadisticasController extends Controller
{
	public function index()
	{
		return view('estadisticas');
	}

	public function adiestramiento()
	{
		return view('adiestramiento');
	}

	public function indicadoresMedicion($trimIni, $trimFin, $trimAnio)
	{
		$totPrg = CursoCantPart::whereMonth('fecha_desde', '>=', $trimIni )
						->whereMonth('fecha_desde', '<=', $trimFin )
						->whereYear('fecha_desde', '=', $trimAnio)
						->count();
		$totSus = CursoCantPart::whereMonth('fecha_desde', '>=', $trimIni )
						->whereMonth('fecha_desde', '<=', $trimFin )
						->whereYear('fecha_desde', '=', $trimAnio)
						->where('suspendido', 1)
						->count();
		$totEje = CursoCantPart::whereMonth('fecha_desde', '>=', $trimIni )
						->whereMonth('fecha_desde', '<=', $trimFin )
						->whereYear('fecha_desde', '=', $trimAnio)
						->where('suspendido', 0)
						->count();
		$totIso = CursoCantPart::whereMonth('fecha_desde', '>=', $trimIni )
						->whereMonth('fecha_desde', '<=', $trimFin )
						->whereYear('fecha_desde', '=', $trimAnio)
						->where('id_tipo', 1)
						->count();
		$totOtr = CursoCantPart::whereMonth('fecha_desde', '>=', $trimIni )
						->whereMonth('fecha_desde', '<=', $trimFin )
						->whereYear('fecha_desde', '=', $trimAnio)
						->where('id_tipo', '!=', 1)
						->count();
		$result = [
			'totPrg' => $totPrg,
			'totSus' => $totSus,
			'totEje' => $totEje,
			'totIso' => $totIso,
			'totOtr' => $totOtr
		];
		return $result;
	}

	public function cursosXmedicion($trimIni, $trimFin, $trimAnio)
	{
		$cursos = CursoCantPart::whereMonth('fecha_desde', '>=', $trimIni )
						->whereMonth('fecha_desde', '<=', $trimFin )
						->whereYear('fecha_desde', '=', $trimAnio)
						->where('id_tipo', 1)
						->get()->all();
		return $cursos;
	}

	public function cursosXmedir($trimIni, $trimFin, $trimAnio)
	{
		$cursos = CursoCantPart::whereMonth('fecha_desde', '>=', $trimIni )
						->whereMonth('fecha_desde', '<=', $trimFin )
						->whereYear('fecha_desde', '=', $trimAnio)
						->where('id_tipo', 1)
						->get()->all();
		return $cursos;
	}

	public function indicadoresPersonal($trimIni, $trimFin, $trimAnio)
	{
		$totPla = CursoCantPart::whereMonth('fecha_desde', '>=', $trimIni )
						->whereMonth('fecha_desde', '<=', $trimFin )
						->whereYear('fecha_desde', '=', $trimAnio)
						->sum('participantes');
		$totAdi = CursoCantPart::whereMonth('fecha_desde', '>=', $trimIni )
						->whereMonth('fecha_desde', '<=', $trimFin )
						->whereYear('fecha_desde', '=', $trimAnio)
						->sum('asistieron');
		$totNoa = $totPla - $totAdi;
		$porAdi = $totPla > 0 ? $porAdi = round((($totAdi * 100) / $totPla), 2) : 0;
		$result = [
			'totPla' => $totPla,
			'totAdi' => $totAdi,
			'totNoa' => $totNoa,
			'porAdi' => $porAdi
		];
		return $result;
	}

	public function indicadoresCumplimiento($trimIni, $trimFin, $trimAnio)
	{
		$totPro = CursoCantPart::whereMonth('fecha_desde', '>=', $trimIni )
						->whereMonth('fecha_desde', '<=', $trimFin )
						->whereYear('fecha_desde', '=', $trimAnio)
						->count();
		$totSus = CursoCantPart::whereMonth('fecha_desde', '>=', $trimIni )
						->whereMonth('fecha_desde', '<=', $trimFin )
						->whereYear('fecha_desde', '=', $trimAnio)
						->where('suspendido', 1)
						->count();
		$totEje = CursoCantPart::whereMonth('fecha_desde', '>=', $trimIni )
						->whereMonth('fecha_desde', '<=', $trimFin )
						->whereYear('fecha_desde', '=', $trimAnio)
						->where('suspendido', 0)
						->count();
		$porCum = $totPro > 0 ? $porCum = round((($totEje * 100) / $totPro), 2) : 0;
		$result = [
			'totPro' => $totPro,
			'totEje' => $totEje,
			'totSus' => $totSus,
			'porCum' => $porCum
		];
		return $result;
	}

	public function indicadoresResultados($trimIni, $trimFin, $trimAnio)
	{
		$result = DB::select("SELECT
						pc.empresa,
						pc.departamento,
						COUNT(IF(pc.asistio=1, 1, NULL)) AS total,
						SUM(pc.evaluado) AS evaluados,	
						COUNT(IF(pc.motivo='Reposo', 1, NULL)) AS reposos,
						COUNT(IF(pc.motivo='Renuncia', 1, NULL)) AS renuncias,
						COUNT(IF(pc.motivo='Vacaciones', 1, NULL)) AS vacaciones
					FROM
						participantescursos pc
						INNER JOIN cursos c ON c.id = pc.id_curso
					WHERE
						month(c.fecha_desde) BETWEEN " . $trimIni . " AND " .
						$trimFin . " AND year(c.fecha_desde) = " . $trimAnio .
					" GROUP BY pc.empresa, pc.id_departamento
					ORDER BY pc.departamento");
		return $result;
	}

	public function indicadoresAdiestramiento($trimIni, $trimFin, $trimAnio)
	{
		$result = CursoCantPart::whereMonth('fecha_desde', '>=', $trimIni )
						->whereMonth('fecha_desde', '<=', $trimFin )
						->whereYear('fecha_desde', '=', $trimAnio)
						->where('estado', '>=', 2)
						->get();
		return $result;
	}
}
