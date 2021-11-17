@extends('layouts.app')

@section('content')
	<input type="hidden" id="trainings" value="{{ count($cursos) }}">
	<input type="hidden" id="tipo_actual" value="">
	<div class="col-md-12 p-0 card-title bg-dark">
		<table class="table p-0 m-0" style="table-layout: fixed;">
			<tr>
				<td width="45%" class="p-1 border-0">
					<h6>Lista de Cursos Nuevos
						<span class="badge badge-warning ba" id="badge"></span>
					</h6>
				</td>
				<td width="10%" class="pt-1 pb-0 pl-0 pr-0 border-0"><h6>Filtrar por</h6></td>
				<td width="10%" class="pt-1 pb-0 pl-0 pr-0 border-0">
					<ul class="nav nav-pills">
						<li class="nav-item dropdown">
							<a class="btn btn-outline-light dropdown dropdown-toggle form-control-sm pt-0 pb-0"
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
				<td width="20%" class="p-1 border-0">
					<input type="text" name="name" placeholder="Por nombre del curso" class="form-control form-control-sm"
						title="Ingrese parte/todo el nombre del curso" id="filtroCadena">
				</td>
				<td width="15%" class="p-1 border-0">
					<input type="text" name="date" placeholder="Fecha curso" class="form-control form-control-sm"
					title="Ingrese parte/toda la fecha del curso" id="filtroFecha">
				</td>
			</tr>
		</table>
	</div>
	<div class="col-lg-12 col-md-12 col-12 text-light bg-dark border border-info">
		<table class="table p-0 m-0">
			<tr>
				<td width = "5%"  class="border-0 p-0 m-0 text-center">
					ID
				</td>
				<td width = "42%" class="border-0 p-0 m-0 text-center">
					Descripción del Adiestramiento
				</td>
				<td width = "10%" class="border-0 p-0 m-0 text-center">
					Fecha
				</td>
				<td width = "15%" class="border-0 p-0 m-0 text-center">
					Tipo de Curso
				</td>
				<td width = "11%" class="border-0 p-0 m-0 text-center">
					Participantes
				</td>
				<td width = "17%" class="border-0 p-0 m-0 text-center">
					Opciones
				</td>
			</tr>
		</table>
	</div>
	<div id="TopeLista"></div>
	<div class="text-center" id="listNone" style="display: none;">
		<h1>No hay elementos del tipo<br>{{ $texto }}</h1>
	</div>
	<div class="p-0 contenido border border-info" id="listNew" style="display: none;">
		<table id="list" class="table table-striped table-hover p-0 m-0">
			@foreach ($cursos as $curso)
				<tr id="r{{ $curso->id }}" class="@if($curso->suspendido) edo_suspendido @endif"
					title="Dictado por {{ $curso->orador }} de {{ $curso->entidad }}">
					<input type="hidden" id="fechad{{ $curso->id }}"	value="{{ date('d-m-Y', strtotime($curso->fecha_desde)) }}">
					<input type="hidden" id="fechah{{ $curso->id }}"	value="{{ date('d-m-Y', strtotime($curso->fecha_hasta)) }}">
					<input type="hidden" id="origen{{ $curso->id }}"	value="{{ $curso->origen }}">
					<input type="hidden" id="horario{{ $curso->id }}"	value="{{ $curso->horario }}">
					<input type="hidden" id="tiempo{{ $curso->id }}"	value="{{ $curso->tiempo }}">
					<input type="hidden" id="tipo_m{{ $curso->id }}"	value="{{ $curso->tipo_medicion }}">
					<input type="hidden" id="entidad{{ $curso->id }}"	value="{{ $curso->entidad }}">
					<input type="hidden" id="orador{{ $curso->id }}"	value="{{ $curso->orador }}">
					<td width = "5%"  style="text-align: center; vertical-align: middle;" id="id{{ $curso->id }}" 
						class="border pl-0 ml-0 mr-0 pr-0 border-primary border-top-0 border-left-0 border-right-0">
						{{ $curso->id }}</td>
					<td width = "45%" id="nombre{{ $curso->id }}" 
						style="text-align: left; vertical-align: middle; line-height: 1.2;"
						class="border pl-0 ml-0 mr-0 pr-0 border-primary border-top-0 border-left-0 border-right-0"
						title="Dictado por {{ $curso->orador }} de {{ $curso->entidad }}">
						{{ $curso->nombre }}
					</td>
					<td width = "10%" style="text-align: right; vertical-align: middle; line-height: 1.2;" 
						class="border p-0 m-0 border-primary border-top-0 border-left-0 border-right-0">
						Del: {{ date('d-m-Y', strtotime($curso->fecha_desde)) }}
						al:  {{ date('d-m-Y', strtotime($curso->fecha_hasta)) }}						
					</td>
					<td width = "12%" style="text-align: center; vertical-align: middle;"
						class="border pl-0 ml-0 mr-0 pr-0 border-primary border-top-0 border-left-0 border-right-0">
						<input type="hidden" id="id_tipo{{ $curso->id }}" value="{{ $curso->id_tipo }}">
						<input class="txtLabel @if($curso->suspendido) txtLabelSus @endif"
							readonly disabled size="10" id="tipo{{ $curso->id }}"
							type="text" value="{{ $curso->tipo }}">
					 </td>
					<td width = "10%" style="text-align: center; vertical-align: middle;"
						class="border pl-0 ml-0 mr-0 pr-0 border-primary border-top-0 border-left-0 border-right-0">
						<div class="@if($curso->participantes>0)
								badge badge-success font-weight-normal @endif"
							 style="@if($curso->participantes>0) font-size: 14px @endif">
							 <input class="txtLabel @if($curso->suspendido) txtLabelSus @endif"
								type="text" readonly disabled size="1" id="cantp{{ $curso->id }}"
								value="{{ $curso->participantes }}">
						</div>
					</td>
					<td width = "18%" style="font-size: 18px; text-align: right; vertical-align: middle;"
						class="border pl-0 ml-0 mr-0 pr-2 border-primary border-top-0 border-left-0 border-right-0">
						<div class="d-inline p-0 m-0">
							<a id="lnkadd{{ $curso->id }}"
								href="@if($curso->suspendido) # @else /participantescurso/n/{{ $curso->id }} @endif">
								<i id="imgadd{{ $curso->id }}"
									class="fas fa-users fa-lg @if($curso->suspendido) img_btnd @else img_btn @endif"
									title="Ver/Agregar Participantes"></i></a>
						</div>
						<div class="d-inline p-0 m-0">
							<a href="#" data-toggle="modal" data-target="#ModalEditar"
								id="edittraining" data-tid = "{{ $curso->id }}">
								<i class="fas fa-pencil-alt fa-lg img_btn" title="Editar Curso"></i></a>
						</div>
						<div style="display: @if(!$curso->suspendido) inline @else none @endif" class="p-0 m-0"
							id="susp{{ $curso->id }}">
							<a onclick="changeStatus('s', '{{ $curso->id }}')" href="#">
								<i class="fas fa-pause fa-lg img_btn" title="Suspender Curso"></i></a>
						</div>
						<div style="display: @if($curso->suspendido) inline @else none @endif" class="p-0 m-0" 
							id="resu{{ $curso->id }}">
							<a href="#" onclick="changeStatus('r', '{{ $curso->id }}')">
								<i class="fas fa-play fa-lg img_btn" title="Reactivar Curso"></i></a>
						</div>
						<div class="d-inline p-0 m-0">
							<a id="lnkrdy{{ $curso->id }}" href="#"
								onclick="@if(!$curso->suspendido && $curso->participantes>0)
									changeStatus('c', '{{ $curso->id }}') @endif">
								<i class="fas fa-check fa-lg
									@if($curso->suspendido || $curso->participantes==0)
										img_btnd @else img_btn @endif"
									title="Completar Curso"></i></a>

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

		function changeStatus(v_action, v_id) {
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
					if(confirm('Desea dar por completado el curso?'))
						urlAction = "{{ url('/completarcurso') }}";
					else
						return;
					break;
			}
			jQuery.ajaxSetup({ headers: { 'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content') } });
			jQuery.ajax({
				url: urlAction + "/" + v_id,
				method: "post",
				data: { id: v_id },
				success: function(result){
					switch(v_action) {
						//Suspender Curso
						case 's':
							jQuery('#susp' + v_id).css('display', 'none');
							jQuery('#resu' + v_id).css('display', 'inline');
							jQuery('#r' + v_id).addClass('edo_suspendido');
							jQuery('#fecha' + v_id).addClass('txtLabelSus');
							jQuery('#tipo' + v_id).addClass('txtLabelSus');
							jQuery('#cantp' + v_id).addClass('txtLabelSus');
							validarBotones(v_action, v_id);
							break;
						//Reanudar Curso
						case 'r':
							jQuery('#susp' + v_id).css('display', 'inline');
							jQuery('#resu' + v_id).css('display', 'none');
							jQuery('#r' + v_id).removeClass('edo_suspendido');
							jQuery('#fecha' + v_id).removeClass('txtLabelSus');
							jQuery('#tipo' + v_id).removeClass('txtLabelSus');
							jQuery('#cantp' + v_id).removeClass('txtLabelSus');
							validarBotones(v_action, v_id);
							break;
						//Completar curso y pasar a pendientes por enviar
						case 'c':
							jQuery('#r' + v_id).hide("slow", function() {
								jQuery('#r' + v_id).css('display', 'none');
							});
							break;
						//end swtich
					}
				}
			});
		};

		function validarBotones(v_action, v_id){
			switch(v_action) {
				//Suspender Curso
				case 's':
					jQuery('#lnkadd' + v_id).attr("href", "#");
					jQuery('#imgadd' + v_id).removeClass('img_btn');
					jQuery('#imgadd' + v_id).addClass('img_btnd');
					if(jQuery('#cantp' + v_id).val()>0){
						jQuery('#lnkrdy' + v_id).attr("onclick", "");
						jQuery('#imgrdy' + v_id).removeClass('img_btn');
						jQuery('#imgrdy' + v_id).addClass('img_btnd');
					}
					break;
				//Reanudar Curso
				case 'r':
					jQuery('#lnkadd' + v_id).attr("href", "/participantescurso/n/" + v_id);
					jQuery('#imgadd' + v_id).removeClass('img_btnd');
					jQuery('#imgadd' + v_id).addClass('img_btn');
					if(jQuery('#cantp' + v_id).val()>0){
						jQuery('#lnkrdy' + v_id).attr("onclick", "changeStatus('c', '" + v_id + "')");
						jQuery('#imgrdy' + v_id).removeClass('img_btnd');
						jQuery('#imgrdy' + v_id).addClass('img_btn');
					}
					break;
				//end switch
			}
		}
	</script>
@endsection