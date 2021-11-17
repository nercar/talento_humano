@extends('layouts.app')

@section('content')
	<input type="hidden" id="idcurso" value="{{ $idcurso }}">
	<div class="container-fluid col-xl-12 col-md-12 col-12 p-1 card-title bg-dark">
		<table class="table p-0 m-0">
			<tr class="p-0">
				<td class="pl-1 pr-1 pt-1 pb-0 border-0">
					<h6>Asitentes Planificados al Adiestramiento
						<span class="badge badge-warning" id="badge">{{ $nombre }}</span>
					</h6>
				</td>
				<td class="p-0 m-0 border-0 text-right">
					<span style="font-size: 14px; cursor: pointer;"
						class="badge badge-danger font-weight-bold"
						onclick="history.back()">
						&nbsp;X&nbsp;
					</span>
				</td>
			</tr>
		</table>
	</div>
	<div class="container-fluid col-lg-12 col-md-12 col-12 text-light bg-dark border border-info">
		<table class="table p-0 m-0 w-100" style="table-layout: fixed;">
			<tr>
				<td width = "10%" class="border-0 p-0 m-0 text-center">
					Cédula
				</td>
				<td width = "35%" class="border-0 p-0 m-0 text-center">
					Nombre del Empleado
				</td>
				<td width = "40%" class="border-0 p-0 m-0 text-center">
					Cargo
				</td>
				<td width = "15%" class="border-0 p-0 m-0 text-center">
					Asistió
				</td>
			</tr>
		</table>
	</div>
	<div id="TopeLista"></div>
	<div class="container-fluid p-0 contenido border border-info" id="listemp" style="display: none;">
		<table id="list" class="table table-striped table-hover w-100" style="overflow-x: hidden; overflow-y: auto">
			@foreach ($asistentes as $asistente)
				@if($iddpto!=$asistente->id_departamento)
					<tr>
						<td colspan="5"
							class="border border-primary border-top-0 border-left-0
								   border-right-0 text-center bg-success p-0 m-0 text-light">
							{{ $asistente->departamento }}
						</td>
					</tr>
				@endif
				<tr id="r{{ $asistente->cedula }}">
					<td width = "10%"  style="text-align: justify;" id="id{{ $asistente->cedula }}" 
						class="border border-primary border-top-0 border-left-0 border-right-0">
						{{ $asistente->cedula }}</td>
					<td width = "40%" style="text-align: justify" id="nombre{{ $asistente->cedula }}" 
						class="border border-primary border-top-0 border-left-0 border-right-0">
						{{ trim($asistente->nomemp) . ' ' . trim($asistente->apeemp) }}</td>
					<td width = "40%" style="text-align: justify;"
						class="border border-primary border-top-0 border-left-0 border-right-0">
						{{ trim($asistente->nomcar)}}
					</td>
					<td width = "10%" style="text-align: left; vertical-align: middle; font-family: Courier"
						class="border border-primary border-top-0 border-left-0 border-right-0 m-0 p-0">
						<div class="btn-group btn-group-toggle p-0 m-0" data-toggle="buttons"
							id="opc{{ $asistente->cedula }}" onclick="cambio('{{ $asistente->cedula }}')">
							<label class="btn btn-outline-primary pt-0 pb-0 @if($asistente->asistio) active @endif">
								<input type="radio" name="options"
										id="opt_si{{ $asistente->cedula }}" value="1" autocomplete="off">Si
						  	</label>
							<label class="btn btn-outline-warning pt-0 pb-0 @if(!$asistente->asistio) active @endif">
								<input type="radio" name="options"
										id="opt_no{{ $asistente->cedula }}" value="0" autocomplete="off">No
							</label>
						</div>
					</td>
				</tr>
				@if($iddpto!=$asistente->id_departamento)
					@php($iddpto = $asistente->id_departamento)
				@endif
			@endforeach
		</table>
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

		function cambio(id) {
			jQuery('#opc'+id + ' :input').change(function() {	
				var urlAction = "{{ url('/modificarasistencia') }}" + "/"
							  + jQuery('#idcurso').val() + "/" + id + "/" + this.value;
				jQuery.ajaxSetup({ headers: { 'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content') } });
				jQuery.ajax({
					url: urlAction,
					method: "post",
				});
			})
		}

		function resizeTables() {
			jQuery('#listemp').css('height' , (window.innerHeight) - jQuery('#TopeLista').position().top - 3.55 + 'px');
			jQuery('#listemp').css('display', 'block');
		};
	</script>
@endsection