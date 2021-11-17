<div id="ModalVista" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="ModalVistaLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered modal-lg">
		<div class="modal-content">
			<div class="modal-header bg-info pt-1 pb-1">		
				<h4 class="modal-title m-0 p-0" id="ModalVistaLabel">Lista de Participantes al Adiestramiento<br>
					<span id="badgecurso" data-toggle="tooltip" class="badge badge-light" 
						style="cursor: default; font-size: small">
					</span>
				</h4>
			</div>
			<form action="" method="" name="form_editar">
				{{ csrf_field() }}<input type="hidden" id="id_curso"><input type="hidden" id="id_dpto">
				<div class="modal-body p-0 m-0">
					<div id="TopeLista"></div>
					<div class="cuerpo" id="lstpart">
					</div>
				</div>
				<div class="modal-footer alert-info pt-1 pb-1">
					<button type="close" class="btn btn-info" data-dismiss="modal" id="cerrar_edit">Cerrar</button>
				</div>
			</form>
		</div>
	</div>
</div>

<style>
	.cuerpo {
		overflow-y: auto;
		overflow-x: hidden;
		height: 1px;
		margin: 0px;
		padding: 0px;
		display: none;
	}
</style>

<script>
	jQuery('#ModalVista').on('show.bs.modal', function(){
		jQuery('#lstpart').html('<div class="text-center"><br><br><br><br><img src="images/loading.gif" alt=""></div>');
	});

	jQuery('#ModalVista').on('shown.bs.modal', function(e){
		var datat = jQuery(e.relatedTarget);
		jQuery('#id_curso').val(datat.data('cid'));
		if(datat.data('did')!=null) jQuery('#id_dpto').val(datat.data('did'));
		if(jQuery('#nombre'+jQuery('#id_curso').val())[0].innerHTML.trim().length > 120) {
			jQuery('#badgecurso')[0].innerHTML =
				jQuery('#nombre'+jQuery('#id_curso').val())[0].innerHTML.trim().substr(0,120) + '(...)';
			jQuery('#badgecurso')[0].title = jQuery('#nombre'+jQuery('#id_curso').val())[0].innerHTML.trim();
		} else {
			jQuery('#badgecurso')[0].innerHTML = jQuery('#nombre'+jQuery('#id_curso').val())[0].innerHTML.trim();
			jQuery('#badgecurso')[0].title = '';
		}
		personalInscrito();
		jQuery('#lstpart').css('height', ((parent.innerHeight)/2.5)-jQuery('#TopeLista').position().top+'px');
		jQuery('#lstpart').css('display', 'block');
	});

	function personalInscrito() {
		var idcurso = jQuery('#id_curso').val();
		var empresa = '';
		var departamento = '';
		var url = '/api/personalinscrito\/' + idcurso;
		if(jQuery('#id_dpto').val()!='') url += '\/' + jQuery('#id_dpto').val()
		jQuery.get(url, function(data) {
			html_listemp = '<table id="listpart" class="table-striped">';
			for (i=0; i<data.length; ++i) {
				if(data[i].empresa!=empresa){
					html_listemp += '<th colspan="3" class="badge-primary p-1 m-1" style="font-size: 13px;">';
					html_listemp += toTitleCase(data[i].empresa);
					html_listemp += '<th>';
					empresa = data[i].empresa;
				}
				if(data[i].departamento!=departamento) {
					
					if(data[i].empresa==empresa) html_listemp += '<tr>';
					html_listemp += '<th colspan="3"  class="badge-success p-1 m-1" style="font-size: 13px;">';
					html_listemp += toTitleCase(data[i].departamento) + ' ';
					if(data[i].reenviado != null) {
						fecha = data[i].reenviado.split('-');
						html_listemp += '<span class="badge badge-warning">correo reenviado el ';
						html_listemp += fecha[2] + '-' + fecha[1] + '-' + fecha[0];
						html_listemp += ' - env&iacute;o No.: ' + data[i].intentos;
						html_listemp += '</span>'
					}
					html_listemp += '<th>';
					if(data[i].empresa==empresa) html_listemp += '</tr>';
					departamento = data[i].departamento;
				}
				html_listemp += '<tr style="font-size: 14px;">';
				html_listemp += '<td width = "45%" class="flex-nowrap p-1 m-1">';
				html_listemp += toTitleCase(data[i].nomemp + ' ' + data[i].apeemp);
				html_listemp += '</td><td width = "30%" class="flex-nowrap p-0 m-0">'
				html_listemp += toTitleCase(data[i].nomcar);
				html_listemp += '</td><td width = "25%" class="flex-nowrap p-0 m-0">'
				if(data[i].evaluado) {
					if(data[i].total_eval>1)
						html_listemp += '(&#10004;)Evaluado con ' + data[i].total_eval + '/25';
					else
						html_listemp += '(&#10004;)Evaluado (no aplica)';
				}
				html_listemp += '</td></tr>';
			}
			html_listemp += '</table>';
			jQuery('#lstpart').html(html_listemp);
		});
	}; 
</script>