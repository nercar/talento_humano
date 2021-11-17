<?php
	namespace App\Http\Controllers;
	use App\Tipo;
	$tipos = Tipo::where('activo', true)->get();
?>

<div id="ModalNuevo" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="ModalNuevoLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered" role="document">
		<div class="modal-content">
			<div class="modal-header bg-primary pt-1 pb-1">		
				<h4 class="modal-title" id="ModalNuevoLabel">Registrar Nuevo Adiestramiento</h4>
			</div>
			<div class="alert alert-danger" id="errores_nuevo" style="display:none"></div>   
			<form action="" method="" name="form_nuevo">
				{{ csrf_field() }}
				<div class="modal-body">			 
					<b>Nombre del Curso</b>
					<input type="text" id="nombre_nuevo" name="nombre_nuevo"
							class="form-control form-control-sm" placeholder="Nombre del curso" value="{{ old('nombre_nuevo') }}">
					<table>
						<tr>
							<td width="50%"><b>Fecha del Curso</b></td>
							<td width="3%"></td>
							<td width="30%"><b>Horario</b></td>
							<td width="3%"></td>
							<td width="15%"><b>Duración</b></td>
						</tr>
						<tr>
							<td>
								<div class="input-group input-daterange">
								<input type="text" id="fechad_nuevo" autocomplete="off" name="fechad_nuevo"
										class="date form-control form-control-sm" size="9" placeholder="dd-mm-aaaa"
										value="{{ old('fechad_nuevo') }}">
								<div class="input-group-addon bg-secondary">&nbsp;al&nbsp;</div>
									<input type="text" id="fechah_nuevo" autocomplete="off" name="fechah_nuevo"
										class="date form-control form-control-sm" size="9" placeholder="dd-mm-aaaa"
										value="{{ old('fechah_nuevo') }}">
								</div>
							</td>
							<td></td>
							<td>
								<input type="text" id="horario_nuevo" name="horario_nuevo"
									class="form-control form-control-sm" placeholder="8:00am-12:00pm"
									value="{{ old('horario_nuevo') }}">
							</td>
							<td></td>
							<td>
								<input type="text" id="tiempo_nuevo" name="tiempo_nuevo"
									class="form-control form-control-sm" placeholder="4.5"
									onkeydown="soloNumeros()" 
									value="{{ old('tiempo_nuevo') }}">
							</td>
						</tr>
					</table>
					<table class="w-100 p-0" style="table-layout: fixed;">
						<tr>
							<td width="52%"><b>Tipo de Curso</b></td>
							<td width="6%">&nbsp;</td>
							<td width="52%"><b>Origen:</b></td>
						</tr>
						<tr>
							<td width="52%">
								<select id="tipo_nuevo" name="tipo_nuevo" class="form-control form-control-sm">
									@foreach ($tipos as $tipo)
										<option value="{{ $tipo->id }}">{{ $tipo->nombre }}</option>
									@endforeach
								</select>
							</td>
							<td width="6%">&nbsp;</td>
							<td width="52%">
								<label style="cursor: pointer;">
									<input type="radio" id="r1_nuevo" value="1" checked
										name="origen_nuevo"> Interno</label>&nbsp;&nbsp;&nbsp;
								<label style="cursor: pointer;">
									<input type="radio" id="r2_nuevo" value="2"
										name="origen_nuevo"> Externo</label>
							</td>
						</tr>
					</table>
					<table class="w-100 p-0" style="table-layout: fixed;">
						<tr>
							<td width="100%"><b>Tipo de Medición a aplicar al Curso</b></td>
						</tr>
						<tr>
							<td width="100%">
								<label style="cursor: pointer; margin: 0px; padding: 0px;">
									<input type="radio" id="r1_tipo_m_nuevo" value="1" checked 
										name="tipo_m_nuevo"> Medición Eficacia Adiestramiento</label>
								<br>
								<label style="cursor: pointer; margin: 0px; padding: 0px;">
									<input type="radio" id="r2_tipo_m_nuevo" value="2"
										name="tipo_m_nuevo"> Medición Eficacia Adiestramiento de la Norma ISO 9001</label>
							</td>
						</tr>
					</table>
					<b>Entidad Didáctica</b>
					<input type="text" id="entidad_nuevo" name="entidad_nuevo" width="100%" 
							class="form-control form-control-sm" placeholder="Entidad que impartirá el adiestramiento"
							value="{{ old('entidad_nuevo') }}">
					<b>Instructor</b>
					<input type="text" id="orador_nuevo" name="orador_nuevo"
							class="form-control form-control-sm" placeholder="Nombre del instructor" value="{{ old('orador_nuevo') }}">
				</div>
				<div class="modal-footer alert-info pt-1 pb-1">
					<div class="align-middle text-center text-warning">!! Todos los Campos son <b>OBLIGATORIOS</b> ¡¡</div>
					<button type="button" class="btn btn-success" id="ajaxSubmitNuevo">Registrar</button>
					<button type="reset"  class="btn btn-primary">Limpiar</button>
					<button type="close"  class="btn btn-info" data-dismiss="modal" id="cerrar">Cerrar</button>
				</div>
			</form>
		</div>
	</div>
</div>

<script>
	jQuery('#ModalNuevo').on('hidden.bs.modal', function(){
		jQuery('#errores_nuevo').hide();
		jQuery('#nombre_nuevo').val('');
		jQuery('#fecha_nuevo').val('');
		jQuery('#tipo_nuevo').val(1);
		jQuery('#tiempo_nuevo').val('');
		document.getElementById('r1_nuevo').checked = true;
		document.getElementById('r2_nuevo').checked = false;
		document.getElementById('r1_tipo_m_nuevo').checked = true;
		document.getElementById('r2_tipo_m_nuevo').checked = false;
		jQuery('#orador_nuevo').val('');
		jQuery('#newTraining').removeClass('active');
		setTimeout("jQuery('#cont_ppal').focus()", 50);
	});

	jQuery('#ModalNuevo').on('shown.bs.modal', function(){
		jQuery('#nombre_nuevo').focus();
		jQuery('#newTraining').addClass('active');
	})

	jQuery(document).ready(function(){
		jQuery('#ajaxSubmitNuevo').click(function(e){
			e.preventDefault();
			jQuery.ajaxSetup({ headers: { 'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content') } });
			jQuery.ajax({
				url: "{{ url('/crearcurso') }}",
				method: "post",
				data: {
					nombre_nuevo : jQuery('#nombre_nuevo').val(),
					fechad_nuevo : jQuery('#fechad_nuevo').val(),
					fechah_nuevo : jQuery('#fechah_nuevo').val(),
					tipo_nuevo   : jQuery('#tipo_nuevo').val(),
					origen_nuevo : jQuery('input[name="origen_nuevo"]:checked').val(),
					tipo_m_nuevo : jQuery('input[name="tipo_m_nuevo"]:checked').val(),
					horario_nuevo: jQuery('#horario_nuevo').val(),
					tiempo_nuevo : jQuery('#tiempo_nuevo').val(),
					entidad_nuevo: jQuery('#entidad_nuevo').val(),
					orador_nuevo : jQuery('#orador_nuevo').val(),
				},
				success: function(result){
					if(result.errors_ne)
					{
						jQuery('#errores_nuevo').html('');
						jQuery('#errores_nuevo').append('<strong>Ups!</strong> Hubo algunos problemas con los datos.<br/>');
						jQuery.each(result.errors_ne, function(key, value){
							jQuery('#errores_nuevo').append('<li class="ml-5 mr-5">'+value+'</li>');
						});
						jQuery('#errores_nuevo').show();
					}
					else
					{
						jQuery('#errores_nuevo').hide();
						document.getElementById('cerrar').click();
						if (location.pathname >= '/cursosnuevos') {
							location.reload();
						}
					}
				}
			});
		});
	});
</script>