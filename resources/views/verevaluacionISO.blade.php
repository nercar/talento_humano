@extends('layouts.app')

@section('content')
	{{ csrf_field() }}
	<input type="hidden" id="id_tipo"     value="{{ $curso->id_tipo }}">
	<input type="hidden" id="id_curso"    value="{{ $curso->id }}">
	<input type="hidden" id="id_empleado" value="{{ $empleado->id }}">
	<input type="hidden" id="id_dpto"	  value="{{ $departamento->id }}">
	<input type="hidden" id="totalvalor"  value="{{ $totalvalor }}">
	<div id="TopeLista"></div>
	<div class="container-fluid p-1 contenido bg-light" id="eval1" style="display: none; overflow-y: scroll">
		<table width="75%" 
			style="table-layout: fixed; margin: 0 auto; text-align: justify;">
			<tr class="text-center">
				<td colspan="2" rowspan="3"><img src="/images/logo.gif"></td>
				<td colspan="14" style="border: 1px solid; font-weight: bold;">
					MEDICIÓN DE LA EFICACIA DEL ADISTRAMIENTO de la Norma ISO 9001
				</td>
			</tr>
			<tr class="text-center">
				<td colspan="3" width="25%" style="border: 1px solid">Revisión No.:<br>0</td>
				<td colspan="4" width="25%" style="border: 1px solid">Fecha de Aprobación:<br>Junio de 2017</td>
				<td colspan="4" width="25%" style="border: 1px solid">No. de Identificación:<br>TH-FOR-017</td>
				<td colspan="3" width="25%" style="border: 1px solid">Página:<br>1 de 1</td>
			</tr>
			<tr class="text-center">
				<td colspan="14" style="border: 1px solid; font-weight: bold;">
					PROCEDIMIENTO PARA LA EJECUCIÓN DEL PROGRAMA DE ADIESTRAMIENTO
				</td>
			</tr>
			<tr><td colspan="16">&nbsp;</td></tr>
			<tr>
				<td colspan="5"  class="font-weight-bold">Nombre del Curso:</td>
				<td colspan="11" style="border-bottom: 1px solid;">{{ $curso->nombre }}</td>
			</tr>
			<tr>
				<td colspan="5"  class="font-weight-bold">Fecha del adiestramiento:</td>
				<td colspan="11" style="border-bottom: 1px solid;">{{ date('d-m-Y', strtotime($curso->fecha)) }}</td>
			</tr>
			<tr>
				<td colspan="5"  class="font-weight-bold">Nombre del Trabajador:</td>
				<td colspan="8" style="border-bottom: 1px solid;">
					{{ trim($empleado->nombre) . ' ' . trim($empleado->apellido) }}</td>
				<td colspan="1"  class="font-weight-bold text-right">C.I.:</td>
				<td colspan="2"  style="border-bottom: 1px solid;">{{ number_format($empleado->id, 0, '', '.') }}</td>
			</tr>
			<tr>
				<td colspan="5" class="font-weight-bold">Departamento:</td>
				<td colspan="4" style="border-bottom: 1px solid;">{{ $departamento->nombre }}</td>
				<td colspan="1" class="font-weight-bold">Cargo:</td>
				<td colspan="6" style="border-bottom: 1px solid;">&nbsp;{{ $cargo->nombre }}</td>
			</tr>
			<tr>
				<td colspan="5" class="font-weight-bold text-left">Tiempo del Adiestramiento:</td>
				<td colspan="5" style="border-bottom: 1px solid;">{{ $curso->tiempo }} (Horas)</td>
				<td colspan="2" class="font-weight-bold text-right">Interno:</td>
				<td colspan="1" style="border-bottom: 1px solid; text-align: center;">
					@if($curso->origen==1) &#10004; @endif
				</td>
				<td colspan="2" class="font-weight-bold text-right">Externo:</td>
				<td colspan="1" style="border-bottom: 1px solid; text-align: center;">
					@if($curso->origen==2) &#10004; @endif
				</td>
			</tr>
			<tr>
				<td colspan="5" class="font-weight-bold text-left">Persona encargada del adiestramiento:</td>
				<td colspan="11" style="border-bottom: 1px solid;">{{ $curso->orador }}</td>
			</tr>
			<tr><td colspan="16">&nbsp;</td></tr>
			<tr>
				<td colspan="16" class="text-center">
					<b>Marque con una (x) su respuesta tomando en consideración la siguiente escala</b>
				</td>
			</tr>
			<tr>
				<td colspan="2">&nbsp;</td>
				<td colspan="1" style="border: 1px solid; text-align: center;">1</td>
				<td colspan="5">Totalmente en desacuerdo</td>
				<td colspan="1">&nbsp;</td>
				<td colspan="1" style="border: 1px solid; text-align: center;">4</td>
				<td colspan="4">De acuerdo</td>
				<td colspan="2">&nbsp;</td>
			</tr>
			<tr>
				<td colspan="2">&nbsp;</td>
				<td colspan="1" style="border: 1px solid; text-align: center;">2</td>
				<td colspan="5">En desacuerdo</td>
				<td colspan="1">&nbsp;</td>
				<td colspan="1" style="border: 1px solid; text-align: center;">5</td>
				<td colspan="4">Totalmente de acuerdo</td>
				<td colspan="2">&nbsp;</td>
			</tr>
			<tr>
				<td colspan="2">&nbsp;</td>
				<td colspan="1" style="border: 1px solid; text-align: center;">3</td>
				<td colspan="5">Regularmente de acuerdo</td>
				<td colspan="1">&nbsp;</td>
				<td colspan="1">&nbsp;</td>
				<td colspan="4">&nbsp;</td>
				<td colspan="2">&nbsp;</td>
			</tr>
			<tr>
				<td colspan="11"></td>
				<td colspan="1" style="border: 1px solid; text-align: center; background-color: #B7BBBF;">
					<b>1</b>
				</td>
				<td colspan="1" style="border: 1px solid; text-align: center; background-color: #B7BBBF;">
					<b>2</b>
				</td>
				<td colspan="1" style="border: 1px solid; text-align: center; background-color: #B7BBBF;">
					<b>3</b>
				</td>
				<td colspan="1" style="border: 1px solid; text-align: center; background-color: #B7BBBF;">
					<b>4</b>
				</td>
				<td colspan="1" style="border: 1px solid; text-align: center; background-color: #B7BBBF;">
					<b>5</b>
				</td>
			</tr>
			@foreach ($respuestas as $respuesta)
				@php($totalvalor=0)
				@if($respuesta->id_pregunta==1)
					<tr>
						<td colspan="1" class="text-center" style="border-left: 1px solid; border-top: 1px solid;">
							<b>1.</b>
						</td>
						<td colspan="10" style="border-top: 1px solid; line-height: 1; max-height: 50" height="50">
							¿La información obtenida sobre la Norma ISO 9001:2015 le proporciona herramientas para
							comprender y conseguir los objetivos de calidad de la organización?
						</td>
						<td colspan="1" class="optiontdd">@if($respuesta->respuesta == 0  ) &#10004; @endif</td>
						<td colspan="1" class="optiontdd">@if($respuesta->respuesta == 25 ) &#10004; @endif</td>
						<td colspan="1" class="optiontdd">@if($respuesta->respuesta == 50 ) &#10004; @endif</td>
						<td colspan="1" class="optiontdd">@if($respuesta->respuesta == 75 ) &#10004; @endif</td>
						<td colspan="1" class="optiontdd">@if($respuesta->respuesta == 100) &#10004; @endif</td>
					</tr>
				@endif
				@if($respuesta->id_pregunta==2)
					<tr>
						<td colspan="1" class="text-center" style="border-left: 1px solid; border-top: 1px solid;">
							<b>2.</b>
						</td>
						<td colspan="10" style="border-top: 1px solid; line-height: 1; max-height: 50" height="50">
							Como resultado de la formación, ¿puede identificar los lineamientos de la política de
							calidad y en consecuencia cumplirlos en su labor diaria
						</td>
						<td colspan="1" class="optiontdd">@if($respuesta->respuesta == 0  ) &#10004; @endif</td>
						<td colspan="1" class="optiontdd">@if($respuesta->respuesta == 25 ) &#10004; @endif</td>
						<td colspan="1" class="optiontdd">@if($respuesta->respuesta == 50 ) &#10004; @endif</td>
						<td colspan="1" class="optiontdd">@if($respuesta->respuesta == 75 ) &#10004; @endif</td>
						<td colspan="1" class="optiontdd">@if($respuesta->respuesta == 100) &#10004; @endif</td>
					</tr>
				@endif
				@if($respuesta->id_pregunta==3)
					<tr>
						<td colspan="1" class="text-center" style="border-left: 1px solid; border-top: 1px solid;">
							<b>3.</b>
						</td>
						<td colspan="10" style="border-top: 1px solid; line-height: 1; max-height: 50" height="50">
							De acuerdo a los conocimientos adquiridos en el curso, ¿puede evaluar y reconocer su
							contribución al desempeño del Sistema de Gestión de Calidad?
						</td>
						<td colspan="1" class="optiontdd">@if($respuesta->respuesta == 0  ) &#10004; @endif</td>
						<td colspan="1" class="optiontdd">@if($respuesta->respuesta == 25 ) &#10004; @endif</td>
						<td colspan="1" class="optiontdd">@if($respuesta->respuesta == 50 ) &#10004; @endif</td>
						<td colspan="1" class="optiontdd">@if($respuesta->respuesta == 75 ) &#10004; @endif</td>
						<td colspan="1" class="optiontdd">@if($respuesta->respuesta == 100) &#10004; @endif</td>
					</tr>
				@endif
				@if($respuesta->id_pregunta==4)
					<tr>
						<td colspan="1" class="text-center" style="border-left: 1px solid; border-top: 1px solid;">
							<b>4.</b>
						</td>
						<td colspan="10" style="border-top: 1px solid; line-height: 1; max-height: 50" height="50">
							¿Ha identificado las oportunidades de mejora necesarias en el Sistema de gestión de
							Calidad y puesto en práctica algunas acciones para lograr satisfacer las necesidades
							del cliente y mejorar así su actuación?
						</td>
						<td colspan="1" class="optiontdd">@if($respuesta->respuesta == 0  ) &#10004; @endif</td>
						<td colspan="1" class="optiontdd">@if($respuesta->respuesta == 25 ) &#10004; @endif</td>
						<td colspan="1" class="optiontdd">@if($respuesta->respuesta == 50 ) &#10004; @endif</td>
						<td colspan="1" class="optiontdd">@if($respuesta->respuesta == 75 ) &#10004; @endif</td>
						<td colspan="1" class="optiontdd">@if($respuesta->respuesta == 100) &#10004; @endif</td>
					</tr>
				@endif
				@if($respuesta->id_pregunta==5)
					<tr>
						<td colspan="1" class="text-center"
							style="border-left: 1px solid; border-top: 1px solid; border-bottom: 1px solid;">
							<b>5.</b>
						</td>
						<td colspan="10" style="border-top: 1px solid; line-height: 1; max-height: 50" height="50">
							¿Cómo resultado de la formación, ha incrementado su nivel de motivación en el trabajo que desarrolla?
						</td>
						<td colspan="1" class="optiontdd">@if($respuesta->respuesta == 0  ) &#10004; @endif</td>
						<td colspan="1" class="optiontdd">@if($respuesta->respuesta == 25 ) &#10004; @endif</td>
						<td colspan="1" class="optiontdd">@if($respuesta->respuesta == 50 ) &#10004; @endif</td>
						<td colspan="1" class="optiontdd">@if($respuesta->respuesta == 75 ) &#10004; @endif</td>
						<td colspan="1" class="optiontdd">@if($respuesta->respuesta == 100) &#10004; @endif</td>
					</tr>
				@endif
				@if($respuesta->id_pregunta==6)
					<tr>
						<td colspan="1" class="text-center"
							style="border-left: 1px solid; border-top: 1px solid; border-bottom: 1px solid;">
							<b>6.</b>
						</td>
						<td colspan="10" style="border-top: 1px solid; border-bottom: 1px solid; line-height: 1; max-height: 50" height="50">
							¿Considera que la formación recibida ha contribuido directamente o
							indirectamente a mejorar el nivel de satisfacción del cliente?
						</td>
						<td colspan="1" class="optiontdd">@if($respuesta->respuesta == 0  ) &#10004; @endif</td>
						<td colspan="1" class="optiontdd">@if($respuesta->respuesta == 25 ) &#10004; @endif</td>
						<td colspan="1" class="optiontdd">@if($respuesta->respuesta == 50 ) &#10004; @endif</td>
						<td colspan="1" class="optiontdd">@if($respuesta->respuesta == 75 ) &#10004; @endif</td>
						<td colspan="1" class="optiontdd">@if($respuesta->respuesta == 100) &#10004; @endif</td>
					</tr>
				@endif				
			@endforeach
			<tr id="rvalor" class="d-none">
				<td colspan="5"></td>
				<td colspan="6"
					style="text-align: right; line-height: 1; margin: 0px; padding: 0px;
					border-left: 2px solid; border-bottom: 2px solid; border-right: 1px solid;">
					<span style="font-size: 10px;">(Sólo para ser llenado por Talento Humano)</span>&nbsp;<br>
					<b>TOTAL</b>&nbsp;
				</td>
				<td colspan="5" style="border-bottom: 2px solid; border-right: 2px solid; text-align: center;">
					<div id="totalV" class="font-weight-bold font-italic text-center"></div>
				</td>
			</tr>
			<tr><td colspan="16">&nbsp;</td></tr>
			<tr><td colspan="16">&nbsp;</td></tr>
			<tr>
				<td colspan="1">&nbsp;</td>
				<td colspan="5" style="border-bottom: 1px solid;">&nbsp;</td>
				<td colspan="2">&nbsp;</td>
				<td colspan="2">&nbsp;</td>
				<td colspan="5" style="border-bottom: 1px solid;">&nbsp;</td>
				<td colspan="1">&nbsp;</td>
			</tr>
			<tr>
				<td colspan="1">&nbsp;</td>
				<td colspan="5" class="text-center">Firma del trabajador</td>
				<td colspan="2">&nbsp;</td>
				<td colspan="2">&nbsp;</td>
				<td colspan="5" class="text-center">Firma del supervisor inmediato</td>
				<td colspan="1">&nbsp;</td>
			</tr>
			<tr>
				<td colspan="1">&nbsp;</td>
				<td colspan="5" class="text-center">
					Fecha: <div id="fecha1" class="d-inline" style="text-decoration: underline;"></div>
				</td>
				<td colspan="2">&nbsp;</td>
				<td colspan="2">&nbsp;</td>
				<td colspan="5" class="text-center">
					Fecha: <div id="fecha2" class="d-inline" style="text-decoration: underline;"></div>
				</td>
				<td colspan="1">&nbsp;</td>
			</tr>
			<tr><td colspan="16">&nbsp;</td></tr>
			<tr>
				<td colspan="16" class="text-right">
					<button type="button" class="btn btn-success" id="cerrarEval">Cerrar</button>
				</td>
			</tr>
		</table>
	</div>

	<script>
		jQuery('document').ready(function(){
			setTimeout('resizeTables()', 100);
			var fecha = new Date();
			fecha = fecha.getDate() + "-" + (fecha.getMonth() +1) + "-" + fecha.getFullYear()
			jQuery('#fecha1').html(fecha);
			jQuery('#fecha2').html(fecha);
			var valor = jQuery('#totalvalor').val();
			if(valor>1) {
				jQuery('#totalV').html(valor);
				jQuery('#rvalor').removeClass('d-none');
			}
		});

		jQuery(window).resize(function(){
			setTimeout('resizeTables()', 100);
		});

		jQuery('#cerrarEval').click(function(e){
			e.preventDefault();
			history.back();
		});

		function resizeTables() {
			jQuery('#eval1').css('height' , (window.innerHeight) - jQuery('#TopeLista').position().top - 3.55 + 'px');
			jQuery('#eval1').css('display', 'block');
		};
	</script>
@endsection