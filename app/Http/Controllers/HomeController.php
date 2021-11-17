<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\JefesDepartamento;

class HomeController extends Controller
{
	public function index()
	{
		// tipo = 1 -> Personal de Talento Humano - = 2 -> Jefe de Area
		if($_SESSION['login']=='thcurso') {
			// tipo-usr = 1 -> Usuario Personal de Talento Humano
			$_SESSION['tipo_usr'] = 1;
			$_SESSION['id_usr'] = 0;
			$_SESSION['nombre_usr'] ='Talento Humano - Adiestramiento';
		} else {
			// tipo_usr = 2 -> Usuario Jefe de Area
			$_SESSION['tipo_usr'] = 2;
			$usuario = JefesDepartamento::select('id', 'nombre')
						->where('login', $_SESSION['login'])->first();
			$_SESSION['id_usr'] = $usuario->id;
			$_SESSION['nombre_usr'] = $usuario->nombre;
		}
		return view('home');
	}

	public function regresarIntranet()
	{
		session_destroy();
		header("Location: http://intranet.pth.local/intranetprueba/principal.php");
		exit();
	}

	public function ayuda()
	{
		return view('ayuda');
	}	
}
