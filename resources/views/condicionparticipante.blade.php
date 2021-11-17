<div id="ModalCondicion" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="ModalCondicionLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered">
		<div class="modal-content">
			<div class="modal-header bg-info">		
				<h4 class="modal-title" id="ModalCondicionLabel">
					Condición Participante
				</h4>
			</div>
			<div class="alert alert-danger" id="errores_condicion"
				style="display:none"></div>   
			<form action="" method="" name="form_condicion">
				{{ csrf_field() }}
				<input type="hidden" id="id_curso">
				<input type="hidden" id="id_empleado">
				<div class="modal-body">			 
					<b>Nombre del Curso</b>
					<input type="text" id="nombre_condicion" name="nombre_condicion"
							class="form-control txtLabel text-left" disabled readonly>
					<b>Nombre del Participante</b>
					<input type="text" id="nombre_participante" name="nombre_participante"
							class="form-control txtLabel text-left" disabled readonly>
					<b>Por cuál motivo no se puede evaluar</b>
					<select name="condicion" id="select_condicion" class="form-control form-control-sm">
						<option value="0">Seleccione el Motivo</option>
						<option value="Vacaciones">Vacaciones</option>
						<option value="Reposo">Reposo</option>
						<option value="Renuncia">Renuncia</option>
						<option value="">Quitar Motivo</option>
					</select>
				</div>
				<div class="modal-footer alert-info">
					<div class="align-middle text-center text-warning">!! Todos los Campos son <b>OBLIGATORIOS</b> ¡¡</div>
					<button type="close" class="btn btn-info" data-dismiss="modal" id="cerrarcondicion">Cerrar</button>
					<button type="button" class="btn btn-success" id="ajaxSubmitcondicion">Guardar Cambios</button>
				</div>
			</form>
		</div>
	</div>
</div>

<script>
	jQuery('#ModalCondicion').on('shown.bs.modal', function(e){
		var datat = jQuery(e.relatedTarget);
		jQuery('#id_curso').val(datat.data('tid'));
		jQuery('#id_empleado').val(datat.data('eid'));
		jQuery('#nombre_condicion').val(jQuery('#badge')[0].innerHTML.trim());
		jQuery('#nombre_participante').val(jQuery('#nombre'+datat.data('eid'))[0].innerHTML.trim());
		if(jQuery('#selcon'+datat.data('eid'))[0].innerHTML.trim()!='') {
			jQuery('#select_condicion').val(jQuery('#selcon'+datat.data('eid'))[0].innerHTML.trim());		
		} else {
			jQuery('#select_condicion').val(0);
		}
		jQuery('#nombre_condicion').select();
	});

	jQuery(document).ready(function(){	
		jQuery('#ajaxSubmitcondicion').click(function(e){
			console.log("'" + jQuery('#select_condicion').val() + "'");
			if(jQuery('#select_condicion').val()!='0') {
				e.preventDefault();
				jQuery.ajaxSetup({ headers: { 'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content') } });
				jQuery.ajax({
					url: "{{ url('/condicionparticipante') }}",
					method: "post",
					data: {
						id_curso:			jQuery('#id_curso').val(),
						id_empleado:		jQuery('#id_empleado').val(),
						select_condicion:	jQuery('#select_condicion').val(),
					},
					success: function(){
						id_emp = jQuery('#id_empleado').val()
						id_cur = jQuery('#id_curso').val()
						if(jQuery('#select_condicion').val()!='') {
							jQuery('#r'+jQuery('#id_empleado').val()).addClass('edo_suspendido');
							jQuery('#lnkeval'+id_emp).attr("href", "#");
							jQuery('#imgeval'+id_emp).removeClass('img_btn');
							jQuery('#imgeval'+id_emp).addClass('img_btnd');
						} else {
							jQuery('#r'+jQuery('#id_empleado').val()).removeClass('edo_suspendido');
							jQuery('#lnkeval'+id_emp).attr("href", "/evaluarcurso/"+id_cur+"/"+id_emp);
							jQuery('#imgeval'+id_emp).addClass('img_btn');
							jQuery('#imgeval'+id_emp).removeClass('img_btnd');
						}
						jQuery('#selcon'+jQuery('#id_empleado').val()).addClass('badge badge-warning');
						jQuery('#selcon'+jQuery('#id_empleado').val())[0].innerHTML = jQuery('#select_condicion').val()
						jQuery('#cerrarcondicion').click();
					}
				});
			} else {
				alert('Debe seleccionar una razón del porque\nno se evalúa al participante');
				jQuery('#select_condicion').select();
			}
		});
	});
</script>