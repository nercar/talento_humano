@extends('layouts.app')

@section('content')
	<input type="hidden" id="trainings" value="{{ count($cursos) }}">
	<input type="hidden" id="tipo_actual" value="">
	<div class="container-fluid col-xl-12 col-md-12 col-12 p-1 card-title bg-dark">
		<table class="table p-0 m-0">
			<tr class="p-0">
				<td width="44%" class="pl-1 pr-1 pt-1 pb-0 border-0">
					<h6>Cursos Pendientes por Enviar
						<span class="badge badge-warning ba" id="badge"></span>
					</h6>
				</td>
				<td width="10%" class="pt-1 pb-0 pl-0 pr-0 border-0 text-right"><h6>Filtrar por</h6></td>
				<td width="10%" class="pl-1 pr-1 pt-1 pb-0 border-0">
					<ul class="nav nav-pills">
						<li class="nav-item dropdown">
							<a class="btn btn-outline-light dropdown dropdown-toggle form-control-sm pt-1"
								data-toggle="dropdown" href="#">Tipo
							</a>
							<div class="dropdown-menu">
								<a class="dropdown-item
									@if (!isset($values))
										active bg-dark
									@endif"
									href="#" onclick="menutype('')">--- Todos los Tipos ---</a>
									@foreach ($tipos as $tipo)
										<a class="dropdown-item
											@if (isset($values) and $values == $tipo->id)
												active
											@endif"
											href="#" onclick="menutype('{{ $tipo->nombre }}')">
											{{ $tipo->nombre }}
										</a>
									@endforeach
							</div>
						</li>
					</ul>
				</td>
				<td width="23%" class="pl-1 pr-1 pt-1 pb-0 border-0">
					<input type="text" name="name" placeholder="Por nombre del curso" class="form-control form-control-sm"
						data-toggle="tooltip" title="Ingrese parte/todo el nombre del curso" id="filtroCadena">
				</td>
				<td width="13%" class="pl-1 pr-1 pt-1 pb-0 border-0">
					<input type="text" name="date" placeholder="Fecha curso" class="form-control form-control-sm"
					data-toggle="tooltip" title="Ingrese parte/toda la fecha del curso" id="filtroFecha">
				</td>
			</tr>
		</table>
	</div>
	<div class="container-fluid col-lg-12 col-md-12 col-12 text-light bg-dark border border-info">
		<table class="table mt-0 mb-0">
			<tr>
				<td width = "5%"  class="border-0 p-0 m-0 ">
					ID
				</td>
				<td width = "45%" class="border-0 p-0 m-0 text-center">
					Descripción del Adiestramiento
				</td>
				<td width = "8%" class="border-0 p-0 m-0 text-center">
					Envío el
				</td>
				<td width = "6%"  class="border-0 p-0 m-0 text-center">
					Días
				</td>
				<td width = "10%" class="border-0 p-0 m-0 text-center">
					Tipo de Curso
				</td>
				<td width = "10%" class="border-0 p-0 m-0 text-center">
					Participantes
				</td>
				<td width = "16%" class="border-0 p-0 m-0 text-center">
					Opciones
				</td>
			</tr>
		</table>
	</div>
	<div id="TopeLista"></div>
	<div class="text-center" id="listNone" style="display: none;">
		<h1>No hay elementos del tipo<br>{{ $texto }}</h1>
	</div>
	<div class="container-fluid p-0 contenido border border-info" id="listNew" style="display: none;">
		<table id="list" class="table table-striped table-hover"
			style="overflow-x: hidden; overflow-y: auto">
			@foreach ($cursos as $curso)
				<tr id="r{{ $curso->id }}" class="@if($curso->suspendido==1) edo_suspendido @endif">
					<input type="hidden" id="fechad{{ $curso->id }}"	value="{{ date('d-m-Y', strtotime($curso->fecha_desde)) }}">
					<input type="hidden" id="fechah{{ $curso->id }}"	value="{{ date('d-m-Y', strtotime($curso->fecha_hasta)) }}">
					<input type="hidden" id="origen{{ $curso->id }}"	value="{{ $curso->origen }}">
					<input type="hidden" id="horario{{ $curso->id }}"	value="{{ $curso->horario }}">
					<input type="hidden" id="tiempo{{ $curso->id }}"	value="{{ $curso->tiempo }}">
					<input type="hidden" id="tipo_m{{ $curso->id }}"	value="{{ $curso->tipo_medicion }}">
					<input type="hidden" id="entidad{{ $curso->id }}"	value="{{ $curso->entidad }}">
					<input type="hidden" id="orador{{ $curso->id }}"	value="{{ $curso->orador }}">
					<td width = "5%"  style="vertical-align: middle; line-height: 1.2; text-align: center;" id="id{{ $curso->id }}" 
						class="border border-primary border-top-0 border-left-0 border-right-0">
						{{ $curso->id }}
					</td>
					<td width = "45%" style="vertical-align: middle; line-height: 1.2; text-align: justify" id="nombre{{ $curso->id }}" 
						class="border border-primary border-top-0 border-left-0 border-right-0">
						{{ $curso->nombre }}
					</td>
					<td width = "8%" style="vertical-align: middle; line-height: 1.2; text-align: center;"
						class="border border-primary border-top-0 border-left-0 border-right-0">
						<input class="txtLabel @if($curso->suspendido==1) txtLabelSus @endif"
							readonly disabled size="10" id="envio{{ $curso->id }}"
							type="text" value="{{ date('d-m-Y', strtotime($curso->fecha.'+90 days')) }}">
					</td>
					<td width = "6%" style="vertical-align: middle; line-height: 1.2; text-align: center;"
						class="border border-primary border-top-0 border-left-0 border-right-0">
						<input class="txtLabel @if($curso->suspendido==1) txtLabelSus @endif"
							readonly disabled size="2" id="dias{{ $curso->id }}"
							type="text" value="<?php
								$fechahoy = strtotime(date('Y-m-d'));
								$fechacur = strtotime($curso->fecha_desde . "+90 days");
								echo intval((( ($fechahoy - $fechacur)/60 ) / 60 ) / 24); ?>">
					</td>
					<td width = "10%" style="vertical-align: middle; line-height: 1.2; text-align: center;"
						class="border border-primary border-top-0 border-left-0 border-right-0">
						<input type="hidden" id="id_tipo{{ $curso->id }}" value="{{ $curso->id_tipo }}">
						<input class="txtLabel @if($curso->suspendido==1) txtLabelSus @endif"
							readonly disabled size="10" id="tipo{{ $curso->id }}"
							type="text" value="{{ $curso->tipo }}">
					</td>
					<td width = "10%" style="vertical-align: middle; line-height: 1.2; text-align: center;"
						class="border border-primary border-top-0 border-left-0 border-right-0">
						<div class="@if($curso->participantes>0)
								badge badge-success font-weight-normal @endif"
							 style="@if($curso->participantes>0) font-size: 14px @endif">
							 <input class="txtLabel @if($curso->suspendido==1) txtLabelSus @endif"
								type="text" readonly disabled size="1" id="cantp{{ $curso->id }}"
								value="{{ $curso->participantes }}">
						</div>
					</td>
					<td width = "16%" style="text-align: right; vertical-align: middle;"
						class="border pl-0 ml-0 mr-0 pr-2 border-primary border-top-0 border-left-0 border-right-0">
						<div style="font-size: 18px" class="d-inline p-1 d-none">
							<a id="lnkadd{{ $curso->id }}"
								href="@if($curso->suspendido) # @else /participantescurso/e/{{ $curso->id }} @endif">
								<i id="imgadd{{ $curso->id }}"
									class="fas fa-users fa-lg @if($curso->suspendido) img_btnd @else img_btn @endif"
									title="Ver/Agregar Participantes"></i></a>
						</div>
						<div style="font-size: 18px" class="d-inline p-1">
							<a href="#" data-toggle="modal" data-target="#ModalEditar"
								id="edittraining" data-tid="{{ $curso->id }}">
								<i class="fas fa-pencil-alt fa-lg img_btn" title="Editar Curso"></i></a>
						</div>
						<div style="font-size: 18px; padding: 1px; display: @if($curso->suspendido) none @else inline @endif"
							id="susp{{ $curso->id }}">
							<a onclick="changeStatus('s', '{{ $curso->id }}')" href="#">
								<i class="fas fa-pause fa-lg img_btn" title="Suspender Curso"></i></a>
						</div>
						<div style="font-size: 18px; padding: 1px; display: @if(!$curso->suspendido) none @else inline @endif"
							id="resu{{ $curso->id }}">
							<a href="#" onclick="changeStatus('r', '{{ $curso->id }}')">
								<i class="fas fa-play fa-lg img_btn" title="Reactivar Curso"></i></a>
						</div>
					</td>
				</tr>
			@endforeach
		</table>
	</div>
	@include('editarcurso')

	<script>
		var divId = 'listNone';
		jQuery('document').ready(function(){
			jQuery('#filtroFecha').val('');
			jQuery('#filtroCadena').val('');
			if(jQuery('#trainings').val()!='') {
				document.getElementById('listNew').style.display = 'block';
				document.getElementById('listNone').style.display = 'none';
				divId = 'listNew';
			}
			jQuery('#badge')[0].innerHTML = '- Todos los Tipos';
			setTimeout("resizeContenido('" + divId + "', " + jQuery('#TopeLista').position().top + ")", 100);
		});

		jQuery(window).resize(function(){
			setTimeout("resizeContenido('" + divId + "', " + jQuery('#TopeLista').position().top + ")", 100);
		});

		jQuery('#filtroCadena,#filtroFecha').keydown(function(){
			vname = jQuery('#filtroCadena').val();
			vdate = jQuery('#filtroFecha').val();
		});

		jQuery('#filtroCadena,#filtroFecha').keyup(function(){
			if(jQuery('#filtroCadena').val() != vname) { if(jQuery('#trainings').val()>0) filterList(); }
			if(jQuery('#filtroFecha').val() != vdate) { if(jQuery('#trainings').val()>0) filterList(); }
		});

		function resizeTables() {
			jQuery('#listNew').css('height' , (parent.innerHeight) - jQuery('#TopeLista').position().top - 3.55 + 'px');
			jQuery('#listNone').css('height' , (parent.innerHeight) - jQuery('#TopeLista').position().top - 3.55 + 'px');
		};

		function menutype(v_type_id) {
			jQuery('#tipo_actual').val(v_type_id);
			if(jQuery('#tipo_actual').val()=='')
				jQuery('#badge')[0].innerHTML = '- Todos los Tipos';
			else
				jQuery('#badge')[0].innerHTML = '- ' + jQuery('#tipo_actual').val();
			filterList();
		}

		function filterList() {
			var rows = document.getElementById('list').getElementsByTagName('tr');
			var contName = jQuery('#filtroCadena').val().trim().toLowerCase();
			var contDate = jQuery('#filtroFecha').val().trim();
			var contType = jQuery('#tipo_actual').val().trim();

			document.getElementById('listNew').style.display = 'none';
			document.getElementById('listNone').style.display = 'block';

			for (i=0; i<=rows.length-1; i++)
				document.getElementById(rows[i].id).style.display = 'none';

			for (i=0; i<=rows.length-1; i++){
				var contIdnum = rows[i].cells[0].innerHTML.toLowerCase().trim(); 
				var contNameR = rows[i].cells[1].innerHTML.toLowerCase().trim();
				var contDateR = rows[i].cells[2].innerHTML.toLowerCase().trim();
				var contTypeR = jQuery('#tipo'+contIdnum).val();
				var show=0;
				var showL=false;

				if(contName.length>0 && contDate.length>0) {
					if(contNameR.indexOf(contName)>=0 && contDateR.indexOf(contDate)>=0) show=1;
					else show=2;
				};

				if(show==0 && contName.length>0 && contNameR.indexOf(contName)>=0) show=1;

				if(show==0 && contDate.length>0 && contDateR.indexOf(contDate)>=0) show=1;

				if(contName.length==0 && contDate.length==0) show=1;

				if(show==1) {
					if(contType!='') {
						if(contType == contTypeR)
							document.getElementById(rows[i].id).style.display = '';
					} else {
						document.getElementById(rows[i].id).style.display = '';
					}
					if(!showL) {
						document.getElementById('listNew').style.display = 'block';
						document.getElementById('listNone').style.display = 'none';
						showL=true;
					}

				}
			}
		};

		function changeStatus(v_action, idcurso) {
			var urlAction = '';
			switch(v_action) {
				//Suspender Curso
				case 's':
					urlAction = "{{ url('/suspendercurso') }}";
					break;
				//Reanudar Curso
				case 'r':
					urlAction = "{{ url('/resumircurso') }}";
					break;
				//Completar curso y pasar a pendientes por enviar
				case 'c':
					urlAction = "{{ url('/completarcurso') }}";
					break;
			}
			jQuery.ajaxSetup({ headers: { 'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content') } });
			jQuery.ajax({
				url: urlAction + "/" + idcurso,
				method: "post",
				data: { id: idcurso },
				success: function(result){
					switch(v_action) {
						//Suspender Curso
						case 's':
							jQuery('#susp' + idcurso).css('display', 'none');
							jQuery('#resu' + idcurso).css('display', 'inline');
							jQuery('#r' + idcurso).addClass('edo_suspendido');
							jQuery('#fecha' + idcurso).addClass('txtLabelSus');
							jQuery('#envio' + idcurso).addClass('txtLabelSus');
							jQuery('#dias' + idcurso).addClass('txtLabelSus');
							jQuery('#tipo' + idcurso).addClass('txtLabelSus');
							jQuery('#cantp' + idcurso).addClass('txtLabelSus');
							validarBotones(v_action, idcurso);
							break;
						//Reanudar Curso
						case 'r':
							jQuery('#susp' + idcurso).css('display', 'inline');
							jQuery('#resu' + idcurso).css('display', 'none');
							jQuery('#r' + idcurso).removeClass('edo_suspendido');
							jQuery('#fecha' + idcurso).removeClass('txtLabelSus');
							jQuery('#envio' + idcurso).removeClass('txtLabelSus');
							jQuery('#dias' + idcurso).removeClass('txtLabelSus');
							jQuery('#tipo' + idcurso).removeClass('txtLabelSus');
							jQuery('#cantp' + idcurso).removeClass('txtLabelSus');
							validarBotones(v_action, idcurso);
							break;
						//Completar curso y pasar a pendientes por enviar
						case 'c':
							jQuery('#r' + idcurso).hide("slow", function() {
								jQuery('#r' + idcurso).css('display', 'none');
							});
							break;
						//end swtich
					}
				}
			});
		};

		function validarBotones(v_action, idcurso){
			switch(v_action) {
				//Suspender Curso
				case 's':
					jQuery('#lnkadd' + idcurso).attr("href", "#");
					jQuery('#imgadd' + idcurso).removeClass('img_btn');
					jQuery('#imgadd' + idcurso).addClass('img_btnd');
					if(jQuery('#cantp' + idcurso).val()>0){
						jQuery('#lnkrdy' + idcurso).attr("onclick", "");
						jQuery('#imgrdy' + idcurso).removeClass('img_btn');
						jQuery('#imgrdy' + idcurso).addClass('img_btnd');
					}
					break;
				//Reanudar Curso
				case 'r':
					jQuery('#lnkadd' + idcurso).attr("href", "/participantescurso/e/" + idcurso);
					jQuery('#imgadd' + idcurso).removeClass('img_btnd');
					jQuery('#imgadd' + idcurso).addClass('img_btn');
					if(jQuery('#cantp' + idcurso).val()>0){
						jQuery('#lnkrdy' + idcurso).attr("onclick", "changeStatus('c', '" + idcurso + "')");
						jQuery('#imgrdy' + idcurso).removeClass('img_btnd');
						jQuery('#imgrdy' + idcurso).addClass('img_btn');
					}
					break;
				//end switch
			}
		}

		function difDias(fechacurso, idcurso){
			fechacurso = fechacurso.split("-");
			var fechahoy = new Date();
			var fechaenv = new Date(fechacurso[2], fechacurso[1]-1, fechacurso[0]);
			fechaenv.setDate(fechaenv.getDate() + 90);
			jQuery('#dias'+idcurso).val( parseInt((((fechahoy-fechaenv)/86400)/1000)) );
			var dia = fechaenv.getDate();
			var mes = (fechaenv.getMonth()+1);
			if(mes <= 9) mes = '0' + mes;
			var ano = fechaenv.getFullYear();
			jQuery('#envio'+idcurso).val( dia + '-' + mes + '-' + ano );
		}

		function enviar(idcurso) {
			jQuery.ajaxSetup({ headers: { 'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content') } });
			jQuery.ajax({
				url: "{{ url('/enviarcurso') }}" + "/" + idcurso,
				method: "post",
				data: { id: idcurso },
				success: function(result){
					jQuery('#r' + idcurso).hide("slow", function() {
						jQuery('#r' + idcurso).css('display', 'none');
					});
				}
			});
		}
	</script>
@endsection