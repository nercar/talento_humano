@extends('layouts.app')

@section('content')
	<input type="hidden"	id="curso"		value="{{ $cursos->nombre }}">
	<input type="hidden"	id="idcurso"	value="{{ $cursos->id }}">
	<input type="hidden"	id="idempresa"	value="{{ $idempresa }}">
	<input type="hidden"	id="origen"		value="{{ $origen }}">
	<input type="hidden"	id="iddpto"		value="">
	<div class="container-fluid col-xl-12 col-md-12 col-12 p-0 card-title bg-dark">
		<table width="100%" class="table p-0 m-0">
			<tr>
				<td width="65%" class="pt-0 pb-0 border-0 flex-wrap">
					<h6>Listado de Participantes al Adiestramiento<br>
						<span id="badge" data-toggle="tooltip"
							class="badge badge-warning"
							style="cursor: default;">
						</span>
					</h6>
				</td>
				<td width="30%" class="pt-0 pb-0 border-0 flex-nowrap">
					<div id="badge-emp" class="badge badge-danger w-100"
						style="cursor: default;">
						Seleccione una empresa
					</div>
					<select id="empresas" name="empresas" class="form-control form-control-sm">
						<option value="0">Seleccione una empresa</option>
						@foreach ($empresas as $empresa)
							<option value="{{ $empresa->id }}">{{ $empresa->nombre }}</option>
						@endforeach
					</select>
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
	<div class="container-fluid">
		<div class="row">
			<div class="col-3 col-md-3 col-xl-3 bg-info text-center">
				<h6 class="p-0 m-0">Departamentos</h6>
			</div>
			<div class="col-9 col-md-9 col-xl-9 bg-info text-center">
				<h6 class="p-0 m-0">Lista de Empleados del Departamento
					<span id="badgeDpto" class="bg-success text-light"
						style="font-size: smaller; border-radius: 8px;"></span>
				</h6>
			</div>
		</div>
		<div class="row">
			<div class="col-3 col-md-3 col-xl-3 p-0 m-0 border border-dark">
				<input type="text" name="filtroDpto" placeholder="Filtrar por nombre del departamento"
					class="form-control form-control-sm" id="filtroDpto">
			</div>
			<div class="row col-9 col-md-9 col-xl-9 p-0 m-0 border border-dark">
				<table class="w-100">
					<tr>
						<td width="12%">Marcar</td>
						<td width="12%">
							<a href="#" onclick="conmutarTodos(1)">Todos</a>
						</td>
						<td width="12%">
							<a href="#" onclick="conmutarTodos(0)">Ninguno</a>
						</td>
						<td width="64%">
							<input type="text" name="filtroEmpleado"
				   				placeholder="Filtrar por nombre del empleado"
				   				class="form-control form-control-sm p-0" id="filtroEmpleado"
				   				onkeydown="filtroEmpleadoKD()"
				   				onkeyup="filtroEmpleadoKU()">
				   		</td>
					</tr>
				</table>
			</div>
		</div>
		<div id="TopeLista"></div>
		<div class="row">
			<div class="col-3 col-md-3 col-xl-3 contenido p-0 m-0 border border-primary" id="listadodpto">
			</div>
			<div class="col-9 col-md-9 col-xl-9 contenido p-0 m-0 border border-primary" id="lstppal">
				<div class="contenido" id="lstemp">
				</div>
				<div class="text-center bg-info text-light font-weight-bold border border-primary" id="tituloPart">
					Personal inscrito en el Adiestramiento
				</div>
				<div class="contenido" id="lstpart" style="height: 185px">
				</div>
			</div>
		</div>
	</div>

	<script>
		jQuery('document').ready(function(){
			if(jQuery('#curso').val().length > 95) {
				jQuery('#badge')[0].innerHTML = jQuery('#curso').val().substr(0,95) + '(...)';
				jQuery('#badge')[0].title = jQuery('#curso').val();
			} else {
				jQuery('#badge')[0].innerHTML = jQuery('#curso').val();
			}
			if(jQuery('#idempresa').val()!=0) jQuery('#empresas').val(jQuery('#idempresa').val());
			if(jQuery('#idempresa').val()==0) {
				efecto();
			}
			jQuery('#badgeDpto').html('');
			//setTimeout('resizeTables()', 100);
			setTimeout("resizeTables()", 100);
			personalInscrito();
		});

		function efecto(){
			if(jQuery('#idempresa').val()==0) {
				jQuery('#badge-emp').fadeToggle();
				jQuery('#badge-emp').fadeToggle();
				setTimeout("efecto()", 1000);
			}
		}
		
		jQuery('#empresas').on('change', function(){
			jQuery('#lstemp').html('');
			jQuery('#badgeDpto').html('');
			listarDptos(this.value);
			jQuery('#idempresa').val(this.value)
			efecto();
		});

		jQuery(window).resize(function(){
			setTimeout('resizeTables()', 100);
		});

		jQuery('#filtroDpto').keydown(function(){
			vdpto = jQuery('#filtroDpto').val();
		});

		jQuery('#filtroDpto').keyup(function(){
			if(jQuery('#filtroDpto').val() != vdpto)
				filterDpto();
		});

		function filtroEmpleadoKD() {
			vemp = jQuery('#filtroEmpleado').val();
		};

		function filtroEmpleadoKU() {
			if(jQuery('#filtroEmpleado').val() != vemp)
				filterEmp();
		};


		function resizeTables() {
			setTimeout("resizeContenido('listadodpto', " + jQuery('#TopeLista').position().top + ")", 100);
			setTimeout("resizeContenido('lstppal', " + jQuery('#TopeLista').position().top + ")", 100);
			setTimeout("resizeContenido('lstemp', " + (jQuery('#TopeLista').position().top + (200+13)) + ")", 100);
		};

		function listarDptos(empresa) {
			if(empresa!=0) {
				var htmlTabla = '<div class="text-center">' +
								'<h1>No Existen Departamentos Registrados para la Empresa</h1></div>';
				jQuery.get('/api/departamentos' + '/' + empresa, function(data) {
					htmlTabla = '<table id="listdptos" class="table table-striped table-hover">';
					if(data.length>0) {
						for (i=0; i<data.length; ++i) {
							htmlTabla += '<tr id="'+data[i].id+'"';
							htmlTabla += ' onclick="selDpto(this.id, ' + "'&nbsp;" + data[i].nombre + "&nbsp;'" + ',' + empresa + ')">';
							htmlTabla += '	<td class="text-left pb-1 pt-1">' + data[i].nombre + '</td>';
							htmlTabla += '</tr>';
						};
					}
					htmlTabla += '</table>';
					jQuery('#listadodpto').html(htmlTabla);
					var target = document.getElementById("filtroDpto");
					target.parentNode.scrollTop = target.offsetTop;
					});
			} else {
				jQuery('#listadodpto').html('');
			}
		};

		function selDpto(iddpto, dpto, empresa) {
			var idcurso = jQuery('#idcurso').val();
			jQuery('#iddpto').val(iddpto);
			desmarcarListDptos();
			jQuery('#' + iddpto).addClass('resaltado');
			if(empresa!=0) {
				jQuery.get('/api/empleados' + '/' + iddpto + '/' + empresa + '/' + idcurso, function(data) {
					var htmlTabla = '<div class="text-center">';
					htmlTabla += '<h1>No Existen Empleados Registrados al Departamento<br><br>';
					htmlTabla += dpto + '</h1></div>';
					if(data.length>0) {
						htmlTabla = '<table id="listemp" class="table table-striped table-hover">';
						for (i=0; i<data.length; ++i) {
							htmlTabla += '<tr id="'+data[i].cedula+'" onclick="selEmp(this.id)"';
							if(data[i].idcurso == idcurso){
								htmlTabla += 'class="resaltado"'
							}
							htmlTabla += '>';
							htmlTabla += '<td width = "15%">';
							htmlTabla += '<input type="hidden" id="sel' + data[i].cedula + '" value="';
							if(data[i].idcurso == idcurso){
								htmlTabla += '1';
							} else {
								htmlTabla += '0';
							}
							htmlTabla += '">';
							htmlTabla += data[i].cedula;
							htmlTabla += '</td>';
							htmlTabla += '<td width = "85%">';
							htmlTabla += data[i].nomemp + ' ' + data[i].apeemp + '&nbsp;';
							htmlTabla += '<span class="badge badge-info">' + data[i].nomcar + '</span>';
							htmlTabla += '</td></tr>';
						};
						htmlTabla += '</table>';
					}
					jQuery('#lstemp').html(htmlTabla);
					jQuery('#badgeDpto').html(dpto);
					var target = document.getElementById("filtroEmpleado");
    				target.parentNode.scrollTop = target.offsetTop;
				});
			}
		};

		function selEmp(idemp) {
			if( jQuery('#sel'+idemp).val()==1 ) {
				jQuery('#sel'+idemp).val(0);
				jQuery('#'+idemp).removeClass('resaltado');
				conmutarEmp(jQuery('#idcurso').val(), idemp);
			} else {
				jQuery('#sel'+idemp).val(1);
				jQuery('#'+idemp).addClass('resaltado');
				conmutarEmp(jQuery('#idcurso').val(), idemp);
			}
		}

		function desmarcarListDptos() {
			var rows = document.getElementById('listdptos').getElementsByTagName('tr');

			for (i=0; i<=rows.length-1; i++) {
				jQuery('#' + rows[i].id).removeClass('resaltado');
			}
		};

		function filterDpto() {
			var rows = document.getElementById('listdptos').getElementsByTagName('tr');
			var contName = jQuery('#filtroDpto').val().trim().toLowerCase();

			document.getElementById('listdptos').style.display = 'none';

			for (i=0; i<=rows.length-1; i++) 
				document.getElementById(rows[i].id).style.display = 'none';

			for (i=0; i<=rows.length-1; i++){
				var contNameR = rows[i].cells[0].innerHTML.toLowerCase().trim(); 
				var show  = false;
				
				if(contName.length>0 && contNameR.indexOf(contName)>=0) show=true;

				if(contName.length==0) show=true;

				if(show) document.getElementById(rows[i].id).style.display = '';
			}
			
			document.getElementById('listdptos').style.display = 'block';
		};

		function filterEmp() {
			var rows = document.getElementById('listemp').getElementsByTagName('tr');
			var contName = jQuery('#filtroEmpleado').val().trim().toLowerCase();

			document.getElementById('listemp').style.display = 'none';

			for (i=0; i<=rows.length-1; i++)
				document.getElementById(rows[i].id).style.display = 'none';

			for (i=0; i<=rows.length-1; i++){
				var contNameR = rows[i].cells[1].innerHTML.toLowerCase().trim(); 
				var show  = false;
				
				if(contName.length>0 && contNameR.indexOf(contName)>=0) show=true;

				if(contName.length==0) show=true;

				if(show) document.getElementById(rows[i].id).style.display = '';
			}
			
			document.getElementById('listemp').style.display = 'block';
		};

		function conmutarEmp(idcurso, idemp) {
			var urlAction = "{{ url('/conmutarParticipante') }}";			
			jQuery.ajaxSetup({ headers: { 'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content') } });
			jQuery.ajax({
				url: urlAction + '/' + idcurso + '/' + idemp,
				method: "post",
				success: function(result){
					personalInscrito();
				}
			});
		};

		function personalInscrito() {
			var idcurso = jQuery('#idcurso').val();
			var empresa = '';
			var departamento = '';
			jQuery.get('/api/personalinscrito' + '/' + idcurso, function(data) {
				var htmlTabla = '<div class="text-center">';
				htmlTabla += '<h2>No Existe Personal registrado para este<br>';
				htmlTabla += 'Adistramiento</h2></div>';
				if(data.length>0) {
					htmlTabla = '<table id="listpart" class="table-striped">';
					for (i=0; i<data.length; ++i) {
						if(data[i].empresa!=empresa){
							htmlTabla += '<th colspan="2" class="badge-primary" style="font-size: 14px;">';
							htmlTabla += toTitleCase(data[i].empresa);
							htmlTabla += '<th>';
							empresa = data[i].empresa;
						}
						if(data[i].departamento!=departamento) {
							if(data[i].empresa==empresa) htmlTabla += '<tr>';
							htmlTabla += '<th colspan="2"  class="badge-success" style="font-size: 14px;">';
							htmlTabla += toTitleCase(data[i].departamento);
							htmlTabla += '<th>';
							if(data[i].empresa==empresa) htmlTabla += '</tr>';
							departamento = data[i].departamento;
						}
						htmlTabla += '<tr style="font-size: 14px;">';
						htmlTabla += '<td width = "60%" class="flex-nowrap">';
						htmlTabla += toTitleCase(data[i].nomemp + ' ' + data[i].apeemp);
						htmlTabla += '</td><td width = "40%" class="flex-nowrap">'
						htmlTabla += toTitleCase(data[i].nomcar);
						htmlTabla += '</td></tr>';
					}
					htmlTabla += '</table>';
				}
				jQuery('#lstpart').html(htmlTabla);
			});
		};		 

		function conmutarTodos(marcar){
			var rows = document.getElementById('listemp').getElementsByTagName('tr');

			for (i=0; i<=rows.length-1; i++) {
				var idemp = rows[i].id;
				if(marcar==0 && jQuery('#sel'+idemp).val()==1) selEmp(idemp);
				if(marcar==1 && jQuery('#sel'+idemp).val()==0) selEmp(idemp);
			}
		}
	</script>
@endsection