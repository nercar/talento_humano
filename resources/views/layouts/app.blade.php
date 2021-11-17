<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">

	<!-- CSRF Token -->
	<meta name="csrf-token" content="{{ csrf_token() }}">

	<title>{{ config('app.name', 'Laravel') }}</title>

	<link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
	<link href="{{ asset('css/bootstrap-datepicker.min.css') }}" rel="stylesheet">
	<link href="{{ asset('css/all.css') }}" rel="stylesheet">

	<style>
		.flotante {
			display: scroll;
			position: fixed;
			bottom: 0px;
			right: 0px;
		}

		.contenido {
			overflow-y: auto;
			overflow-x: hidden;
			height: 1px;
			min-height: 1px;
			margin: 0px;
			padding: 0px;
			display: block;
		}

		.table-hover tbody tr:hover td, .table-hover tbody tr:hover th {
			background-color: inherit;
			color: inherit;
			cursor: default;
		}

		button {
			cursor: pointer;
			padding: 3px;
			margin: 3px;
		}

		.disabled {
			cursor: default;
			border: none;
			color: inherit;
		}

		.img_btn {
			opacity: 1;
			cursor: pointer;
			color: #404040;
			text-shadow: none;
			padding-left: 5px;
			padding-right: 5px;
		}

		.img_btn:hover {
			color: #0094FF;
			text-shadow: none;
		}

		.img_btnd {
			color: initial;
			opacity: 0.3;
			cursor: default;
			text-shadow: none;
			padding-left: 5px;
			padding-right: 5px;
		}

		.txtLabel {
			border: 0px;
			background: transparent;
			color: inherit;
			cursor: default;
			margin: 0px;
			padding: 0px;
			text-align: center;
		}

		.txtLabelSus {
			border: 0px;
			background: transparent;
			color: inherit;
			cursor: default;
			margin: 0px;
			padding: 0px;
			text-align: center;
			color: #FFFFFF;
			text-shadow: -1px -1px 1px rgba(0, 0, 0, .75);
			font-style: italic;
		}

		.edo_suspendido {
			color:#FFFFFF;
			text-shadow: -1px -1px 1px rgba(0, 0, 0, .75);
			font-style: italic; 
			background: #C5C5C5; /*fallback for non-CSS3 browsers*/
			background: -webkit-gradient(linear, 0 0, 0 100%, from(#C5C5C5) to(#EEEEEE)); /*old webkit*/
			background: -webkit-linear-gradient(#C5C5C5, #EEEEEE); /*new webkit*/
			background: -moz-linear-gradient(#C5C5C5, #EEEEEE); /*gecko*/
			background: -ms-linear-gradient(#C5C5C5, #EEEEEE); /*IE10*/
			background: -o-linear-gradient(#C5C5C5, #EEEEEE); /*opera 11.10+*/
			background: linear-gradient(#C5C5C5, #EEEEEE); /*future CSS3 browsers*/
		}

		.resaltado {
			color:#FFFFFF;
			text-shadow:1px 1px 1px #000;
			background: #2B62D3; /*fallback for non-CSS3 browsers*/
			background: -webkit-gradient(linear, 0 0, 0 100%, from(#2B62D3) to(#3270F0)); /*old webkit*/
			background: -webkit-linear-gradient(#2B62D3, #3270F0); /*new webkit*/
			background: -moz-linear-gradient(#2B62D3, #3270F0); /*gecko*/
			background: -ms-linear-gradient(#2B62D3, #3270F0); /*IE10*/
			background: -o-linear-gradient(#2B62D3, #3270F0); /*opera 11.10+*/
			background: linear-gradient(#2B62D3, #3270F0); /*future CSS3 browsers*/
		}

		.optiontd {
			border: 1px solid #000;
			text-align: center;
			vertical-align: middle;
		}

		.optiontd:hover {
			background-color: #99ABBD;
			border: 1px solid;
		}

		.optiontd:out {
			background-color: inherit;
			border: 1px solid;
		}

		.optiontdd {
			border: 1px solid #000;
			text-align: center;
			vertical-align: middle;
			border: 1px solid;
			text-align: center;
			cursor: custom;
		}
	</style>
</head>
<body style="overflow-x: hidden; overflow-y: auto;" oncontextmenu="return false"
	onload="resizeContenido('cont_ppal', 0)" onresize="resizeContenido('cont_ppal', 0)">
	<script src="{{ asset('js/jquery.min.js') }}"></script>
	<script src="{{ asset('js/popper.min.js') }}"></script>
	<script src="{{ asset('js/bootstrap.min.js') }}"></script>
	<script src="{{ asset('js/bootstrap-datepicker.min.js') }}"></script>
	<script src="{{ asset('js/bootstrap-datepicker.es.min.js') }}"></script>

	<div class="container-fluid">
		<div class="row align-items-center bg-dark text-light" id="titulo">
			<div class="col-md-6 text-left">
				<h4>{{ config('app.name', 'Laravel') }}</h4>
			</div>
			<div class="col-md-6 text-right">
				<h6>Talento Humano &#10174;
				Medición de Eficacia de Adiestramiento</h6>
			</div>
		</div>

		<div class="row">
			<!-- Menú lateral Izquierdo -->
			<div class="text-center m-0 p-0 bg-secondary col-md-2" style="font-size: 90%">
				<!-- Cabecera de la barra lateral -->
				<div class="card card-body m-0 p-0 bg-light text-center align-items-center">
					<table class="w-100 m-0 p-0 border-0">
						<tr>
							<td>
								<img src="/images/logo.png" width="50%">
							</td>
						</tr>
						<tr>
							<td style="line-height: 1;">
								<h4 class="text-info">Bienvenid@</h4>
							</td>
						</tr>
						<tr>
							<td title="{{ '(' . $_SESSION['id_usr'] . ')' }}" style="line-height: 1;">
								{{ $_SESSION['nombre_usr'] }}
							</td>
						</tr>
						<tr>
							<td>
								<div id="fecha" class="text-center text-warning"></div>
								<div id="hora" class="text-center text-warning"></div>
							</td>
						</tr>
					</table>
				</div>
				<!-- Opciones del sistema -->
				<div class="text-center card card-body p-1 m-0 bg-light">
					@if($_SESSION['tipo_usr']==1)
						<button class="btn-outline-info rounded
								@if(request()->is('cursosnuevos*') OR
									request()->is('participantescurso/n*')) active @endif"
								onclick="location.href='/cursosnuevos#'">
							Cursos Nuevos
						</button>
						<button class="btn-outline-info rounded
								@if(request()->is('cursosporenviar*') OR
									request()->is('participantescurso/e*')) active @endif"
								onclick="location.href='/cursosporenviar#'">
							Cursos por Enviar a los Jefes
						</button>
						<button class="btn-outline-info rounded
								@if(request()->is('cursosejecutados*') OR
									request()->is('asistenciacurso*')) active @endif"
								onclick="location.href='/cursosejecutados#'">
							Cursos Ejecutados
						</button>
						<hr>
					@endif
					<button class="btn-outline-info rounded
							@if(request()->is('cursosporevaluar*')) active @endif"
							onclick="location.href='/cursosporevaluar#'">
						Cursos por Evaluar
					</button>
<!-- 					<button class="btn-outline-info rounded
							@if(request()->is('evaluarporjefes*') OR
								request()->is('participantesporevaluar*') OR
								request()->is('evaluarcurso*')) active @endif"
							onclick="location.href='/evaluarporjefes#'">
						Participantes por Evaluar
					</button> -->
					<button class="btn-outline-info rounded
							@if(request()->is('cursosevaluados*') OR
								request()->is('participantesevaluados*')) active @endif"
							onclick="location.href='/cursosevaluados#'">
						Cursos Evaluados
					</button>
				</div>
			</div>
			<!-- Contenido de la página principal -->
			<div class="contenido p-1 col-md-9" style="font-size: 90%" tabindex='1' id="cont_ppal">
				@yield('content')
			</div>
			<!-- Menú lateral derecho -->
			<div class="text-center m-0 p-0 bg-secondary col-md-1" style="font-size: 90%">
				<div class="card card-body bg-light m-0 p-0">
					<button class="btn-outline-success font-weight-bold rounded" 
							onclick="location.href='/regresarintranet#'"
							title="Regresar al Menu Principal - Intranet">
						Inicio Intranet
					</button>
					<a class="dropdown-item text-center m-0 p-0" href="/#">
						<img src="/images/home.png" height="48px;">
						<div style="font-size: 12px">Inicio</div>
					</a>
					@if($_SESSION['tipo_usr']==1)
						<a class="dropdown-item text-center m-0 p-0" data-toggle="modal" data-target="#ModalNuevo"
							href="#" id="newTraining">
							<img src="/images/nuevo.png" height="48px;">
							<div style="font-size: 12px">Nuevo curso</div>
						</a>
						<hr>
						<a class="dropdown-item text-center m-0 p-0
							@if(request()->is('configurarjefes*') OR 
								request()->is('seldprtmntos*')) active @endif" href="/configurarjefes#">
							<img src="/images/jefes.png" height="48px;">
							<div style="font-size: 12px">Conf. Jefes</div>
						</a>
						<hr>
						<a class="dropdown-item text-center m-0 p-0
							@if(request()->is('estadisticas*')) active @endif" href="/estadisticas#">
							<img src="/images/estadisticas.png" height="48px;">
							<div style="font-size: 12px">Estadísticas</div>
						</a>
						<hr>
						<a class="dropdown-item text-center m-0 p-0
							@if(request()->is('adiestramientos*')) active @endif" href="/adiestramientos#">
							<img src="/images/calendario.png" height="48px;">
							<div style="font-size: 12px">Adiestramiento</div>
						</a>
					@endif
				</div>
			</div>
			@include('nuevocurso')
		</div>
		<img src="/images/ayuda.png" style="cursor: pointer;" class="flotante rounded-circle border border-warning" onclick="location.href='/ayuda'">
	</div>

	<script type="text/javascript">
		jQuery(".date, .input-daterange").datepicker({
			format: "dd-mm-yyyy",
			todayBtn: "linked",
			language: "es",
			autoclose: true,
			todayHighlight: true
		});

		jQuery(function () {
			tiempo();
		});

		function tiempo(){
			var meses = new Array ("Ene.", "Feb.", "Mar.", "Abr.", "May.", "Jun.",
								   "Jul.","Ago.","Sep.","Oct.","Nov.","Dic.");
			var dias = new Array("Dom.", "Lun.", "Mar.", "Mié.", "Jue.", "Vie.", "Sáb.");
			var momentoActual = new Date()
			var dial = momentoActual.getDay()
			var dia = momentoActual.getDate()
			var mes = meses[momentoActual.getMonth()]
			var ano = momentoActual.getFullYear()
			var hora = momentoActual.getHours()
			var minuto = '0' + momentoActual.getMinutes()
			var segundos = '0' + momentoActual.getSeconds()
			var dn = 'am'

			if (hora>12) { hora = hora - 12; dn = 'pm' }
			if (hora==0) hora = 12

			var fechaImprimible = dias[dial] + ' ' + dia + ' de ' + mes + ' de ' + ano
			var horaImprimible  = hora + ":" + minuto.substr(-2, 2) + "<sup>" + segundos.substr(-2, 2) + dn + '</sup>'

			jQuery('#fecha').html(fechaImprimible);
			jQuery('#hora').html(horaImprimible);
			setTimeout('tiempo()', 1000);
		}

		function resizeContenido(divId, pxRestar){
			jQuery('#'+divId).css('height' , (window.innerHeight - jQuery('#titulo').height() - pxRestar) + 'px');
		};

		function toTitleCase(str) {
			return str.replace(
				/\w\S*/g,
				function(txt) {
					return txt.charAt(0).toUpperCase() + txt.substr(1).toLowerCase();
				}
			);
		}

		function convertDate(fecha) {
			function pad(s) { return (s < 10) ? '0' + s : s; }
			var d = new Date(fecha);
			return [pad(d.getDate()), pad(d.getMonth()+1), d.getFullYear()].join('-');
		}

		function soloNumeros(evt) {
			var e = evt || window.event;
			var key = e.keyCode || e.which;
			console.log(e.char, e.key, key)
			if(e.char=="'" || e.key=="'" ||
			   e.char=="#" || e.key=="#" ||
			   e.char=="$" || e.key=="$" ||
			   e.char=="%" || e.key=="%" ||
			   e.char=="&" || e.key=="&" ||
			   e.char=="(" || e.key=="(")
				key = 0
			if (!e.shiftKey && !e.altKey && !e.ctrlKey &&
			// numbers   
			key >=  48 && key <= 57  ||
			// numbers pad
			key >=  96 && key <= 105 ||
			// Home and End
			key == 110 || key == 190 ||
			// Backspace and Tab and Enter
			key ==  8  || key == 9   || key == 13 ||
			// Home and End
			key ==  35 || key == 36  ||
			// left and right arrows
			key ==  37 || key == 39  ||
			// up and down arrows
			key ==  38 || key == 40  ||
			// Del and Ins
			key ==  46 || key == 116) {
				// input is VALID
			} else {
				// input is INVALID
				e.returnValue = false;
				if (e.preventDefault) e.preventDefault();
			}
		};
	</script>
</body>