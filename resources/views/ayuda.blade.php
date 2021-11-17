@extends('layouts.app')

@section('content')
	<div id="TopeLista" class="text-light bg-info">
		<table>
			<tr>
				<td class="font-weight-bold pl-1" width="99%">
					Ayuda del Módulo de Medición de Eficacia de Adiestramiento de la Intranet de Policlínica Táchira
				</td>
				<td class="font-weight-bold text-right">
					<span style="font-size: 14px; cursor: pointer; vertical-align: bottom;"
						class="badge badge-danger font-weight-bold text-right"
						onclick="history.back()">
						&nbsp;X&nbsp;
					</span>
				</td>
			</tr>
		</table>
	</div>
	<div class="row contenido col-xl-12 col-md-12 col-12 pt-2 border border-info" id="ayuda">
		@include('help');
	</div>

	<script>
		jQuery('document').ready(function() {
			setTimeout("resizeContenido('ayuda', " + ( jQuery('#TopeLista').position().top + jQuery('#TopeLista').height() ) + ")", 100);
		});

		jQuery(window).resize(function() {
			setTimeout("resizeContenido('ayuda', " + ( jQuery('#TopeLista').position().top + jQuery('#TopeLista').height() ) + ")", 100);
		});
	</script>
@endsection