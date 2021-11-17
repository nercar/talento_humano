@extends('layouts.app')

@section('content')
	{{ csrf_field() }}
	<input type="hidden" id="id_tipo"		value="{{ $curso->id_tipo }}">
	<input type="hidden" id="id_curso"		value="{{ $curso->id }}">
	<input type="hidden" id="id_empleado"	value="{{ $empleado->id }}">
	<input type="hidden" id="id_dpto"		value="{{ $departamento->id }}">
	<div id="TopeLista"></div>
	<div class="contenido bg-light" id="eval1" style="overflow-y: scroll">
		<table width="75%" 
			style="table-layout: fixed; margin: 0 auto; text-align: justify;">
			<tr class="text-center">
				<td colspan="2" rowspan="3"><img src="/images/logo.gif"></td>
				<td colspan="14" style="border: 1px solid; font-weight: bold;">
					MEDICIÓN DE LA EFICACIA DEL ADISTRAMIENTO
				</td>
			</tr>
			<tr class="text-center">
				<td colspan="3" width="25%" style="border: 1px solid">Revisión No.:<br>2</td>
				<td colspan="4" width="25%" style="border: 1px solid">Fecha de Aprobación:<br>Junio de 2016</td>
				<td colspan="4" width="25%" style="border: 1px solid">No. de Identificación:<br>TH-FOR-014</td>
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
				<td colspan="5" style="border-bottom: 1px solid;">{{ $departamento->nombre }}</td>
				<td colspan="1" class="font-weight-bold">Cargo:</td>
				<td colspan="5" style="border-bottom: 1px solid;">&nbsp;{{ $cargo->nombre }}</td>
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
				<td colspan="1" style="text-align: center;"><b>1.</b></td>
				<td colspan="15">
					Los conocimientos / habilidades adquiridas en el adiestramiento
					se aplican en el trabajo que desarrolla.
				</td>
			</tr>
			<tr>
				<td colspan="3"></td>
				<td colspan="1" class="btn-link text-dark text-right" style="cursor: pointer;" onclick="check('r1')">
					<b>Si</b>&nbsp;
				</td>
				<td colspan="1" class="optiontd" onclick="check('r1')">
					<input style="cursor: pointer;" type="radio" id="r1" value="1" name="r1">
				</td>
				<td colspan="1" class="btn-link text-dark" style="cursor: pointer;" onclick="check('r1')">
					&nbsp;Continúa
				</td>
				<td colspan="4"></td>
				<td colspan="1" class="btn-link text-dark text-right" style="cursor: pointer;" onclick="check('r2')">
					<b>No</b>&nbsp;
				</td>
				<td colspan="1" class="optiontd" onclick="check('r2')">
					<input style="cursor: pointer;" type="radio" id="r2" value="0" name="r1">
				</td>
				<td colspan="1" class="btn-link text-dark" style="cursor: pointer;" onclick="check('r2')">
					&nbsp;Fin
				</td>
				<td colspan="3"></td>
			</tr>
			<tr name="continuar" style="display: none;">
				<td colspan="1" style="text-align: center;"><b>2.</b></td>
				<td colspan="15">
					¿En cuáles tareas laborales aplica los conocimientos / hanilidades adquiridos?
				</td>
			</tr>
			<tr name="continuar" style="display: none;">
				<td colspan="1"></td>
				<td colspan="15">
					<textarea id="prg2" rows="2"
						style="text-align: justify; white-space: normal; line-height: 1; width: 100%">
					</textarea>
				</td>
			</tr>
			<tr name="continuar" style="display: none;">
				<td colspan="16" class="text-center">
					<b>Marque con una (x) su respuesta tomando en consideración la siguiente escala</b>
				</td>
			</tr>
			<tr name="continuar" style="display: none;">
				<td colspan="2">&nbsp;</td>
				<td colspan="1" style="border: 1px solid; text-align: center;">1</td>
				<td colspan="5">Totalmente en desacuerdo</td>
				<td colspan="1">&nbsp;</td>
				<td colspan="1" style="border: 1px solid; text-align: center;">4</td>
				<td colspan="4">De acuerdo</td>
				<td colspan="2">&nbsp;</td>
			</tr>
			<tr name="continuar" style="display: none;">
				<td colspan="2">&nbsp;</td>
				<td colspan="1" style="border: 1px solid; text-align: center;">2</td>
				<td colspan="5">En desacuerdo</td>
				<td colspan="1">&nbsp;</td>
				<td colspan="1" style="border: 1px solid; text-align: center;">5</td>
				<td colspan="4">Totalmente de acuerdo</td>
				<td colspan="2">&nbsp;</td>
			</tr>
			<tr name="continuar" style="display: none;">
				<td colspan="2">&nbsp;</td>
				<td colspan="1" style="border: 1px solid; text-align: center;">3</td>
				<td colspan="5">Regularmente de acuerdo</td>
				<td colspan="1">&nbsp;</td>
				<td colspan="1">&nbsp;</td>
				<td colspan="4">&nbsp;</td>
				<td colspan="2">&nbsp;</td>
			</tr>
			<tr name="continuar" style="display: none;">
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
			<tr name="continuar" style="display: none;">
				<td colspan="1" class="text-center" style="border-left: 1px solid; border-top: 1px solid;">
					<b>3.</b>
				</td>
				<td colspan="10" style="border-top: 1px solid; line-height: 1; max-height: 50" height="50">
					¿Cómo resultado de los conocimientos / habilidades adquiridos ha mejorado
					el tiempo de desarrollo de su trabajo (mayor rapidez, eficacia...)?
				</td>
				<td colspan="1" style="border: 1px solid; text-align: center; cursor: pointer;" class="optiontd" 
					onclick="check('r31')">
					<input style="cursor: pointer;" type="radio" id="r31" value="0" name="r3">
				</td>
				<td colspan="1" style="border: 1px solid; text-align: center; cursor: pointer;" class="optiontd" 
					onclick="check('r32')">
					<input style="cursor: pointer;" type="radio" id="r32" value="25" name="r3">
				</td>
				<td colspan="1" style="border: 1px solid; text-align: center; cursor: pointer;" class="optiontd" 
					onclick="check('r33')">
					<input style="cursor: pointer;" type="radio" id="r33" value="50" name="r3">
				</td>
				<td colspan="1" style="border: 1px solid; text-align: center; cursor: pointer;" class="optiontd" 
					onclick="check('r34')">
					<input style="cursor: pointer;" type="radio" id="r34" value="75" name="r3">
				</td>
				<td colspan="1" style="border: 1px solid; text-align: center; cursor: pointer;" class="optiontd" 
					onclick="check('r35')">
					<input style="cursor: pointer;" type="radio" id="r35" value="100" name="r3">
				</td>
			</tr>
			<tr name="continuar" style="display: none;">
				<td colspan="1" class="text-center" style="border-left: 1px solid; border-top: 1px solid;">
					<b>4.</b>
				</td>
				<td colspan="10" style="border-top: 1px solid; line-height: 1; max-height: 50" height="50">
					¿El trabajador demostró interés en el adiestramiento recibido?
				</td>
				<td colspan="1" style="border: 1px solid; text-align: center; cursor: pointer;" class="optiontd" 
					onclick="check('r41')">
					<input style="cursor: pointer;" type="radio" id="r41" value="0" name="r4">
				</td>
				<td colspan="1" style="border: 1px solid; text-align: center; cursor: pointer;" class="optiontd" 
					onclick="check('r42')">
					<input style="cursor: pointer;" type="radio" id="r42" value="25" name="r4">
				</td>
				<td colspan="1" style="border: 1px solid; text-align: center; cursor: pointer;" class="optiontd" 
					onclick="check('r43')">
					<input style="cursor: pointer;" type="radio" id="r43" value="50" name="r4">
				</td>
				<td colspan="1" style="border: 1px solid; text-align: center; cursor: pointer;" class="optiontd" 
					onclick="check('r44')">
					<input style="cursor: pointer;" type="radio" id="r44" value="75" name="r4">
				</td>
				<td colspan="1" style="border: 1px solid; text-align: center; cursor: pointer;" class="optiontd" 
					onclick="check('r45')">
					<input style="cursor: pointer;" type="radio" id="r45" value="100" name="r4">
				</td>
			</tr>
			<tr name="continuar" style="display: none;">
				<td colspan="1" class="text-center" style="border-left: 1px solid; border-top: 1px solid;">
					<b>5.</b>
				</td>
				<td colspan="10" style="border-top: 1px solid; line-height: 1; max-height: 50" height="50">
					¿Considera que la formación recibida ha incrementado su iniciativa en el
					trabajo que desarrolla?
				</td>
				<td colspan="1" style="border: 1px solid; text-align: center; cursor: pointer;" class="optiontd" 
					onclick="check('r51')">
					<input style="cursor: pointer;" type="radio" id="r51" value="0" name="r5">
				</td>
				<td colspan="1" style="border: 1px solid; text-align: center; cursor: pointer;" class="optiontd" 
					onclick="check('r52')">
					<input style="cursor: pointer;" type="radio" id="r52" value="25" name="r5">
				</td>
				<td colspan="1" style="border: 1px solid; text-align: center; cursor: pointer;" class="optiontd" 
					onclick="check('r53')">
					<input style="cursor: pointer;" type="radio" id="r53" value="50" name="r5">
				</td>
				<td colspan="1" style="border: 1px solid; text-align: center; cursor: pointer;" class="optiontd" 
					onclick="check('r54')">
					<input style="cursor: pointer;" type="radio" id="r54" value="75" name="r5">
				</td>
				<td colspan="1" style="border: 1px solid; text-align: center; cursor: pointer;" class="optiontd" 
					onclick="check('r55')">
					<input style="cursor: pointer;" type="radio" id="r55" value="100" name="r5">
				</td>
			</tr>
			<tr name="continuar" style="display: none;">
				<td colspan="1" class="text-center" style="border-left: 1px solid; border-top: 1px solid;">
					<b>6.</b>
				</td>
				<td colspan="10" style="border-top: 1px solid; line-height: 1; max-height: 50" height="50">
					¿Cómo resultado de la formación, ha incrementado su nivel de motivación
					en el trabajo que desarrolla?
				</td>
				<td colspan="1" style="border: 1px solid; text-align: center; cursor: pointer;" class="optiontd" 
					onclick="check('r61')">
					<input style="cursor: pointer;" type="radio" id="r61" value="0" name="r6">
				</td>
				<td colspan="1" style="border: 1px solid; text-align: center; cursor: pointer;" class="optiontd" 
					onclick="check('r62')">
					<input style="cursor: pointer;" type="radio" id="r62" value="25" name="r6">
				</td>
				<td colspan="1" style="border: 1px solid; text-align: center; cursor: pointer;" class="optiontd" 
					onclick="check('r63')">
					<input style="cursor: pointer;" type="radio" id="r63" value="50" name="r6">
				</td>
				<td colspan="1" style="border: 1px solid; text-align: center; cursor: pointer;" class="optiontd" 
					onclick="check('r64')">
					<input style="cursor: pointer;" type="radio" id="r64" value="75" name="r6">
				</td>
				<td colspan="1" style="border: 1px solid; text-align: center; cursor: pointer;" class="optiontd" 
					onclick="check('r65')">
					<input style="cursor: pointer;" type="radio" id="r65" value="100" name="r6">
				</td>
			</tr>
			<tr name="continuar" style="display: none;">
				<td colspan="1" class="text-center"
					style="border-left: 1px solid; border-top: 1px solid; border-bottom: 1px solid;">
					<b>7.</b>
				</td>
				<td colspan="10" style="border-top: 1px solid; border-bottom: 1px solid; line-height: 1; max-height: 50" height="50">
					¿Considera que la formación recibida ha contribuido directamente o
					indirectamente a mejorar el nivel de satisfacción del cliente?
				</td>
				<td colspan="1" style="border: 1px solid; text-align: center; cursor: pointer;" class="optiontd" 
					onclick="check('r71')">
					<input style="cursor: pointer;" type="radio" id="r71" value="0" name="r7">
				</td>
				<td colspan="1" style="border: 1px solid; text-align: center; cursor: pointer;" class="optiontd" 
					onclick="check('r72')">
					<input style="cursor: pointer;" type="radio" id="r72" value="25" name="r7">
				</td>
				<td colspan="1" style="border: 1px solid; text-align: center; cursor: pointer;" class="optiontd" 
					onclick="check('r73')">
					<input style="cursor: pointer;" type="radio" id="r73" value="50" name="r7">
				</td>
				<td colspan="1" style="border: 1px solid; text-align: center; cursor: pointer;" class="optiontd" 
					onclick="check('r74')">
					<input style="cursor: pointer;" type="radio" id="r74" value="75" name="r7">
				</td>
				<td colspan="1" style="border: 1px solid; text-align: center; cursor: pointer;" class="optiontd" 
					onclick="check('r75')">
					<input style="cursor: pointer;" type="radio" id="r75" value="100" name="r7">
				</td>
			</tr>
			<tr name="continuar" style="display: none;">
				<td colspan="5"></td>
				<td colspan="6"
					style="text-align: right; line-height: 1; margin: 0px; padding: 0px;
					border-left: 2px solid; border-bottom: 2px solid; border-right: 1px solid;">
					<span style="font-size: 10px;">(Sólo para ser llenado por Talento Humano)</span>&nbsp;<br>
					<b>TOTAL</b>&nbsp;
				</td>
				<td colspan="5" style="border-bottom: 2px solid; border-right: 2px solid; text-align: center;">
					<div id="totalV" class="txtLabel font-weight-bold font-italic">0</div>
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
				<td colspan="16" class="text-center">
					<button type="button" class="btn btn-warning" id="cerrarEval">Cancelar</button>
					<button type="button" class="btn btn-success" id="guardaEval">Guardar</button>
				</td>
			</tr>
		</table>
	</div>

	<script>
		jQuery('document').ready(function(){
			setTimeout("resizeContenido('eval1', " + jQuery('#TopeLista').position().top + ")", 100);
			limpiarEval();
			var fecha = new Date();
			fecha = fecha.getDate() + "-" + (fecha.getMonth() +1) + "-" + fecha.getFullYear()
			jQuery('#fecha1').html(fecha);
			jQuery('#fecha2').html(fecha);
			check('r1');
		});

		jQuery(window).resize(function(){
			setTimeout("resizeContenido('eval1', " + jQuery('#TopeLista').position().top + ")", 100);
		});

		jQuery('#cerrarEval').click(function(e){
			e.preventDefault();
			history.back();
		});

		jQuery('#guardaEval').click(function(e){
			e.preventDefault();
			var valida = validaResp();
			if(valida=='') {
				var prgArray = [jQuery('input[name="r1"]:checked').val()];
				if(jQuery('#r1').is(":checked")) {
					prgArray.push(jQuery('#prg2').val());
					for(i=1;i<=5;i++) {
						prgArray.push(jQuery('input[name="r'+parseInt(i+2)+'"]:checked').val());
					}
				}
				jQuery.ajaxSetup({ headers: { 'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content') } });
				jQuery.ajax({
					url: "{{ url('/guardarevaluacion') }}"+"/"+jQuery('#id_curso').val()+"/"+jQuery('#id_empleado').val(),
					method: "post",
					data: {
						fecha_eval:       jQuery('#fecha1').html(),
						id_tipo_eval:     jQuery('#id_tipo').val(),
						id_curso_eval:    jQuery('#id_curso').val(),
						id_empleado_eval: jQuery('#id_empleado').val(),
						arrayPrgs:        JSON.stringify(prgArray),
					},
					success: function(result){
						alert('Evaluación guardada');
						location.href = "/participantesporevaluar"
										+ "/" + jQuery('#id_curso').val()
										+ "/" + jQuery('#id_dpto').val();
					}
				});
			} else {
				alert(valida);
			}
		});

		function validaResp() {
			var msgprg2 = '';
			var msgprgs = '';
			var message = '';
			if(jQuery('#r1').is(":checked")) {
				if(jQuery('#prg2').val().length == 0) {
					msgprg2  = 'Debe responder la pregunta 2 e ingresar las\n'
					msgprg2 += 'tareas en las que aplican los conocimientos\n'
					msgprg2 += 'adquiridos.\n\n'
				}
				for(i=1;i<=5;i++) {
					val = jQuery('input[name="r'+parseInt(i+2)+'"]:checked').val()
					if(typeof val === "undefined") val = -1;
					if(val<0) msgprgs += ' ( ' + parseInt(i+2) + ' ) ';
				}
				if(msgprgs.length > 0) msgprgs = 'Debe indicar una respuesta para la(s) pregunta(s):\n' + msgprgs;
			}
			message = msgprg2 + msgprgs;
			return message;
		};

		function resizeTables() {
			jQuery('#eval1').css('height' , (window.innerHeight) - jQuery('#TopeLista').position().top - 3.55 + 'px');
			jQuery('#eval1').css('display', 'block');
		};

		function check(rcontrol) {
			jQuery('#'+rcontrol).prop('checked', true);
			if(rcontrol=='r1' || rcontrol=='r2') {
				jQuery("tr[name='continuar']").css('display', jQuery('#r1').is(":checked") ? '' : 'none');
				if(rcontrol=='r2') {
					limpiarEval();
					jQuery('#r2').prop('checked', true);
				}
			} else {
				var valor = 0;
				for(i=3;i<=7;i++) {
					if(jQuery("input[name='r" + i + "']").is(":checked")) {
						valor = valor + parseInt(jQuery("input[name='r" + i + "']:checked").val());
					}
				}
				jQuery('#totalV').html(valor);
			}
		}

		function limpiarEval() {
			jQuery('#r1').prop('checked', false);
			jQuery('#r2').prop('checked', false);
			for(i=3;i<=7;i++) {
				for(j=1;j<=5;j++){
					jQuery('#r'+i+j).prop('checked', false);
				}
			}
			jQuery('#totalV').val(0);
			jQuery('#prg2').val('');
		}
	</script>
@endsection