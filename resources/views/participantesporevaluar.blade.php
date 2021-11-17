@extends('layouts.app')

@section('content')
	<div class="container-fluid col-xl-12 col-md-12 col-12 p-1 card-title bg-dark">
		<table class="table p-0 m-0">
			<tr class="p-0">
				<td width="95%" class="pl-1 pr-1 pt-1 pb-0 border-0">
					<h6>Participantes Pendientes por Evaluar
						<span class="badge badge-warning ba" id="badge">{{ $nombre }}</span>
					</h6>
				</td>
				<td width="5%" class="p-0 m-0 border-0 text-right">
					<span style="font-size: 14px; cursor: pointer; vertical-align: bottom;"
						class="badge badge-danger font-weight-bold"
						onclick="history.back()">
						&nbsp;X&nbsp;
					</span>
				</td>
			</tr>
		</table>
	</div>
	<div class="container-fluid col-lg-12 col-md-12 col-12 text-light bg-dark border border-info">
		<table class="table p-0 m-0 w-100">
			<tr>
				<td width = "10%"  class="border-0 p-0 m-0 text-center">
					Cédula
				</td>
				<td width = "35%" class="border-0 p-0 m-0 text-center">
					Nombre del Empleado
				</td>
				<td width = "45%" class="border-0 p-0 m-0 text-center">
					Cargo
				</td>
				<td width = "10%" class="border-0 p-0 m-0 text-center">
					Opciones
				</td>
			</tr>
		</table>
	</div>
	<div id="TopeLista"></div>
	<div class="container-fluid p-0 contenido border border-info" id="listemp" style="display: none;">
		<table id="list" class="table table-striped table-hover w-100">
			@foreach ($participantes as $participante)
				<tr id="r{{ $participante->cedula }}"
					class="@if($participante->fecha_obs!='') edo_suspendido @endif">
					<td width = "10%"  style="text-align: justify;" id="id{{ $participante->cedula }}" 
						class="border border-primary border-top-0 border-left-0 border-right-0">
						{{ $participante->cedula }}</td>
					<td width = "35%" style="text-align: justify" id="nombre{{ $participante->cedula }}" 
						class="border border-primary border-top-0 border-left-0 border-right-0">
						{{ trim($participante->nomemp) . ' ' . trim($participante->apeemp) }}</td>
					<td width = "45%" style="text-align: justify; line-height: 1;"
						class="border border-primary border-top-0 border-left-0 border-right-0">
						{{ trim($participante->nomcar)}}<br>
						@if($participante->motivo!='')
							<span id="selcon{{ $participante->cedula }}" class="badge badge-warning">
								{{ $participante->motivo }}
							</span>
						@else
							<span id="selcon{{ $participante->cedula }}"></span>
						@endif
					</td>
					<td width = "10%" style="text-align: right; vertical-align: middle; font-size: 18px;"
						class="border pl-0 ml-0 mr-0 pr-2 border-primary border-top-0 border-left-0 border-right-0">
						
							<a href="#" data-toggle="modal" data-target="#ModalCondicion" 
								data-tid = "{{ $participante->id_curso }}"
								data-eid = "{{ $participante->cedula }}">
								<i class="fas fa-users-cog  fa-lg img_btn" title="Condición Participante"></i></a>
							<a href="@if($participante->fecha_obs=='')
									/evaluarcurso/{{ $participante->id_curso }}/{{ $participante->cedula }}
								@else # @endif" id="lnkeval{{ $participante->cedula }}">
								<i class="fas fa-clipboard-list fa-lg @if($participante->motivo!='') img_btnd @else img_btn @endif"
									title="Evaluar Participante"></i></a>
						
					</td>
				</tr>
			@endforeach
		</table>
		@include('condicionparticipante')
	</div>

	<script>
		jQuery('document').ready(function(){
			setTimeout("resizeContenido('listemp', " + jQuery('#TopeLista').position().top + ")", 100);
			jQuery('#listemp').css('display', 'block');
		});

		jQuery(window).resize(function(){
			setTimeout("resizeContenido('listemp', " + jQuery('#TopeLista').position().top + ")", 100);
			jQuery('#listemp').css('display', 'block');
		});

		function resizeTables() {
			jQuery('#listemp').css('height' , (window.innerHeight) - jQuery('#TopeLista').position().top - 3.55 + 'px');
			jQuery('#listemp').css('display', 'block');
		};
	</script>
@endsection