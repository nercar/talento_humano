<?php 

$db_port = '3306';
// Datos para conexión a intranet
$db_host_i = '192.168.8.253';
$db_database_i = 'iso_policlinica';
$db_username_i = 'politach';
$db_password_i = 'politach';

// Datos para conexión a intranet TH
$db_host_t = 'localhost';
$db_database_t = 'politach';
$db_username_t = 'politach';
$db_password_t = 'Pth.1938-Int';

$conectar_i = mysqli_connect($db_host_i, $db_username_i, $db_password_i);
$conectar_t = mysqli_connect($db_host_t, $db_username_t, $db_password_t);

if ($conectar_i && $conectar_t)
{
	$file = fopen('actJefInt.txt', 'w');
	
	fputs($file, str_repeat('=', 100).chr(10));
	fputs($file, 'Sincronizacion de Cargos tipo Jefe al '.date("d-m-Y [h:i:s a]").chr(10));
	fputs($file, 'Se sincronizaran los siguientes Jefes de area'.chr(10).chr(10));

	mysqli_select_db($conectar_i, $db_database_i);

	$query_i = "SELECT Codigo, Nombre, Login, Eliminado FROM cargos
				WHERE Login IS NOT NULL AND Jefe >= 1
				ORDER BY Nombre";

	$resultado_i = mysqli_query($conectar_i, $query_i);

	fputs($file, '+'.str_repeat('-', 98).'+'.chr(10));
	fputs($file, '|'.str_pad('Codigo', 11).'|'.str_pad('Login', 30).'|'.str_pad('Nombre del Usuario Jefe', 55).'|'.chr(10));
	fputs($file, '+'.str_repeat('-', 98).'+'.chr(10));

	while($jefe_i = mysqli_fetch_object($resultado_i)) {
		mysqli_select_db($conectar_t, $db_database_t);
		$query_t = "SELECT id, login, nombre, activo FROM jefes_departamentos WHERE id = ".$jefe_i->Codigo;
		
		$resultado_t = mysqli_query($conectar_t, $query_t);
		$update = 0;
		$texto = '';

		if(mysqli_num_rows($resultado_t)==0){
			$query_t = "INSERT INTO jefes_departamentos(id, login, nombre, activo, created_at)
					  	VALUES(".$jefe_i->Codigo.", '".$jefe_i->Login."', '".$jefe_i->Nombre."', ".$jefe_i->Eliminado.", CURDATE());";
			if(!mysqli_query($conectar_t, $query_t)) {
				echo mysqli_error($conectar_t);
			} else {
				$texto = '|'.str_pad($jefe_i->Codigo, 11).
			 			 '|'.str_pad($jefe_i->Login, 30).
			 			 '|'.str_pad($jefe_i->Nombre, 51).
			 			 '| I |';
			}
		} else {
			$datos = mysqli_fetch_object($resultado_t);
			if($datos->login != $jefe_i->Login) { $update = 1; }
			if($datos->nombre != $jefe_i->Nombre) { $update = 1; }
			if($datos->activo != $jefe_i->Eliminado) { $update = 1; }
			if($update==1) {
				$query_t = "UPDATE jefes_departamentos
							SET login='".$jefe_i->Login."',
								nombre='".$jefe_i->Nombre."',
								activo='".$jefe_i->Eliminado."',
								updated_at = CURDATE()
							WHERE id = ".$jefe_i->Codigo.";";
				if(!mysqli_query($conectar_t, $query_t)) {
					echo mysqli_error($conectar_t);
				} else {
					$texto = '|'.str_pad($jefe_i->Codigo, 11).
		 					 '|'.str_pad($jefe_i->Login, 30).
		 			 		 '|'.str_pad($jefe_i->Nombre, 51).
				 			 '| U |';
				}
			}
		}

		if($texto!='') { fputs($file, $texto.chr(10)); }
		
	 	mysqli_select_db($conectar_i, $db_database_i);
	}

	fputs($file, '+'.str_repeat('-', 98).'+'.chr(10));

	fputs($file, str_repeat('=', 100).chr(10));

	fclose($file);

	mysqli_close($conectar_i);
	mysqli_close($conectar_t);
}
?>