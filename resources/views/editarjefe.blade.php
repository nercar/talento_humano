<div id="ModalEditar" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="ModalEditarLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered">
		<div class="modal-content">
			<div class="modal-header bg-info pt-1 pb-1">		
				<h4 class="modal-title" id="ModalEditarLabel">Editar jefe</h4>
			</div>
			<form action="" method="" name="form_editar">
				{{ csrf_field() }}<input type="hidden" id="id_jefe">
				<div class="modal-body">			 
					<label for="nombre_editar"><b>Nombre del cargo de jefe</b></label>
					<input type="text" id="nombre_editar" name="nombre_editar" class="form-control"
						placeholder="Nombre del cargo" value="{{ old('nombre_editar') }}">
					<label for="jefe_editar"><b>Nombre del jefe</b></label>
					<input type="text" id="jefe_editar" autocomplete="ON" name="jefe_editar" class="form-control"
						placeholder="Nombre del jefe" value="{{ old('jefe_editar') }}">
					<label for="email_editar"><b>Correo Electrónico</b></label>
					<input type="email" id="email_editar" autocomplete="ON" name="email_editar" class="form-control"
						placeholder="usuario@dominio.net" value="{{ old('email_editar') }}">
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
		jQuery('#id_jefe').val(datat.data('tid'));
		jQuery('#nombre_editar').val(jQuery('#cargo' +jQuery('#id_jefe').val())[0].innerHTML.trim());
		jQuery('#jefe_editar'  ).val(jQuery('#nombre'+jQuery('#id_jefe').val())[0].innerHTML.trim());
		jQuery('#email_editar' ).val(jQuery('#correo'+jQuery('#id_jefe').val())[0].innerHTML.trim());
	});

	jQuery(document).ready(function(){
		jQuery('#ajaxSubmitEditar').click(function(e){
			e.preventDefault();
			jQuery.ajaxSetup({ headers: { 'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content') } });
			jQuery.ajax({
				url: "{{ url('/editarJefe') }}" + "/" + jQuery('#id_jefe').val(),
				method: "post",
				data: {
					nombre_editar: jQuery('#nombre_editar').val(),
					jefe_editar:   jQuery('#jefe_editar'  ).val(),
					email_editar:  jQuery('#email_editar' ).val(),
				},
				success: function(result){
					jQuery('#cargo'+jQuery('#id_jefe').val())[0].innerHTML =
						jQuery('#nombre_editar').val().trim();
					jQuery('#nombre'+jQuery('#id_jefe').val())[0].innerHTML =
						jQuery('#jefe_editar').val().trim();
					jQuery('#correo'+jQuery('#id_jefe').val())[0].innerHTML =
						jQuery('#email_editar').val().trim();
					jQuery('#cerrar_edit').click();
				}
			});
		});
	});
</script>