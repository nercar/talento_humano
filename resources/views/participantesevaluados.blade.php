@extends('layouts.app')

@section('content')
	<input type="hidden" id="cantidad" value="{{ count($participantes) }}">
	<div class="container-fluid col-xl-12 col-md-12 col-12 p-1 card-title bg-dark">
		<table class="table p-0 m-0">
			<tr width="95%" class="p-0">
				<td class="pl-1 pr-1 pt-1 pb-0 border-0">
					<h6>Participantes Evaluados
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
				<td width = "10%" class="border-0 p-0 m-0 text-center">
					Cédula
				</td>
				<td width = "45%" class="border-0 p-0 m-0 text-center">
					Nombre del Empleado
				</td>
				<td width = "30%" class="border-0 p-0 m-0 text-center">
					Cargo
				</td>
				<td width = "7%" class="border-0 p-0 m-0 text-center">
					Ptos.
				</td>
				<td width = "13%" class="border-0 p-0 m-0 text-center">
					Opciones
				</td>
			</tr>
		</table>
	</div>
	<div id="TopeLista"></div>
	<div class="container-fluid p-0 contenido border border-info" id="listemp" style="display: none;">
		<table id="list" class="table table-striped table-hover w-100">
			<tr style="height: 0px; padding: 0px; margin: 0px; visibility: collapse;">
				<td width = "10%"></td>
				<td width = "45%"></td>
				<td width = "30%"></td>
				<td width = "7%" ></td>
				<td width = "13%"></td>
			</tr>
			@foreach ($participantes as $participante)
				@if($iddpto!=$participante->id_departamento)
					<tr>
						<td colspan="5"
							class="border border-primary border-top-0 border-left-0
								   border-right-0 text-center bg-success p-0 m-0 text-light">
							{{ $participante->departamento }}
						</td>
					</tr>
				@endif
				<tr>
					<td width = "10%"
						class="border border-primary border-top-0 border-left-0 border-right-0">
						{{ $participante->cedula }}
					</td>
					<td width = "45%"
						class="border border-primary border-top-0 border-left-0 border-right-0 text-justify">
						{{ trim($participante->nomemp) . ' ' . trim($participante->apeemp) }}
					</td>
					<td width = "30%"
						class="border border-primary border-top-0 border-left-0 border-right-0 text-justify">
						{{ trim($participante->nomcar) }}
					</td>
					<td width = "7%"
						class="border border-primary border-top-0 border-left-0 border-right-0 text-center">
						@if($participante->total_eval>1)
							<span class="badge badge-success" style="font-size: 14px;">
								{{ $participante->total_eval }}
							</span>
						@else
							n/a
						@endif
					</td>
					<td width = "13%" style="text-align: right; vertical-align: middle; font-size: 18px;"
						class="border pl-0 ml-0 mr-0 pr-2 border-primary border-top-0 border-left-0 border-right-0">
						<a href="/verevaluacion/{{ $participante->id_curso }}/{{ $participante->cedula }}" id="verevaluacion">
							<i class="fas fa-money-check fa-lg @if($participante->motivo!='') img_btnd @else img_btn @endif"
								title="Ver Evaluación"></i></a>
					</td>
				</tr>
				@if($iddpto!=$participante->id_departamento)
					@php($iddpto = $participante->id_departamento)
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

		function resizeTables() {
			jQuery('#listemp').css('height' , (window.innerHeight) - jQuery('#TopeLista').position().top - 3.55 + 'px');
			jQuery('#listemp').css('display', 'block');
		};
	</script>
@endsection