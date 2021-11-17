@extends('layouts.app')

@section('content')
	<input type="hidden" id="cursos" value="{{ count($cursos) }}">
	<input type="hidden" id="tipo_actual" value="">
	<div class="container-fluid col-xl-12 col-md-12 col-12 p-1 card-title bg-dark">
		<table class="table p-0 m-0">
			<tr class="p-0">
				<td width="44%" class="pl-1 pr-1 pt-1 pb-0 border-0">
					<h6>Cursos Ejecutados
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
		<table class="w-100">
			<tr>
				<td width = "4%"  class="border-0 p-0 m-0 text-left  ">
					ID
				</td>
				<td width = "50%" class="border-0 p-0 m-0 text-center">
					Descripción del Adiestramiento
				</td>
				<td width = "8%" class="border-0 p-0 m-0 text-center">
					Fecha
				</td>
				<td width = "14%" class="border-0 p-0 m-0 text-center">
					Tipo de Curso
				</td>
				<td width = "14%" class="border-0 p-0 m-0 text-center">
					Participantes
				</td>
				<td width = "10%" class="border-0 p-0 m-0 text-center">
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
		<table id="list" class="table table-striped table-hover w-100"
			style="overflow-x: hidden; overflow-y: auto;">
			@foreach ($cursos as $curso)
				<tr id="r{{ $curso->id }}">
					<td width = "4%"  style="text-align: right;" id="id{{ $curso->id }}" 
						class="border border-primary border-top-0 border-left-0 border-right-0">
						{{ $curso->id }}</td>
					<td width = "50%" style="text-align: justify;" id="nombre{{ $curso->id }}" 
						class="border border-primary border-top-0 border-left-0 border-right-0">
						{{ $curso->nombre }}</td>
					<td width = "8%" style="text-align: center;"
						class="border border-primary border-top-0 border-left-0 border-right-0">
						<input class="txtLabel"
							readonly disabled size="10" id="envio{{ $curso->id }}"
							type="text" value="{{ date('d-m-Y', strtotime($curso->fecha_desde)) }}">
					</td>
					<td width = "14%" style="text-align: center;"
						class="border border-primary border-top-0 border-left-0 border-right-0">
						<input class="txtLabel"
							readonly disabled size="10" id="tipo{{ $curso->id }}"
							type="text" value="{{ $curso->tipo }}">
					 </td>
					<td width = "14%" style="text-align: center;"
						class="border border-primary border-top-0 border-left-0 border-right-0">
						<div class="@if($curso->participantes>0)
								badge badge-success font-weight-normal @endif"
							 style="@if($curso->participantes>0) font-size: 14px @endif">
							 <input class="txtLabel"
								type="text" readonly disabled size="1" id="cantp{{ $curso->id }}"
								value="{{ $curso->participantes }}">
						</div>
					</td>
					<td width = "10%" style="text-align: right; vertical-align: middle; font-size: 18px;"
						class="border pl-0 ml-0 mr-0 pr-2 border-primary border-top-0 border-left-0 border-right-0">
						<a href="/asistenciacurso/{{ $curso->id }}">
							<i id="imgadd{{ $curso->id }}"
								class="fas fa-user-edit fa-lg img_btn"
								title="Modificar Asistencia"></i></a>
					</td>
				</tr>
			@endforeach
		</table>
	</div>
	
	<script>
		var divId = 'listNone';
		jQuery('document').ready(function(){
			jQuery('#filtroFecha').val('');
			jQuery('#filtroCadena').val('');
			if(jQuery('#cursos').val()!='') {
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
			if(jQuery('#filtroCadena').val() != vname) { if(jQuery('#cursos').val()>0) filterList(); }
			if(jQuery('#filtroFecha').val() != vdate) { if(jQuery('#cursos').val()>0) filterList(); }
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
	</script>
@endsection