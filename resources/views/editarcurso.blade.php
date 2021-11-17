<?php
	namespace App\Http\Controllers;
	use App\Tipo;
	$tipos = Tipo::where('activo', true)->get();
?>

<div id="ModalEditar" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="ModalEditarLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered">
		<div class="modal-content">
			<div class="modal-header bg-info pt-1 pb-1">
				<h4 class="modal-title" id="ModalEditarLabel">Editar Adiestramiento</h4>
			</div>
			<div class="alert alert-danger" id="errores_editar" style="display:none"></div>   
			<form action="" method="" name="form_editar">
				{{ csrf_field() }}<input type="hidden" id="id_curso">
				<div class="modal-body">			 
					<b>Nombre del Curso</b>
					<input type="text" id="nombre_editar" name="nombre_editar"
							class="form-control form-control-sm" placeholder="Nombre del curso" value="{{ old('nombre_editar') }}">
					<table>
						<tr>
							<td width="50%"><b>Fecha del Curso</b></td>
							<td width="2%"></td>
							<td width="34%"><b>Horario</b></td>
							<td width="2%"></td>
							<td width="15%"><b>Duración</b></td>
						</tr>
						<tr>
							<td>
								<div class="input-group input-daterange">
								<input type="text" id="fechad_editar" autocomplete="off" name="fechad_editar"
										class="date form-control form-control-sm" size="9" placeholder="dd-mm-aaaa"
										value="{{ old('fechad_editar') }}">
								<div class="input-group-addon bg-secondary">&nbsp;al&nbsp;</div>
									<input type="text" id="fechah_editar" autocomplete="off" name="fechah_editar"
										class="date form-control form-control-sm" size="9" placeholder="dd-mm-aaaa"
										value="{{ old('fechah_editar') }}">
								</div>
							</td>
							<td></td>
							<td>
								<input type="text" id="horario_editar" name="horario_editar"
									class="form-control form-control-sm" placeholder="8:00am-12:00pm"
									value="{{ old('horario_editar') }}">
							</td>
							<td></td>
							<td>
								<input type="text" id="tiempo_editar" name="tiempo_editar"
									class="form-control form-control-sm" placeholder="4.5"
									onkeydown="soloNumeros()" 
									value="{{ old('tiempo_editar') }}">
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
								<select id="tipo_editar" name="tipo_editar" class="form-control form-control-sm">
									@foreach ($tipos as $tipo)
										<option value="{{ $tipo->id }}">{{ $tipo->nombre }}</option>
									@endforeach
								</select>
							</td>
							<td width="6%">&nbsp;</td>
							<td width="52%">
								<label style="cursor: pointer;">
									<input type="radio" id="r1_editar" value="1"
										name="origen_editar"> Interno</label>&nbsp;&nbsp;&nbsp;
								<label style="cursor: pointer;">
									<input type="radio" id="r2_editar" value="2"
										name="origen_editar"> Externo</label>
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
									<input type="radio" id="r1_tipo_m_editar" value="1" 
										name="tipo_m_editar"> Medición Eficacia Adiestramiento</label>
								<br>
								<label style="cursor: pointer; margin: 0px; padding: 0px;">
									<input type="radio" id="r2_tipo_m_editar" value="2"
										name="tipo_m_editar"> Medición Eficacia Adiestramiento de la Norma ISO 9001</label>
							</td>
						</tr>
					</table>
					<b>Entidad Didáctica</b>
					<input type="text" id="entidad_editar" name="entidad_editar" width="100%" 
							class="form-control form-control-sm" placeholder="Entidad que impartirá el adiestramiento"
							value="{{ old('entidad_editar') }}">
					<b>Instructor</b>
					<input type="text" id="orador_editar" name="orador_editar"
							class="form-control form-control-sm" placeholder="Nombre del instructor" value="{{ old('orador_editar') }}">
				</div>
				<div class="modal-footer alert-info pt-1 pb-1">
					<div class="align-middle text-center text-warning">!! Todos los Campos son <b>OBLIGATORIOS</b> ¡¡</div>
					<button type="button" class="btn btn-success" id="ajaxSubmitEditar">Guardar Cambios</button>
					<button type="close" class="btn btn-info" data-dismiss="modal" id="cerrar_edit">Cerrar</button>
				</div>
			</form>
		</div>
	</div>
</div>

<script>
	jQuery('#ModalEditar').on('shown.bs.modal', function(e){
		var datat = jQuery(e.relatedTarget);
		jQuery('#id_curso').val(datat.data('tid'));
		jQuery('#nombre_editar').val(jQuery('#nombre'+jQuery('#id_curso').val())[0].innerHTML.trim());
		jQuery('#fechad_editar').datepicker("setDate", jQuery('#fechad'+jQuery('#id_curso').val()).val());
		jQuery('#fechah_editar').datepicker("setDate", jQuery('#fechah'+jQuery('#id_curso').val()).val());
		jQuery('#tipo_editar').val(jQuery('#id_tipo'+jQuery('#id_curso').val()).val());
		if(jQuery('#origen'+jQuery('#id_curso').val()).val() == 1) {
			document.getElementById('r1_editar').checked = true;
			document.getElementById('r2_editar').checked = false;
		}
		if(jQuery('#origen'+jQuery('#id_curso').val()).val() == 2) {
			document.getElementById('r1_editar').checked = false;
			document.getElementById('r2_editar').checked = true;			
		}
		if(jQuery('#tipo_m'+jQuery('#id_curso').val()).val() == 1) {
			document.getElementById('r1_tipo_m_editar').checked = true;
			document.getElementById('r2_tipo_m_editar').checked = false;
		}
		if(jQuery('#tipo_m'+jQuery('#id_curso').val()).val() == 2) {
			document.getElementById('r1_tipo_m_editar').checked = false;
			document.getElementById('r2_tipo_m_editar').checked = true;			
		}
		jQuery('#horario_editar').val(jQuery('#horario'+jQuery('#id_curso').val()).val());
		jQuery('#tiempo_editar' ).val(jQuery('#tiempo' +jQuery('#id_curso').val()).val());
		jQuery('#entidad_editar').val(jQuery('#entidad'+jQuery('#id_curso').val()).val());
		jQuery('#orador_editar' ).val(jQuery('#orador' +jQuery('#id_curso').val()).val());
		jQuery('#nombre_editar' ).select();
	});

	jQuery('#ModalEditar').on('hidden.bs.modal', function () {
		jQuery('#errores_editar').hide();
	})

	jQuery(document).ready(function(){
		jQuery('#ajaxSubmitEditar').click(function(e){
			e.preventDefault();
			jQuery.ajaxSetup({ headers: { 'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content') } });
			jQuery.ajax({
				url: "{{ url('/editarcurso') }}" + "/" + jQuery('#id_curso').val(),
				method: "post",
				data: {
					nombre_editar : jQuery('#nombre_editar').val(),
					fechad_editar : jQuery('#fechad_editar').val(),
					fechah_editar : jQuery('#fechah_editar').val(),
					tipo_editar   : jQuery('#tipo_editar').val(),
					origen_editar : jQuery('input[name="origen_editar"]:checked').val(),
					horario_editar: jQuery('#horario_editar').val(),
					tiempo_editar : jQuery('#tiempo_editar').val(),
					tipo_m_editar : jQuery('input[name="tipo_m_editar"]:checked').val(),
					entidad_editar: jQuery('#entidad_editar').val(),
					orador_editar : jQuery('#orador_editar').val(),
				},
				success: function(result){
					if(result.errors_ed)
					{
						jQuery('#errores_editar').html('');
						jQuery('#errores_editar').append('<strong>Ups!</strong> Hubo algunos problemas con los datos.<br/>');
						jQuery.each(result.errors_ed, function(key, value){
							jQuery('#errores_editar').append('<li class="ml-5 mr-5">'+value+'</li>');
						});
						jQuery('#errores_editar').show();							
					}
					else
					{
						var nombre  = jQuery('#nombre'  + jQuery('#id_curso').val())[0].innerHTML.trim();
						var fechad  = jQuery('#fechad'  + jQuery('#id_curso').val()).val();
						var fechah  = jQuery('#fechah'  + jQuery('#id_curso').val()).val();
						var tipo    = jQuery('#tipo'    + jQuery('#id_curso').val()).val();
						var origen  = jQuery('#origen'  + jQuery('#id_curso').val()).val();
						var horario = jQuery('#horario' + jQuery('#id_curso').val()).val();
						var tiempo  = jQuery('#tiempo'  + jQuery('#id_curso').val()).val();
						var tipo_m  = jQuery('#tipo_m'  + jQuery('#id_curso').val()).val();
						var entidad = jQuery('#entidad' + jQuery('#id_curso').val()).val();
						var orador  = jQuery('#orador'  + jQuery('#id_curso').val()).val();

						if(jQuery('#nombre_editar').val() != nombre)
							jQuery('#nombre'+jQuery('#id_curso').val())[0].innerHTML=jQuery('#nombre_editar').val().trim();
						if(jQuery('#fechad_editar').val() != fechad)
							jQuery('#fechad'+jQuery('#id_curso').val()).val(jQuery('#fechad_editar').val().trim());
							//para actualizar los dias en cursos por enviar
							if ( document.getElementById('dias'+jQuery('#id_curso').val()) ){
								difDias(jQuery('#fechad_editar').val(), jQuery('#id_curso').val());
							}
						if(jQuery('#fechah_editar').val() != fechah)
							jQuery('#fechah'+jQuery('#id_curso').val()).val(jQuery('#fechah_editar').val().trim());
							//para actualizar los dias en cursos por enviar
							if ( document.getElementById('dias'+jQuery('#id_curso').val()) ){
								difDias(jQuery('#fechah_editar').val(), jQuery('#id_curso').val());
							}
						if(jQuery('#tipo_editar').val() != tipo) {
							jQuery('#tipo'+jQuery('#id_curso').val()).val(jQuery('#tipo_editar option:selected').text().trim());
							jQuery('#id_tipo'+jQuery('#id_curso').val() ).val(jQuery('#tipo_editar').val());
						}
						if(jQuery('#origen_editar').val() != origen)
							jQuery('#origen'+jQuery('#id_curso').val()).val(jQuery('input[name="origen_editar"]:checked').val());
						if(jQuery('#horario_editar').val() != horario)
							jQuery('#horario'+jQuery('#id_curso').val()).val(jQuery('#horario_editar').val().trim());
						if(jQuery('#tiempo_editar').val() != tiempo)
							jQuery('#tiempo'+jQuery('#id_curso').val()).val(jQuery('#tiempo_editar').val().trim());
						if(jQuery('#tipo_m_editar').val() != tipo_m)
							jQuery('#tipo_m'+jQuery('#id_curso').val()).val(jQuery('input[name="tipo_m_editar"]:checked').val());
						if(jQuery('#entidad_editar').val() != entidad)
							jQuery('#entidad'+jQuery('#id_curso').val()).val(jQuery('#entidad_editar').val().trim());
						if(jQuery('#orador_editar').val() != orador)
							jQuery('#orador'+jQuery('#id_curso').val()).val(jQuery('#orador_editar').val().trim());
						jQuery('#fecha'+jQuery('#id_curso').val()).text(
									'Desde: ' + jQuery('#fechad_editar').val().trim() +
							 '\n' + 'Hasta: ' + jQuery('#fechah_editar').val().trim());
						jQuery('#errores_editar').hide();
						jQuery('#cerrar_edit').click();
					}
				}
			});
		});
	});
</script>