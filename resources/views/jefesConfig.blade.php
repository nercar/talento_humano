@extends('layouts.app')

@section('content')
	<input type="hidden" id="cantjefes" value="{{ count($jefes) }}">
	<div class="container-fluid col-xl-12 col-md-12 col-12 p-1 card-title bg-dark">
		<table class="table p-0 m-0">
			<tr class="p-0" style="vertical-align: middle;">
				<td width="65%" class="p-0 border-0">
					<h6>Listado de Cargos Intranet de los Jefes de Departamento</h6>
				</td>
				<td width="10%" class="p-0 border-0 text-center"><h6>Filtrar por</h6></td>
				<td width="25%" class="p-0 border-0">
					<input type="text" name="name" id="filtroCadena"
						placeholder="Ingrese parte del correo o nombre del jefe."
						class="form-control form-control-sm">
				</td>
			</tr>
		</table>
	</div>
	<div class="container-fluid col-lg-12 col-md-12 col-12 text-light bg-dark border border-info">
		<table class="table p-0 m-0">
			<tr>
				<td width = "4%" class="border-0 p-0 m-0 text-center">
					ID
				</td>
				<td width = "28%" class="border-0 p-0 m-0 text-center">
					Cargo Intranet del Jefe
				</td>
				<td width = "28%" class="border-0 p-0 m-0 text-center">
					Nombre del Jefe del Departamento
				</td>
				<td width = "25%" class="border-0 p-0 m-0 text-center">
					Correo Electrónico
				</td>
				<td width = "15%" class="border-0 p-0 m-0 text-center">
					Opciones
				</td>
			</tr>
		</table>
	</div>
	<div id="TopeLista"></div>
	<div class="text-center" id="listNone" style="display: none;">
		<h1>No hay elementos para esta<br>Consulta</h1>
	</div>
	<div class="container-fluid p-0 contenido border border-info" id="listNew" style="display: none;">
		<table id="list" class="table table-striped table-hover">
			@foreach ($jefes as $jefe)
				<tr id="r{{ $jefe->id }}" class="@if(!$jefe->activo) edo_suspendido @endif">
					<td width = "4%" id="id{{ $jefe->id }}" 
						class="border border-primary border-top-0 border-left-0 border-right-0">
						{{ $jefe->id }}
					</td>
					<td width = "28%" id="cargo{{ $jefe->id }}" style="word-break: break-all;"
						class="border border-primary border-top-0 border-left-0 border-right-0"
						title="{{ $jefe->login }}">
						{{ $jefe->cargo }}
					</td>
					<td width = "28%" id="nombre{{ $jefe->id }}" style="word-break: break-all;"
						class="border border-primary border-top-0 border-left-0 border-right-0">
						{{ $jefe->nombre }}
					</td>
					<td width = "25%" id="correo{{ $jefe->id }}" style="word-break: break-all;" 
						class="border border-primary border-top-0 border-left-0 border-right-0">
						{{ $jefe->correo }}
					</td>
					<td width = "15%" style="font-size: 18px; text-align: right; vertical-align: middle;" 
						class="border border-primary border-top-0 border-left-0 border-right-0 text-right">
						<div class="d-inline p-0 m-0">
							<a href="/seldprtmntos/{{ $jefe->id }}">
								<i class="fas fa-building fa-lg img_btn" title="Ver Departamentos"></i></a>
						</div>
						<div class="d-inline p-0 m-0">
							<a href="#" data-toggle="modal" data-target="#ModalEditar"
								id="editjefe" data-tid="{{ $jefe->id }}">
								<i class="fas fa-pencil-alt fa-lg img_btn" title="Editar Cargo"></i></a>
						</div>
						<div style="display: @if(!$jefe->activo) none @else inline @endif" class="p-0 m-0"
							id="inact{{ $jefe->id }}">
							<a onclick="changeStatus('i', '{{ $jefe->id }}')" href="#">
								<i class="fas fa-pause fa-lg img_btn" title="Inactivar jefe"></i></a>
						</div>
						<div style="display: @if($jefe->activo) none @else inline @endif" class="p-0 m-0" 
							id="act{{ $jefe->id }}">
							<a href="#" onclick="changeStatus('a', '{{ $jefe->id }}')">
								<i class="fas fa-play fa-lg img_btn" title="Activar jefe"></i></a>
						</div>
					</td>
				</tr>
			@endforeach
		</table>
	</div>
	@include('editarjefe')
		
	<script>
		var divId = 'listNone';
		jQuery('document').ready(function(){
			jQuery('#filtroCadena').val('');
			if(jQuery('#cantjefes').val()!='') {
				document.getElementById('listNew').style.display = 'block';
				document.getElementById('listNone').style.display = 'none';
				divId = 'listNew';
			}
			setTimeout("resizeContenido('" + divId + "', " + jQuery('#TopeLista').position().top + ")", 100);
		});

		jQuery(window).resize(function(){
			setTimeout("resizeContenido('" + divId + "', " + jQuery('#TopeLista').position().top + ")", 100);
		});

		jQuery('#filtroCadena').keydown(function(){
			vname = jQuery('#filtroCadena').val();
		});

		jQuery('#filtroCadena').keyup(function(){
			if(jQuery('#filtroCadena').val() != vname) { if(jQuery('#cantjefes').val()>0) filterList(); }
		});

		function resizeTables() {
			jQuery('#listNew').css('height' , (window.innerHeight) - jQuery('#TopeLista').position().top - 3.55 + 'px');
			jQuery('#listNone').css('height' , (window.innerHeight) - jQuery('#TopeLista').position().top - 3.55 + 'px');
		};

		function filterList() {
			var rows = document.getElementById('list').getElementsByTagName('tr');
			var contName = jQuery('#filtroCadena').val().trim().toLowerCase();
			var showL = false;

			document.getElementById('listNew').style.display = 'none';
			document.getElementById('listNone').style.display = 'block';

			for (i=0; i<=rows.length-1; i++)
				document.getElementById(rows[i].id).style.display = 'none';

			for (i=0; i<=rows.length-1; i++){
				var contNameR = rows[i].cells[1].innerHTML.toLowerCase().trim(); 
				var contBossR = rows[i].cells[2].innerHTML.toLowerCase().trim();
				var contEmaiR = rows[i].cells[3].innerHTML.toLowerCase().trim();
				var show = false;

				if(!show && contName.length>0 &&
					(contNameR.indexOf(contName)>=0 ||
					 contBossR.indexOf(contName)>=0 ||
					 contEmaiR.indexOf(contName)>=0) )
					show=true;

				if(contName.length==0) show=1;

				if(show) {
					document.getElementById(rows[i].id).style.display = '';
					showL = true;
				}
			}

			if(showL) {
				document.getElementById('listNew').style.display = 'block';
				document.getElementById('listNone').style.display = 'none';
			}
		};

		function changeStatus(v_action, idjefe) {
			var urlAction = '';
			switch(v_action) {
				//Inactivar jefe
				case 'i':
					urlAction = "{{ url('/inactivarJefe') }}";
					break;
				//Activar jefe
				case 'a':
					urlAction = "{{ url('/activarJefe') }}";
					break;
			}
			jQuery.ajaxSetup({ headers: { 'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content') } });
			jQuery.ajax({
				url: urlAction + "/" + idjefe,
				method: "post",
				data: { id: idjefe },
				success: function(result){
					switch(v_action) {
						//Suspender jefe
						case 'i':
							jQuery('#inact' + idjefe).css('display', 'none');
							jQuery('#act' + idjefe).css('display', 'inline');
							jQuery('#r' + idjefe).addClass('edo_suspendido');
							break;
						//Reanudar jefe
						case 'a':
							jQuery('#inact' + idjefe).css('display', 'inline');
							jQuery('#act' + idjefe).css('display', 'none');
							jQuery('#r' + idjefe).removeClass('edo_suspendido');
							break;
						//end swtich
					}
				}
			});
		};
	</script>
@endsection