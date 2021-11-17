@extends('layouts.app')

@section('content')
	<input type="hidden" id="idjefe"	value="{{ $jefe->id }}">
	<input type="hidden" id="cargo"		value="{{ $jefe->cargo }}">
	<input type="hidden" id="nombre"	value="{{ $jefe->nombre }}">
	<input type="hidden" id="idempresa"	value="0">
	<div class="container-fluid col-xl-12 col-md-12 col-12 p-0 card-title bg-dark">
		<table width="100%" class="table p-0 m-0">
			<tr>
				<td width="65%" class="pt-0 pb-0 border-0 flex-wrap">
					<h6>Listado de Departamentos asignados a<br>
						<span id="badge" data-toggle="tooltip"
							class="badge badge-success"
							style="cursor: default; font-size: 14px;">{{ $jefe->nombre }} [ {{ $jefe->cargo }} ]
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
			<div class="row col-12 col-md-12 col-xl-12 p-0 m-0 border border-dark">
				<table class="w-100">
					<tr>
						<td width="6%">Marcar</td>
						<td width="6%">
							<a href="#" onclick="conmutarTodos(1)">Todos</a>
						</td>
						<td width="6%">
							<a href="#" onclick="conmutarTodos(0)">Ninguno</a>
						</td>
						<td width="50%">
							<input type="text" name="filtroDpto" placeholder="Filtrar por nombre del departamento"
								class="form-control form-control-sm" id="filtroDpto">
				   		</td>
				   		<td width="42%" align="center">
							<span class="card bg-info text-light">Haga clic en un Departamento para asignarlo</span>
				   		</td>
					</tr>
				</table>
			</div>
		</div>
		<div class="row">
			<div class="col-lg-12 col-md-12 col-12 text-light bg-dark border border-info">
				<table class="table p-0 m-0">
					<tr>
						<td width = "5%" class="border-0 p-0 m-0 text-center">
							ID
						</td>
						<td width = "30%" class="border-0 p-0 m-0 text-center">
							Departamento
						</td>
						<td width = "25%" class="border-0 p-0 m-0 text-center">
							Jefe Asignado
						</td>
						<td width = "25%" class="border-0 p-0 m-0 text-center">
							Cargo Jefe Asignado
						</td>
						<td width = "15%" class="border-0 p-0 m-0 text-center">
							Cant. Empleados	
						</td>
					</tr>
				</table>
			</div>
		</div>
		<div id="TopeLista"></div>
		<div class="row">
			<div class="col-12 col-md-12 col-xl-12 contenido p-0 m-0 border border-primary" id="listadodpto">
			</div>
		</div>
	</div>

	<script>
		jQuery('document').ready(function(){
			jQuery('#empresas').val(0);
			jQuery('#filtroDpto').val('');
			setTimeout("resizeContenido('listadodpto', " + jQuery('#TopeLista').position().top + ")", 100);
			jQuery('#listadodpto').css('display', 'block');
			efecto();
		});

		function efecto(){
			if(jQuery('#idempresa').val()==0) {
				jQuery('#badge-emp').fadeToggle();
				jQuery('#badge-emp').fadeToggle();
				setTimeout("efecto()", 1000);
			}
		}
		
		jQuery('#empresas').on('change', function(){
			listarDptos(this.value);
			jQuery('#idempresa').val(this.value)
			efecto();
		});

		jQuery(window).resize(function(){
			setTimeout("resizeContenido('listadodpto', " + jQuery('#TopeLista').position().top + ")", 100);
			jQuery('#listadodpto').css('display', 'block');
		});

		jQuery('#filtroDpto').keydown(function(){
			vdpto = jQuery('#filtroDpto').val();
		});

		jQuery('#filtroDpto').keyup(function(){
			if(jQuery('#filtroDpto').val() != vdpto)
				filterDpto();
		});

		function resizeTables() {
			jQuery('#lstppal').css('height', (window.innerHeight)-jQuery('#TopeLista').position().top-3.6+'px');
			jQuery('#listadodpto').css('height', (window.innerHeight)-jQuery('#TopeLista').position().top-3.6+'px');
			jQuery('#lstemp').css('height', ((window.innerHeight)/1.4)-jQuery('#TopeLista').position().top+'px');
			jQuery('#lstpart').css('height', ((window.innerHeight)/2.26)-jQuery('#TopeLista').position().top+'px');

			jQuery('#listadodpto').css('display', 'block');
			jQuery('#lstppal').css('display', 'block');
			jQuery('#lstemp').css('display', 'block');
			jQuery('#lstpart').css('display', 'block');
		};

		function listarDptos(idempresa) {
			var idjefe = jQuery('#idjefe').val();
			if(idempresa!=0) {
				var htmlTabla = '<div class="text-center">' +
								'<h1>No Existen Departamentos Registrados para la Empresa</h1></div>';
				jQuery.get('/api/departamentos' + '/' + idempresa, function(data) {
					htmlTabla = '<table id="listdptos" class="table table-striped table-hover">';
					if(data.length>0) {
						for (i=0; i<data.length; ++i) {
							htmlTabla += '<tr id="'+data[i].id+'"';
							if(data[i].jefe!=null && data[i].id_jefe==jQuery('#idjefe').val()){
								htmlTabla += ' onclick="selDpto(this.id, ' + data[i].id_jefe + ')"';
								htmlTabla += ' class="resaltado">';
							} else {
								if(data[i].id_jefe!=jQuery('#idjefe').val() && data[i].jefe!=null) {
									htmlTabla += ' class="edo_suspendido">';
								} else {
									htmlTabla += ' onclick="selDpto(this.id, ' + data[i].id_jefe + ')">';
								}
							}
							htmlTabla += ' <input type="hidden" id="sel' + data[i].id + '" value="';
							if(data[i].id_jefe == idjefe){
								htmlTabla += '1';
							} else {
								htmlTabla += '0';
							}
							htmlTabla += '">';
							htmlTabla += ' <input type="hidden" id="idjefe' + data[i].id + '" value="';
							if(data[i].id_jefe != null){
								htmlTabla += data[i].id_jefe;
							} else {
								htmlTabla += 0;
							}
							htmlTabla += '">';
							htmlTabla += '	<td width="5%" class="text-left pb-1 pt-1">' + data[i].id + '</td>';
							htmlTabla += '	<td width="30%" class="text-left pb-1 pt-1">' + data[i].nombre + '</td>';
							htmlTabla += '	<td width="25%" class="text-left pb-1 pt-1" id="jefe' + data[i].id + '">';
											if(data[i].jefe!=null) {
												htmlTabla += data[i].jefe;
											}
							htmlTabla += '</td>';
							htmlTabla += '	<td width="25%" class="text-left pb-1 pt-1" id="cargo' + data[i].id + '">';
											if(data[i].jefe!=null) {
												htmlTabla += data[i].cargo;
											}
							htmlTabla += '</td>';
							htmlTabla += '	<td width="15%" class="text-center pb-1 pt-1">' + data[i].cant_empl + '</td>';
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

		function selDpto(iddpto, idjefe) {
			if(jQuery('#idjefe').val()!=idjefe && idjefe != null) {
				var mensaje = 'Desea reemplazar el jefe asigando:\n';
				mensaje    += '---> ' + jQuery('#jefe'+iddpto).html();
				mensaje    += '\nPor:\n';
				mensaje    += '---> ' + jQuery('#nombre').val();
				mensaje    += '\nEscriba Si o No';
				mensaje = prompt(mensaje, 'No').toUpperCase().trim();
				if(mensaje == 'SI')
					alert('si')
				else
					alert('no')
			}
			if( jQuery('#sel'+iddpto).val()==1 ) {
				jQuery('#sel'+iddpto).val(0);
				jQuery('#'+iddpto).removeClass('resaltado');
				conmutarJefe(iddpto, 0);
			} else {
				jQuery('#sel'+iddpto).val(1);
				jQuery('#'+iddpto).addClass('resaltado');
				conmutarJefe(iddpto, 1);
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
				var contIdR   = rows[i].cells[0].innerHTML.toLowerCase().trim();
				var contNameR = rows[i].cells[1].innerHTML.toLowerCase().trim(); 
				var contBossR = rows[i].cells[2].innerHTML.toLowerCase().trim(); 
				var contCharR = rows[i].cells[3].innerHTML.toLowerCase().trim(); 

				var show  = false;
				
				if(contName.length>0 && contIdR.indexOf(contName)>=0) show=true;
				if(contName.length>0 && contNameR.indexOf(contName)>=0) show=true;
				if(contName.length>0 && contBossR.indexOf(contName)>=0) show=true;
				if(contName.length>0 && contCharR.indexOf(contName)>=0) show=true;

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

		function conmutarJefe(iddpto,  accion) {
			var idjefe = jQuery('#idjefe').val();
			var idempresa = jQuery('#idempresa').val();
			jQuery.ajaxSetup({ headers: { 'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content') } });
			jQuery.ajax({
				url: "{{ url('/api/conmutarJefe') }}" + '/' + iddpto + '/' + idjefe + '/' + idempresa + '/' + accion,
				method: "post",
				success: function(result) {
					jQuery('#jefe'+iddpto).html(result.nombre);
					jQuery('#cargo'+iddpto).html(result.cargo);		
				}
			});
		};

		function conmutarTodos(marcar){
			var rows = document.getElementById('listdptos').getElementsByTagName('tr');

			for (i=0; i<=rows.length-1; i++) {
				var iddpto = rows[i].id;
				var aplica = 0;
				var idjefe = jQuery('#idjefe'+iddpto).val();
				var jefeac = jQuery('#idjefe').val()
				// primero se valida que no tenga un jefe asignado
				if(idjefe==0) { aplica = 1; }

				// si tiene jefe asignado se valida que sea el mismo seleccionado
				if(idjefe!=0 && idjefe==jefeac) { aplica = 1; }
				
				// si se cumplen las validaciones anteriores se realiza la accion solicitada
				if(aplica==1) {
					if(marcar==0 && jQuery('#sel'+iddpto).val()==1) selDpto(iddpto);
					if(marcar==1 && jQuery('#sel'+iddpto).val()==0) selDpto(iddpto);
				}
			}
		}
	</script>
@endsection