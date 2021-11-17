@extends('layouts.app')

@section('content')
	<input type="hidden" id="opcionact" value="">
	<div class="container-fluid col-xl-12 col-md-12 col-12 p-0 m-0 bg-dark">
		<table class="table p-0 m-0">
			<tr class="p-0">
				<td class="pl-1 pr-1 pt-1 pb-0 border-0">
					<h6>Estadísticas del Adiestramiento Realizado
						<span class="badge badge-warning" id="txtopcion">
							Medición de la eficacia del Adiestramiento
						</span>
					</h6>
				</td>
			</tr>
		</table>
	</div>
	<div class="row col-xl-12 col-md-12 col-12 pb-2" id="opciones">
		<div class="col-xl-3 col-md-3 col-3 p-1">
			<button id="btn_medicion" 
				style="border-top-left-radius: 25px; border-bottom-right-radius: 25px" 
				class="btn-outline-dark h-100 w-100 active"
				onclick="cambiar('medicion', this.innerText );">
				<div><img src="/images/medeficad.png" height="64px;" style="float: right;"></div>
				Medición de la eficacia del Adiestramiento
			</button>
		</div>
		<div class="col-xl-3 col-md-3 col-3 p-1">
			<button id="btn_personal" 
				style="border-top-right-radius: 25px; border-bottom-left-radius: 25px" 
				class="btn-outline-dark h-100 w-100"
				onclick="cambiar('personal', this.innerText );">
				<div><img src="/images/personalad.png" height="64px;" style="float: right;"></div>
				Personal Adiestrado en un Período
			</button>
		</div>
		<div class="col-xl-3 col-md-3 col-3 p-1">
			<button id="btn_cumplimiento" 
				style="border-top-left-radius: 25px; border-bottom-right-radius: 25px" 
				class="btn-outline-dark h-100 w-100"
				onclick="cambiar('cumplimiento', this.innerText );">
				<div><img src="/images/cumplan.png" height="64px;" style="float: right;"></div>
				Cumplimiento de la Programacion de Adiestramiento
			</button>
		</div>
		<div class="col-xl-3 col-md-3 col-3 p-1">
			<button id="btn_resultados" 
				style="border-top-right-radius: 25px; border-bottom-left-radius: 25px" 
				class="btn-outline-dark h-100 w-100"
				onclick="cambiar('resultados', this.innerText );">
				<div><img src="/images/resultados.png" height="64px;" style="float: right;"></div>
				Resultados de la Evaluación del Adiestramiento
			</button>
		</div>
	</div>
	<div id="fechas" class="container-fluid bg-dark text-light pt-0 pb-0 mt-0 mb-0">
		<table style="table-layout: fixed;" width="100%">
			<tr>
				<td width="30%" class="border-0">
					Seleccione el Trimestre y Año:
				</td>
				<td width="20%" class="border-0">
					<select class="form-control form-control-sm" id="trimestre">
						<option value="1" >Trimestre I</option>
						<option value="4" >Trimestre II</option>
						<option value="7" >Trimestre III</option>
						<option value="10">Trimestre IV</option>
					</select>
				</td>
				<td width="15%" class="border-0">
					<select class="form-control form-control-sm" id="anios"></select>
				</td>
				<td width="35%">
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
	<div class="row contenido col-xl-12 col-md-12 col-12 pt-2 d-none" id="resultado">
		<div align="center"><img src="/images/loading.gif"></div>
	</div>


	<script>
		jQuery('document').ready(function() {
			var html_indicador = '';
			var html_indicador_exp = '';
			jQuery('#opcionact').val('medicion');
			jQuery('#nombre_archivo').val('medicion.xls');
			cargarAnios();
		});

		jQuery(window).resize(function() {
			setTimeout("resizeContenido('resultado', " + ( jQuery('#TopeLista').position().top ) + ")", 100);
		});

		jQuery('#generar').click(function() {
			jQuery('#opciones').hide('slow', function() {
				switch(jQuery('#opcionact').val()) {
					// Generar indicadores
					case 'medicion':
						crearTablamedicion();
						break;
					case 'personal':
						crearTablapersonal();
						break;
					case 'cumplimiento':
						crearTablacumplimiento();
						break;
					case 'resultados':
						crearTablaresultados();
						break;
					// end case
				}
			});
			jQuery('#cancelar').removeClass('d-none');
			jQuery('#exportar').removeClass('d-none');
			jQuery('#generar' ).addClass('d-none');
			jQuery('#resultado').removeClass('d-none');
		});

		jQuery('#cancelar').click(function() {
			jQuery('#opciones').removeClass('d-none');
			jQuery('#resultado').addClass('d-none');
			jQuery('#resultado').html('<div align="center"><img src="/images/loading.gif"></div>');
			jQuery('#opciones').show('slow');
			jQuery('#generar').removeClass('d-none');
			jQuery('#cancelar').addClass('d-none');
			jQuery('#exportar').addClass('d-none');
		});

		jQuery('#exportar').click(function() {
			jQuery("#datos_a_enviar").val( jQuery("<div>").append( html_indicador_exp ).html());
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
			jQuery('#resultado').css('height', (window.innerHeight)-jQuery('#TopeLista').position().top-10+'px');
			jQuery('#resultado').css('display', 'block');
		};

		function cambiar(opcionact, texto) {
			if(opcionact!=jQuery('#opcionact').val()) {
				jQuery('#btn_'+jQuery('#opcionact').val()).removeClass('active');
				jQuery('#opcionact').val(opcionact);
				jQuery('#btn_'+opcionact).addClass('active');
				jQuery('#txtopcion')[0].innerHTML = texto;
				jQuery('#nombre_archivo').val(opcionact + '.xls');
			}
		}

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

		function crearTablamedicion() {
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
			
			var html_indicador = '<div align="center"><img src="/images/loading.gif"></div>';

			jQuery.ajaxSetup({ headers: { 'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content') } });
			jQuery.ajax({
				url: '/indicadoresmedicion\/' + trimIni + "/" + trimFin + "/" + triAnio,
				method: "get",
				async: false,
				success: function(result) {
					html_indicador =
						'<table width="75%" align="center" id="medicion" class="table-bordered">' +
							'<tr>' +
								'<td style="background-color: #D7DAE1; font-weight: bold;" ' + 
								' colspan="3" align="center">' +
									'INDICADORES DE GESTIÓN</td>' +
							'</tr>' +
							'<tr>' +
								'<td style="background-color: #D7DAE1; font-weight: bold;" ' + 
								' colspan="3" align="center">' +
									'MEDICIÓN DE LA EFICACIA DEL ADIESTRAMIENTO</td>' +
							'</tr>' +
							'<tr height="10px"><td colspan="3"></td></tr>' +
							'<tr>' +
								'<td style="background-color: #D7DAE1; " colspan="3" id="per_medicion">' + txtPMed + '</td>' +
							'</tr>' +
							'<tr height="10px"><td colspan="3"></td></tr>' +
							'<tr>' +
								'<td style="background-color: #D7DAE1; " colspan="2" width="90%">TOTAL CURSOS PROGRAMADOS</td>' +
								'<td style="background-color: #D7DAE1; " width="10%" align="right">' + result.totPrg +
								'</td>' +
							'</tr>' +
							'<tr height="10px"><td colspan="3"></td></tr>' +
							'<tr>' +
								'<td style="background-color: #D7DAE1; " colspan="2" width="90%">CURSOS SUSPENDIDOS</td>' +
								'<td style="background-color: #D7DAE1; " width="10%" align="right">' + result.totSus +
								'</td>' +
							'</tr>' +
							'<tr>' +
								'<td style="background-color: #D7DAE1; " colspan="2" width="90%">TOTAL CURSOS EJECUTADOS</td>' +
								'<td style="background-color: #D7DAE1; " width="10%" align="right">' + result.totEje +
								'</td>' +
							'</tr>' +
							'<tr height="10px"><td colspan="3"></td></tr>' +
							'<tr>' +
								'<td style="background-color: #D7DAE1; " colspan="2" width="90%">CURSOS DE SEGURIDAD OCUPACIONAL/INDUCCIÓN</td>' +
								'<td style="background-color: #D7DAE1; " width="10%" align="right">' + result.totOtr +
								'</td>' +
							'</tr>' +
							'<tr>' +
								'<td style="background-color: #D7DAE1; " colspan="2" width="90%" id="total_iso_med">' +
									'TOTAL CURSOS A MEDIR EFICACIA DE ADIESTRAMIENTO EN EL ' + txtTiso +
								'</td>' +
								'<td style="background-color: #D7DAE1; " width="10%" align="right">' + result.totIso +
								'</td>' +
							'</tr>' +
							'<tr height="10px"><td colspan="3"></td></tr>' +
							'<tr>' +
								'<td style="background-color: #D7DAE1; " colspan="3" id="cur_sgte_trim">' + 
									"NÚMERO DE CURSOS A MEDIR EFICACIA ADIESTRAMIENTO EN EL " +
									txttSgt + " AÑO " + anioSel +
								'</td>' +
							'</tr>';
					}
			});

			jQuery.ajax({
				url: '/api/cursosxmedicion\/' + trimIni + "/" + trimFin + "/" + triAnio,
				method: "get",
				async: false,
				success: function(result) {
					for (i=0; i<result.length; ++i) {
						html_indicador +=
								'<tr>'+
									'<td width="5%" align="right">' + (parseInt(i)+1) + '-</td>' + 
									'<td colspan="2">' + result[i].nombre + 
										'<sub> [' + result[i].id + '] </sub>' +
										'<sub> (' + convertDate(result[i].fecha_desde) + ')</sub>' + 
										'<sup> (' + result[i].participantes + ')</sup>' +
									'</td>' +
								'</tr>';
					}
				}
			});

			anioSel = jQuery('#anios').val()

			if(trimSel==0) {
				jQuery("#trimestre").prop("selectedIndex", jQuery('#trimestre > option').length - 1);
				var trimAnt = jQuery('#trimestre').val()
				anioSel = parseInt(triAnio) - 1;
			} else {
				jQuery("#trimestre").prop("selectedIndex", trimSel-1);
				var trimAnt = jQuery('#trimestre').val();
			}

			var txttAnt = jQuery('select[id="trimestre"] option:selected').text().toUpperCase();
			jQuery("#trimestre").prop("selectedIndex", trimSel);
			var totiEval = 0;
			var totgEval = 0;

			jQuery.ajax({
				url: '/api/cursosxmedir\/' + trimAnt + "/" + (parseInt(trimAnt)+2) + "/" + triAnio,
				method: "get",
				async: false,
				success: function(result) {
					html_indicador +=
						'<tr height="10px"><td colspan="3"></td></tr>' +
						'<tr>' +
							'<td style="background-color: #D7DAE1; " colspan="3" id="cur_pend_trim">' +
								'CURSOS DEL ' + txttAnt + ' AÑO ' + anioSel +
								' PENDIENTES PARA REALIZAR MEDICION</td>' +
						'</tr>';
					for (i=0; i<result.length; ++i) {
						html_indicador +=
								'<tr>'+
									'<td style="font-weight: bold;" width="5%" align="right">' +
										(parseInt(i)+1) +
									'-</td>' + 
									'<td style="font-weight: bold;" width="85%">' +
										result[i].nombre +
										'<sub> [' + result[i].id + '] </sub>' +
										'<sub> (' + convertDate(result[i].fecha_desde) + ')</sub>' +
									'</td>'+
									'<td width="10%"></td>' +
								'</tr>'+
								'<tr>' +
									'<td width="5%"  align="right"></td>' +
									'<td>PUNTAJE OPTIMO 500 * No. DE PARTICIPANTES'+
										'<sup>(' + result[i].participantes + ')</sup>' +
									'</td>' +
									'<td  align="right">' +
										(parseInt(result[i].participantes)*500).toLocaleString() +
									'</td>' +
								'</tr>' +
								'<tr>' +
									'<td width="5%"  align="right"></td>' +
									'<td>PUNTAJE OBTENIDO</td>' +
									'<td  align="right">';

						if(result[i].total_eval>0) {
							html_indicador += result[i].total_eval.toLocaleString()
						} else {
							html_indicador += 0
						};

						html_indicador +=
									'</td>' +
								'</tr>' +
								'<tr>' +
									'<td style="font-weight: bold;" align="right" colspan="2">RESULTADO</td>' +
									'<td align="right">';

						if(result[i].total_eval>0) {
							html_indicador += ( (result[i].total_eval*100)/
											   (parseInt(result[i].participantes)*500) ).toFixed(2) + '%';
							totgEval = totgEval + (parseInt(result[i].participantes)*500);
							totiEval = totiEval + result[i].total_eval;
						} else {
							html_indicador += '0%';
						};

						html_indicador +=
									'</td>' +
								'</tr>';
					}
				}
			});

			html_indicador +=
				'<tr>' +
					'<td colspan="2" style="font-weight: bold;" align="right">' + 
						'EFICACIA DEL ADIESTRAMIENTO' + 
					'</td>' +
					'<td style="font-weight: bold;" align="right">';

			if(totiEval>0) {
				html_indicador += ((totiEval * 100) / totgEval).toFixed(2) + '%';
			} else {
				html_indicador += '0%';
			};
			
			html_indicador +=
					'</td>' +
				'</tr></table><br>';

			html_indicador_exp = html_indicador;

			jQuery('#resultado').html(html_indicador);
			jQuery('#resultado').show('slow', function() {
				setTimeout("resizeContenido('resultado', " + ( jQuery('#TopeLista').position().top ) + ")", 100);
			});
		}

		function crearTablapersonal() {
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
			
			var html_indicador = '<div align="center"><img src="/images/loading.gif"></div>';

			jQuery.ajaxSetup({ headers: { 'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content') } });
			jQuery.ajax({
				url: '/indicadorespersonal\/' + trimIni + "/" + trimFin + "/" + triAnio,
				method: "get",
				async: false,
				success: function(result) {
					html_indicador =
						'<table width="75%" align="center" id="personal" class="table-bordered">' +
							'<tr>' +
								'<td style="background-color: #D7DAE1; font-weight: bold;" ' + 
								' colspan="3" align="center">' +
									'INDICADORES DE GESTIÓN</td>' +
							'</tr>' +
							'<tr>' +
								'<td style="background-color: #D7DAE1; font-weight: bold;" ' + 
								' colspan="3" align="center">' +
									'PERSONAL ADIESTRADO EN UN PERIODO</td>' +
							'</tr>' +
							'<tr height="10px"><td colspan="3"></td></tr>' +
							'<tr>' +
								'<td colspan="3" id="per_medicion" style="font-weight: bold;">' +
									txtPMed +
								'</td>' +
							'</tr>' +
							'<tr height="10px"><td colspan="3"></td></tr>' +
							'<tr style="background-color: #D7DAE1; font-weight: bold;">' +
								'<td colspan="2" width="90%">' +
									'NUMERO DE TRABAJADORES PLANIFICADOS PARA ADIESTRAMIENTO</td>' +
								'<td width="10%" align="right">' +
									result.totPla +
								'</td>' +
							'</tr>' +
							'<tr height="10px"><td colspan="3"></td></tr>' +
							'<tr>' +
								'<td width="2%"></td>' + 
								'<td width="88%">' +
									'NUMERO DE TRABAJADORES ADIESTRADOS</td>' +
								'<td width="10%" align="right" style="font-weight: bold;">' +
									result.totAdi +
								'</td>' +
							'</tr>' +
							'<tr>' +
								'<td width="2%"></td>' + 
								'<td width="88%">' +
									'TOTAL PERSONAL NO ADIESTRADO</td>' +
								'<td width="10%" align="right" style="font-weight: bold;">' +
									result.totNoa +
								'</td>' +
							'</tr>' +
							'<tr height="10px"><td colspan="3"></td></tr>' +
							'<tr style="background-color: #D7DAE1; font-weight: bold;">' +
								'<td colspan="2" width="90%">' +
									'PORCENTAJE DE PERSONAL ADIESTRADO</td>' +
								'<td width="10%" align="right">' +
									result.porAdi + "%" +
								'</td>' +
							'</tr></table><br>';
					}
			});

			html_indicador_exp = html_indicador;

			jQuery('#resultado').html(html_indicador);
			jQuery('#resultado').show('slow', function() {
				setTimeout("resizeContenido('resultado', " + ( jQuery('#TopeLista').position().top ) + ")", 100);
			});
		}

		function crearTablacumplimiento() {
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
			
			var html_indicador = '<div align="center"><img src="/images/loading.gif"></div>';

			jQuery.ajaxSetup({ headers: { 'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content') } });
			jQuery.ajax({
				url: '/indicadorescumplimiento\/' + trimIni + "/" + trimFin + "/" + triAnio,
				method: "get",
				async: false,
				success: function(result) {
					html_indicador =
						'<table width="75%" align="center" id="cumplimiento" class="table-bordered">' +
							'<tr>' +
								'<td style="background-color: #D7DAE1; font-weight: bold;" ' + 
								' colspan="3" align="center">' +
									'INDICADORES DE GESTIÓN</td>' +
							'</tr>' +
							'<tr>' +
								'<td style="background-color: #D7DAE1; font-weight: bold;" ' + 
								' colspan="3" align="center">' +
									'CUMPLIMIENTO DE LA PROGRAMACION TRIMESTRAL DE ADIESTRAMIENTO</td>' +
							'</tr>' +
							'<tr height="10px"><td colspan="3"></td></tr>' +
							'<tr>' +
								'<td colspan="3" id="per_medicion" style="font-weight: bold;">' +
									txtPMed +
								'</td>' +
							'</tr>' +
							'<tr height="10px"><td colspan="3"></td></tr>' +
							'<tr style="background-color: #D7DAE1; font-weight: bold;">' +
								'<td colspan="2" width="90%">' +
									'TOTAL CURSOS PROGRAMADOS EN UN TRIMESTRE</td>' +
								'<td width="10%" align="right">' +
									result.totPro +
								'</td>' +
							'</tr>' +
							'<tr height="10px"><td colspan="3"></td></tr>' +
							'<tr>' +
								'<td width="2%"></td>' + 
								'<td width="88%">' +
									'TOTAL CURSOS EJECUTADOS</td>' +
								'<td width="10%" align="right" style="font-weight: bold;">' +
									result.totEje +
								'</td>' +
							'</tr>' +
							'<tr>' +
								'<td width="2%"></td>' + 
								'<td width="88%">' +
									'TOTAL CURSOS SUSPENDIDOS</td>' +
								'<td width="10%" align="right" style="font-weight: bold;">' +
									result.totSus +
								'</td>' +
							'</tr>' +
							'<tr height="10px"><td colspan="3"></td></tr>' +
							'<tr style="background-color: #D7DAE1; font-weight: bold;">' +
								'<td colspan="2" width="90%">' +
									'PORCENTAJE DE CUMPLIMIENTO DEL PLAN</td>' +
								'<td width="10%" align="right">' +
									result.porCum + "%" +
								'</td>' +
							'</tr></table><br>';
					}
			});

			html_indicador_exp = html_indicador;

			jQuery('#resultado').html(html_indicador);
			jQuery('#resultado').show('slow', function() {
				setTimeout("resizeContenido('resultado', " + ( jQuery('#TopeLista').position().top ) + ")", 100);
			});
		}

		function crearTablaresultados() {
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
			
			var html_indicador = '<div align="center"><img src="/images/loading.gif"></div>';

			jQuery.ajaxSetup({ headers: { 'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content') } });
			jQuery.ajax({
				url: '/indicadoresresultados\/' + trimIni + "/" + trimFin + "/" + triAnio,
				method: "get",
				async: false,
				success: function(result) {
					html_indicador =
						'<table width="75%" align="center" id="cumplimiento" class="table-bordered">' +
							'<tr>' +
								'<td style="background-color: #D7DAE1; font-weight: bold;" ' + 
								' colspan="7" align="center">' +
									'INDICADORES DE GESTIÓN</td>' +
							'</tr>' +
							'<tr>' +
								'<td style="background-color: #D7DAE1; font-weight: bold;" ' + 
								' colspan="7" align="center">' +
									'PERSONAL ADIESTRADO EN EL ' + txtPMed +
								'</td>' +
							'</tr>' +
							'<tr height="10px"><td colspan="7"></td></tr>' +
							'<tr align="center">' +
								'<td width="28%" style="background-color: #D7DAE1; font-weight: bold;">' +
									'DEPARTAMENTO' +
								'</td>' +
								'<td width="12%" style="background-color: #D7DAE1; font-weight: bold;">' +
									'TOTAL' +
								'</td>' +
								'<td width="12%" style="background-color: #D7DAE1; font-weight: bold;">' +
									'PERSONAL<br>EVALUADO' +
								'</td>' +
								'<td width="12%" style="background-color: #D7DAE1; font-weight: bold;">' +
									'FALTAN<br>POR EVALUAR' +
								'</td>' +
								'<td width="12%" style="background-color: #D7DAE1; font-weight: bold;">' +
									'EN<br>VACACIONES' +
								'</td>' +
								'<td width="12%" style="background-color: #D7DAE1; font-weight: bold;">' +
									'EN<br>REPOSO' +
								'</td>' +
								'<td width="12%" style="background-color: #D7DAE1; font-weight: bold;">' +
									'RENUNCIA' +
								'</td>' +
							'</tr>';
					var empresa = '';
					var totemp = 0;
					var evaemp = 0;
					var repemp = 0;
					var renemp = 0;
					var vacemp = 0;
					for (i=0; i<result.length; ++i) {
						html_indicador +=
								'<tr>'+
									'<td width="28%" align="left">' +
										result[i].departamento +
									'</td>' + 
									'<td width="12%" align="right">' +
										result[i].total +
									'</td>' + 
									'<td width="12%" align="right">' +
										result[i].evaluados +
									'</td>' + 
									'<td width="12%" align="right">' +
										parseInt(result[i].total-result[i].evaluados) +
									'</td>' + 
									'<td width="12%" align="right">' +
										result[i].reposos +
									'</td>' + 
									'<td width="12%" align="right">' +
										result[i].renuncias +
									'</td>' + 
									'<td width="12%" align="right">' +
										result[i].vacaciones +
									'</td>' + 									
								'</tr>';
						if(result[i].empresa!='' && result[i].empresa!=empresa && empresa!=''){
							html_indicador+='<tr>' + 
									'<td align="left" width="28%" style="background-color: #D7DAE1;' +
										'font-weight: bold;">' +
											result[i].empresa.toUpperCase() +
									'</td>' +
									'<td align="right" width="12%" style="background-color: #D7DAE1;' +
										'font-weight: bold;">' +
											totemp +
									'</td>' +
									'<td align="right" width="12%" style="background-color: #D7DAE1;' +
										'font-weight: bold;">' +
											evaemp +
									'</td>' +
									'<td align="right" width="12%" style="background-color: #D7DAE1;' +
										'font-weight: bold;">' +
											parseInt(totemp - evaemp) +
									'</td>' +
									'<td align="right" width="12%" style="background-color: #D7DAE1;' +
										'font-weight: bold;">' +
											repemp +
									'</td>' +
									'<td align="right" width="12%" style="background-color: #D7DAE1;' +
										'font-weight: bold;">' +
											renemp +
									'</td>' +
									'<td align="right" width="12%" style="background-color: #D7DAE1;' +
										'font-weight: bold;">' +
											vacemp +
									'</td>' +
								'</tr>';
							totemp = 0;
							evaemp = 0;
							repemp = 0;
							renemp = 0;
							vacemp = 0;
						}
						empresa = result[i].empresa;
						totemp += parseInt(result[i].total);
						evaemp += parseInt(result[i].evaluados);
						repemp += parseInt(result[i].reposos);
						renemp += parseInt(result[i].renuncias);
						vacemp += parseInt(result[i].vacaciones);
					}

					html_indicador+='<tr>' + 
							'<td align="left" width="28%" style="background-color: #D7DAE1;' +
								'font-weight: bold;">' +
									empresa.toUpperCase() +
							'</td>' +
							'<td align="right" width="12%" style="background-color: #D7DAE1;' +
								'font-weight: bold;">' +
									totemp +
							'</td>' +
							'<td align="right" width="12%" style="background-color: #D7DAE1;' +
								'font-weight: bold;">' +
									evaemp +
							'</td>' +
							'<td align="right" width="12%" style="background-color: #D7DAE1;' +
								'font-weight: bold;">' +
									parseInt(totemp - evaemp) +
							'</td>' +
							'<td align="right" width="12%" style="background-color: #D7DAE1;' +
								'font-weight: bold;">' +
									repemp +
							'</td>' +
							'<td align="right" width="12%" style="background-color: #D7DAE1;' +
								'font-weight: bold;">' +
									renemp +
							'</td>' +
							'<td align="right" width="12%" style="background-color: #D7DAE1;' +
								'font-weight: bold;">' +
									vacemp +
							'</td>' +
						'</tr>';

					html_indicador += '</table><br>';
				}
			});

			html_indicador_exp = html_indicador;

			jQuery('#resultado').html(html_indicador);
			jQuery('#resultado').show('slow', function() {
				setTimeout("resizeContenido('resultado', " + ( jQuery('#TopeLista').position().top ) + ")", 100);
			});
		}
	</script>
@endsection