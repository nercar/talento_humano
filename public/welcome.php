<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Intranet Policlínica Táchira</title>
	
	<link href="/css/bootstrap.min.css" rel="stylesheet">

	<script type="text/javascript">
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

			document.getElementById('fecha').innerHTML = fechaImprimible;
			document.getElementById('hora').innerHTML = horaImprimible;
			setTimeout('tiempo()', 1000);
		}
	</script>
</head>
<body onload="tiempo()" oncontextmenu="return false">
	<div class="container-fluid">
		<div class="row align-items-start bg-dark text-light">
			<div class="col-md-6 text-left">
				<h5>Intranet Policlínica Táchira</h5>
			</div>
			<div class="col-md-6 text-right">
				Talento Humano &#10174;
				Medición de Eficacia de Adiestramiento
			</div>
		</div>
		<table class="w-100">
			<tr height="100px" align="center">
				<td>
					<h1>Bienvenid@</h1>
				</td>
			</tr>
			<tr height="100px" align="center">
				<td>
					<img src="/images/logo.png" style="margin: auto;">
				</td>
			</tr>
			<tr height="100px" align="center">
				<td>
					<div id="fecha" class="text-center text-warning"></div>
					<div id="hora" class="text-center text-warning"></div>
				</td>
			</tr>
			<tr height="100px" align="center">
				<td>
					Por favor Inicie Sesión desde la Intranet de Policlínica Táchira
				</td>
			</tr>
			<tr height="100px" align="center">
				<td>
					Haga clic <a href="http://intranet.pth.local/intranetprueba/principal.php">aquí</a> para ser redireccionado
				</td>
			</tr>
		</table>
		<div class="fixed-bottom bg-dark text-right text-light">
			Policlínica Táchira @2018&nbsp;&nbsp;
		</div>
</body>
</html>