@extends('layouts.app')

@section('content')
	<div class="container-fluid col-xl-12 col-md-12 col-12 p-0 m-0 bg-dark">
		<table class="table p-0 m-0">
			<tr>
				<td width="40%" class="border-0 p-1 m-0" style="vertical-align: middle;">
					<h6>Adiestramientos Realizados</h6>
				</td>
				<td width="17%" class="border-0 p-1 m-0" style="vertical-align: middle;">
					<h6>Elija el Trimestre y Año:</h6>
				</td>
				<td width="15%" class="border-0 p-1 m-0" style="vertical-align: middle;">
					<select class="form-control form-control-sm" id="trimestre">
						<option value="1" >Trimestre I</option>
						<option value="4" >Trimestre II</option>
						<option value="7" >Trimestre III</option>
						<option value="10">Trimestre IV</option>
					</select>
				</td>
				<td width="8%" class="border-0 p-1 m-0" style="vertical-align: middle;">
					<select class="form-control form-control-sm" id="anios"></select>
				</td>
				<td width="20%" class="border-0 p-1 m-0" style="vertical-align: middle;">
					<button class="btn btn-sm btn-success" id="generar">Generar</button>
					<button class="btn btn-sm btn-warning d-none" id="cancelar">Cancelar</button>
					<button class="btn btn-sm btn-primary d-none" id="exportar">Exportar a Excel</button>
				</td>
			</tr>
		</table>
	</div>

	<form action="ficheroExcel.php" method="post" target="_blank" id="ExportarMedicion" class="d-none">
		<input type="text" id="nombre_archivo" name="nombre_archivo" value="medicion">
		<input type="text" id="datos_a_enviar" name="datos_a_enviar">
	</form>

	<div id="TopeLista"></div>
	<div class="row contenido col-xl-12 col-md-12 col-12 pt-2 d-none border border-info" id="resultado">
		<div align="center"><img src="/images/loading.gif"></div>
	</div>

	<script>
		jQuery('document').ready(function() {
			var htmlTabla = '';
			var htmlTabla_exp = '';
			jQuery('#opcionact').val('medicion');
			jQuery('#nombre_archivo').val('medicion.xls');
			cargarAnios();
		});

		jQuery(window).resize(function() {
			setTimeout("resizeContenido('resultado', " + ( jQuery('#TopeLista').position().top ) + ")", 100);
		});

		jQuery('#cancelar').click(function() {
			jQuery('#resultado').addClass('d-none');
			jQuery('#resultado').html('<div align="center"><img src="/images/loading.gif"></div>');
			jQuery('#generar').removeClass('d-none');
			jQuery('#cancelar').addClass('d-none');
			jQuery('#exportar').addClass('d-none');
		});

		jQuery('#exportar').click(function() {
			jQuery("#datos_a_enviar").val( jQuery("<div>").append( htmlTabla_exp ).html());
			jQuery("#ExportarMedicion").submit();
		});

		jQuery('#trimestre,#anios').on('change', function() {
			jQuery('#resultado').addClass('d-none');
			jQuery('#resultado').html('<div align="center"><img src="/images/loading.gif"></div>');
			jQuery('#generar').removeClass('d-none');
			jQuery('#cancelar').addClass('d-none');
			jQuery('#exportar').addClass('d-none');
		});

		function resizeTables() {
			jQuery('#resultado').css('height', (window.innerHeight)-jQuery('#TopeLista').position().top - 10 + 'px');
			jQuery('#resultado').css('display', 'block');
		};

		function cargarAnios() {
			var fecha = new Date();
			var anio = fecha.getFullYear();
			var aniof = anio + 5
			for(i=2018; i<=aniof; i++){
				var option = document.createElement("option"); 	//Creas el elemento opción
        		jQuery(option).html(i); 						//Escribes en él el valor
        		jQuery(option).appendTo("#anios");
			}
		}

		jQuery('#generar').click(function() {
			jQuery('#generar' ).addClass('d-none');
			var trimIni = jQuery('#trimestre').val();
			var trimFin = parseInt(jQuery('#trimestre').val()) + 2;
			var triAnio = jQuery('#anios').val();
			var trimSel = jQuery("#trimestre").prop("selectedIndex");
			var trimUlt = jQuery('#trimestre > option').length - 1;
			var anioSel = triAnio;

			if(trimSel==trimUlt) {
				var trimSgt = 0;
				anioSel = parseInt(triAnio) + 1;
			} else {
				var trimSgt = jQuery("#trimestre").prop("selectedIndex") + 1;
			}

			jQuery("#trimestre").prop("selectedIndex", trimSgt);
			var txttSgt = jQuery('select[id="trimestre"] option:selected').text().toUpperCase();
			var valtSgt = jQuery('#trimestre').val();
			jQuery("#trimestre").prop("selectedIndex", trimSel);
			var txtPMed = jQuery('select[id="trimestre"] option:selected').text().toUpperCase() + " AÑO ";
				txtPMed+= jQuery('select[id="anios"] option:selected').text();
			var txtTiso = jQuery('select[id="trimestre"] option:selected').text().toUpperCase() + " AÑO ";
				txtTiso+= jQuery('select[id="anios"] option:selected').text()

			var htmlTabla = '<div align="center"><img src="/images/loading.gif"></div>';

			jQuery.ajaxSetup({ headers: { 'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content') } });
			jQuery.ajax({
				url: '/indicadoresadiestramiento\/' + trimIni + "/" + trimFin + "/" + triAnio,
				method: "get",
				async: false,
				success: function(result) {
					var totPar = 0;
					var totAsi = 0;
					var totCur = 0;
					var totEje = 0;
					var totMed = 0;
					var totEva = 0;
					var fechad = [];
					var fechah = [];
					htmlTabla  =
						'<table width="95%" align="center" id="adiestramiento" style="font-size: 12px;"> ' +
							'<tr style="vertical-align: middle;"> ' +
								'<td style="border: thin solid black; font-weight: bold;" colspan="10" align="center"> ' +
									'PROGRAMACIÓN TRIMESTRAL DE ADIESTRAMIENTO' +
								'</td> ' +
							'</tr> ' +
							'<tr style="vertical-align: middle;" align="center"> ' +
								'<td colspan="3" style="border: thin solid black">Revisión No.:<br>2</td>' +
								'<td colspan="2" style="border: thin solid black">Fecha de Aprobación:<br>Junio de 2016</td>' +
								'<td colspan="2" style="border: thin solid black">No. de Identificación:<br>TH-FOR-014</td>' +
								'<td colspan="3" style="border: thin solid black">Página:<br>1 de 1</td>' +
							'</tr>' +
							'<tr style="vertical-align: middle;"> ' +
								'<td style="border: thin solid black; font-weight: bold;" colspan="10" align="center"> ' +
									 'PROCEDIMIENTO PARA PARA LA EJECUCIÓN DEL PROGRAMA DE ADIESTRAMIENTO' +
								'</td> ' +
							'</tr> ' +
							'<tr style="vertical-align: middle;"> ' +
								'<td style="font-weight: bold;" colspan="10" align="center"> ' +
									 txtPMed +
								'</td> ' +
								'<td width="1%" style="color: white">|</td>' +
								'<td style="font-weight: bold;" colspan="3" align="center">Uso Interno</td>' +
							'</tr>' +
							'<tr align="center" style="font-weight: bold; vertical-align: middle;">' +
								'<td width="29%" rowspan="2" colspan="2" style="border: thin solid black;">' +
									'NOMBRE DEL CURSO' +
								'</td>' +
								'<td width="14%" rowspan="2" style="border: thin solid black;">' +
									'INSTRUCTOR' +
								'</td>' +
								'<td width="14%" rowspan="2" style="border: thin solid black;">' +
									'ENTIDAD DIDACTICA' +
								'</td>' +
								'<td width="6%" rowspan="2" style="border: thin solid black;">' +
									'FECHA' +
								'</td>' +
								'<td width="13%" rowspan="2" style="border: thin solid black;">' +
									'HORARIO' +
								'</td>' +
								'<td width="4%" rowspan="2" style="border: thin solid black;">' +
									'DURACIÓN' +
								'</td>' +
								'<td width="10%" colspan="2" style="border: thin solid black;">' +
									'No. DE PARTIC.' +
								'</td>' +
								'<td width="10%" rowspan="2" style="border: thin solid black;">' +
									'CARGO DE LOS PARTICIPANTES' +
								'</td>' +
								'<td width="1%"></td>' +
								'<td rowspan="2" style="border: thin solid black;">' +
									'MEIDR EFICACIA' +
								'</td>' +
								'<td rowspan="2" style="border: thin solid black;">' +
									'NO MEDIR EFICACIA' +
								'</td>' +
								'<td rowspan="2" style="border: thin solid black;">' +
									'EVALUADO - PTOS.' +
								'</td>' +
							'</tr>' +
							'<tr align="center" style="font-weight: bold; vertical-align: middle;">' +
								'<td width="5%" style="border: thin solid black;">' +
									'NTP' +
								'</td>' +
								'<td width="5%" style="border: thin solid black;">' +
									'NTA' +
								'</td>' +
							'</tr>';
					for (i=0; i<result.length; ++i) {
						fechad = result[i].fecha_desde.split("-");
						fechah = result[i].fecha_hasta.split("-");
						fechad = fechad[2] + '/' + fechad[1] + '/' + fechad[0];
						fechah = fechah[2] + '/' + fechah[1] + '/' + fechah[0];
						console.log(fechad, '-', fechah);
						htmlTabla +=
							'<tr style="height: 30px; vertical-align: middle;">'+
								'<td colspan="2" align="justify" style="border: thin solid black;">' +
									result[i].nombre +
								'</td>' + 
								'<td align="justify" style="border: thin solid black;">' +
									result[i].orador +
								'</td>' + 
								'<td align="justify" style="border: thin solid black;">' +
									result[i].entidad +
								'</td>' + 
								'<td align="center" style="border: thin solid black;">' +
									fechad;
						if(fechad != fechah) {
							htmlTabla += '<br>' + fechah;
						}
						htmlTabla +=
								'</td>' + 
								'<td align="center" style="border: thin solid black;">' +
									result[i].horario +
								'</td>' + 
								'<td align="center" style="border: thin solid black;">' +
									result[i].tiempo + ' horas' +
								'</td>' + 
								'<td align="center" style="border: thin solid black;">' +
									result[i].participantes +
								'</td>' +
								'<td align="center" style="border: thin solid black;">' +
									result[i].asistieron +
								'</td>' +
								'<td align="left" style="border: thin solid black;">' +
									'PERSONAL DE UNA O VARIAS LAS AREAS' +
								'</td>' +
								'<td width="1%"></td>' +
								'<td align="center" style="border: thin solid black;">';
									if(result[i].id_tipo==1) {
										htmlTabla += '*';
									}
									htmlTabla +=
								'</td>' +
								'<td align="center" style="border: thin solid black;">';
									if(result[i].id_tipo!=1) {
										htmlTabla += '*';
									}
									htmlTabla +=
								'</td>' +
								'<td align="center" style="border: thin solid black;">';
									if(result[i].participantes == result[i].evaluados) {
										htmlTabla += result[i].total_eval;
									}
									htmlTabla +=
								'</td>' +
							'</tr>';
						totPar += parseInt(result[i].participantes);
						totAsi += parseInt(result[i].asistieron);
						totCur += 1;
						if(!result[i].suspendido) {
							totEje += 1;
						}
						if(result[i].participantes == result[i].evaluados) {
							totEva += 1;
						}
						if(result[i].id_tipo==1) {
							totMed += 1;
						}
					};

					htmlTabla +=
						'<tr style="font-weight: bold; vertical-align: middle;">'+
							'<td style="border: 1px solid black; border-right: none" colspan="6">&nbsp;</td>'+
							'<td style="border: 1px solid black; border-left: none" align="center">TOTAL</td>'+
							'<td style="border: 1px solid black;" align="center">' +
								totPar +
							'</td>'+
							'<td style="border: 1px solid black;" align="center">' +
								totAsi +
							'</td>'+
							'<td style="border: 1px solid black;" align="center">&nbsp;</td>'+
							'<td width="1%"></td>' +
							'<td style="border: thin solid black;" align="center">' +
								totMed +
							'</td>'+
							'<td style="border: thin solid black;" align="center">' +
								(totCur-totMed)  +
							'</td>'+
						'</tr>'+
						'<tr><td colspan="10">&nbsp;</td></tr>' +
						'<tr>'+
							'<td colspan="2">TOTAL CURSOS PROGRAMADOS</td>'+
							'<td align="right">' +
								totCur +
							'</td>'+
						'</tr>'+
						'<tr>'+
							'<td colspan="2">TOTAL CURSOS EJECUTADOS</td>'+
							'<td align="right">' +
								totEje +
							'</td>'+
						'</tr>'+
						'<tr>'+
							'<td colspan="2">TOTAL CURSOS A MEDIR EFICACIA</td>'+
							'<td align="right">' +
								totMed +
							'</td>'+
						'</tr>'+
						'<tr>'+
							'<td colspan="2">TOTAL CURSOS EVALUADOS</td>'+
							'<td align="right">' +
								totEva +
							'</td>'+
						'</tr>'+
						'<tr><td colspan="10">&nbsp;</td></tr>' +
						'<tr><td colspan="10">&nbsp;</td></tr>' +
						'<tr>'+
							'<td align="center" colspan="10">ELABORADO POR</td>'+
						'</tr>'+
						'<tr>'+
							'<td align="center" colspan="10">JEFE DE TALENTO HUMANO</td>'+
						'</tr>' +
					'</table><br>';
				}
			});

			htmlTabla_exp = htmlTabla;

			jQuery('#resultado').html(htmlTabla);
			jQuery('#resultado').show('slow', function() {
				setTimeout("resizeContenido('resultado', " + ( jQuery('#TopeLista').position().top ) + ")", 100);
				jQuery('#resultado').removeClass('d-none');
			});
			jQuery('#cancelar').removeClass('d-none');
			jQuery('#exportar').removeClass('d-none');

		}) ;
	</script>
@endsection