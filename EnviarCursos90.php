<?php 

// Import PHPMailer classes into the global namespace
// These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader
require 'vendor/autoload.php';

$todos_los_datos=file('.env', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
$db_connection = '';
$db_host = '';
$db_port = '';
$db_database = '';
$db_username = '';
$db_password = '';
$mail_host = '';
$mail_port = '';
$mail_username = '';
$mail_password = '';
$mail_encryption = '';
for($i=0;$i<count($todos_los_datos);$i++){
	$linea = rtrim($todos_los_datos[$i]);
	$resultado = strpos($linea, 'DB_CONNECTION');
	if($resultado !== false){
		$resultado = strpos($linea, '=');
		$db_connection = substr($linea, $resultado + 1);
	}
	$resultado = strpos($linea, 'DB_HOST');
	if($resultado !== false){
		$resultado = strpos($linea, '=');
		$db_host = substr($linea, $resultado + 1);
	}
	$resultado = strpos($linea, 'DB_PORT');
	if($resultado !== false){
		$resultado = strpos($linea, '=');
		$db_port = substr($linea, $resultado + 1);
	}
	$resultado = strpos($linea, 'DB_DATABASE');
	if($resultado !== false){
		$resultado = strpos($linea, '=');
		$db_database = substr($linea, $resultado + 1);
	}
	$resultado = strpos($linea, 'DB_USERNAME');
	if($resultado !== false){
		$resultado = strpos($linea, '=');
		$db_username = substr($linea, $resultado + 1);
	}
	$resultado = strpos($linea, 'DB_PASSWORD');
	if($resultado !== false){
		$resultado = strpos($linea, '=');
		$db_password = substr($linea, $resultado + 1);
	}
	$resultado = strpos($linea, 'MAIL_HOST');
	if($resultado !== false){
		$resultado = strpos($linea, '=');
		$mail_host = substr($linea, $resultado + 1);
	}
	$resultado = strpos($linea, 'MAIL_PORT');
	if($resultado !== false){
		$resultado = strpos($linea, '=');
		$mail_port = substr($linea, $resultado + 1);
	}
	$resultado = strpos($linea, 'MAIL_USERNAME');
	if($resultado !== false){
		$resultado = strpos($linea, '=');
		$mail_username = substr($linea, $resultado + 1);
	}
	$resultado = strpos($linea, 'MAIL_PASSWORD');
	if($resultado !== false){
		$resultado = strpos($linea, '=');
		$mail_password = substr($linea, $resultado + 1);
	}
	$resultado = strpos($linea, 'MAIL_ENCRYPTION');
	if($resultado !== false){
		$resultado = strpos($linea, '=');
		$mail_encryption = substr($linea, $resultado + 1);
	}
}

$conectar = mysqli_connect($db_host, $db_username, $db_password);
if ($conectar)
{
	$file = fopen('verCurEnv90.txt', 'w');
	
	fputs($file, str_repeat('=', 100) . chr(10));
	fputs($file, 'Enviar cursos que al ' . date("d-m-Y [h:i:s a]") . ' tienen 90 días' . chr(10) . chr(10));
	fputs($file, 'Se enviaron los siguientes cursos para la evaluación respectiva del Jefe de área' . chr(10).chr(10));

	$uniqueid= uniqid('Be50e8a58F');
	$asunto = 'Adiestramiento de Personal pendiente por Evaluar!!';
	$departamento = '';
	$idcurso = '';
	$saludo = '';
	$detalle = '';
	$envultimo = false;
	$idcursoIn = '';
	$nombreCurso = '';

	mysqli_select_db($conectar, $db_database);

	$fechahoy = strtotime(date('Y-m-d'));
	$query = "SELECT
				PC.DEPARTAMENTO AS departamento,
				C.ID AS id_curso,
				C.NOMBRE AS curso,
				C.FECHA_DESDE AS fecha,
				CONCAT(PC.NOMEMP, ' ', PC.APEEMP) AS nombre,
				PC.NOMCAR AS cargo
			FROM PARTICIPANTESCURSOS PC
			INNER JOIN CURSOS C ON PC.ID_CURSO = C.ID
			WHERE C.ESTADO = 2
			AND !C.SUSPENDER AND C.ENVIADO IS NULL
			AND DATEDIFF(CURDATE() , C.Fecha_DESDE) BETWEEN 90 AND 96
			ORDER BY PC.DEPARTAMENTO, C.FECHA_DESDE, PC.NOMEMP, PC.APEEMP";

	$resultado = mysqli_query($conectar, $query);

	if(mysqli_num_rows($resultado)>0) {
		fputs($file, 'Se procesaran' . mysqli_num_rows($resultado) . ' registros');
		while($curso = mysqli_fetch_object($resultado)) {
			if($departamento!=$curso->departamento) {
				$correo = 'ramirez_carlos@policlinicatachira.com';
				$receptor = utf8_decode('Carlos Ramírez');
				if($departamento!='') {
					$message  = $saludo . $detalle . '<br><br>';
					$message .= "Se le recuerda que tiene 7 días, como máximo, para realizar dichas ";
					$message .= "evaluaciones.<br><br>";
					$message .= "Agradeciendo el tiempo que le dedique a la actividad, ";
					$message .= "el Departamento de Talento Humano queda atento a sus comentarios,<br><br>";
					$message .= "Saludos Cordiales .-";
					$message .= '</font></p>';
					$message .= '<hr><p style="text-align: justify; padding: 0px; margin : 0px">';
					$message .= '<font face="Verdana,arial" size=1>';
					$message .= "<b>Nota de Confidencialidad de Datos:</b> La presente comunicación electrónica y ";
					$message .= "sus adjuntos, es privilegiada entre clientes internos y/o externos del emisor, está ";
					$message .= "protegida por las leyes que regulan la materia y contiene información confidencial ";
					$message .= "dirigida únicamente  a la(s) persona(s) destinataria (s). El uso, la distribución, ";
					$message .= "copia y/o exhibición de la información contenida en el presente mensaje, está ";
					$message .= "estrictamente prohibida, ya que la misma es propiedad de la empresa y  no puede ser ";
					$message .= "reproducida, editada y/o alterada sin su consentimiento, toda vez que está prohibido ";
					$message .= "por Ley. Toda violación a esta nota de confidencialidad, será motivo para intentar o ";
					$message .= "solicitar una acción civil en contra del infractor. Si usted ha recibido el mensaje ";
					$message .= "por error, por favor destrúyalo o elimine cualquier copia guardada en su sistema y ";
					$message .= "notifique inmediatamente al emisor y después debe borrarlo de su correo.";
					$message .= '</p><hr>';
					$message .= "--" . $uniqueid. "--";
					$message  = utf8_decode($message);
					enviarMail(
						$file,
						$mail_host,
						$mail_port,
						$mail_username,
						$mail_password,
						$mail_encryption,
						$message,
						$correo,
						$receptor,
						$asunto);

					fputs($file, $departamento . ': ' . chr(10) . chr(9) . substr($nombreCurso, 0, -2) . '.' . chr(10));
					$nombreCurso = '';

					$envultimo = true;
				}

				$departamento = $curso->departamento;
				$idcurso = $curso->id_curso;

				if(strrpos($nombreCurso, $curso->curso) === false) $nombreCurso .= $curso->curso.chr(10).chr(9);
				if(strrpos($idcursoIn, "'".$idcurso."'") === false) $idcursoIn .= "'" . $idcurso . "',";

				$detalle = '<br><b>"' . utf8_encode($curso->curso) . '"</b> de fecha <b>' . $curso->fecha . '</b><br>';
				$detalle.= utf8_encode('<blockquote>' . $curso->nombre . ' (<i>' . $curso->cargo . '</i>)</blockquote>');

				$saludo  = '<p style="text-align: justify"><font face="Verdana,arial" size=3>';
				$saludo .= 'Buen día, Jefe de ' . $curso->departamento . '<br><br>';
				$saludo .= 'Talento Humano le informa que tiene <b>Adiestramientos de Personal</b> ';
				$saludo .= 'de su área pendientes por evaluar, por favor ingresar a ';
				$saludo .= 'http://intranet.pth.th en la opción <b>Cursos Pendientes por Evaluar</b>, ';
				$saludo .= 'allí encontrará una lista de adiestramientos que se impartieron a ';
				$saludo .= 'empleados de su departamento, hacer clic en la Opción <b>Evaluar</b>, ';
				$saludo .= 'ingresar la información solicitada por la aplicación y guardar la ';
				$saludo .= 'misma para que esté disponible para el personal de Talento Humano.<br><br>';
				$saludo .= 'Información detallada:<br><br>';
			} else {
				if($idcurso != $curso->id_curso) {
					$idcurso = $curso->id_curso;
					if(strrpos($nombreCurso, $curso->curso) === false) $nombreCurso .= $curso->curso.chr(10).chr(9);
					if(strrpos($idcursoIn, "'".$idcurso."'") === false) $idcursoIn .= "'" . $idcurso . "',";
					$detalle.= '<br><b>"' . utf8_encode($curso->curso) . '"</b> de fecha <b>' . $curso->fecha . '</b><br>';
				}
				$detalle.=utf8_encode('<blockquote>' . $curso->nombre . ' (<i>' . $curso->cargo . '</i>)</blockquote>');
			}
		}
	}

	if($envultimo) {
		$correo = 'ramirez_carlos@policlinicatachira.com';
		$receptor = utf8_decode('Carlos Ramírez');
		$message  = $saludo . $detalle . '<br><br>';
		$message .= "Se le recuerda que tiene 7 días, como máximo, para realizar dichas ";
		$message .= "evaluaciones.<br><br>";
		$message .= "Agradeciendo el tiempo que le dedique a la actividad, ";
		$message .= "el Departamento de Talento Humano queda atento a sus comentarios,<br><br>";
		$message .= "Saludos Cordiales .-";
		$message .= '</font></p>';
		$message .= '<hr><p style="text-align: justify; padding: 0px; margin : 0px">';
		$message .= '<font face="Verdana,arial" size=1>';
		$message .= "<b>Nota de Confidencialidad de Datos:</b> La presente comunicación electrónica y ";
		$message .= "sus adjuntos, es privilegiada entre clientes internos y/o externos del emisor, está ";
		$message .= "protegida por las leyes que regulan la materia y contiene información confidencial ";
		$message .= "dirigida únicamente  a la(s) persona(s) destinataria (s). El uso, la distribución, ";
		$message .= "copia y/o exhibición de la información contenida en el presente mensaje, está ";
		$message .= "estrictamente prohibida, ya que la misma es propiedad de la empresa y  no puede ser ";
		$message .= "reproducida, editada y/o alterada sin su consentimiento, toda vez que está prohibido ";
		$message .= "por Ley. Toda violación a esta nota de confidencialidad, será motivo para intentar o ";
		$message .= "solicitar una acción civil en contra del infractor. Si usted ha recibido el mensaje ";
		$message .= "por error, por favor destrúyalo o elimine cualquier copia guardada en su sistema y ";
		$message .= "notifique inmediatamente al emisor y después debe borrarlo de su correo.";
		$message .= '</p><hr>';
		$message .= "--" . $uniqueid. "--";
		$message  = utf8_decode($message);
		$correo = 'ramirez_carlos@policlinicatachira.com';
		$receptor = utf8_decode('Carlos Ramírez');
		enviarMail(
			$file,
			$mail_host,
			$mail_port,
			$mail_username,
			$mail_password,
			$mail_encryption,
			$message,
			$correo,
			$receptor,
			$asunto);
		
		fputs($file, $departamento . ': ' . chr(10) . chr(9) . substr($nombreCurso, 0, -2) . '.' . chr(10));
		$nombreCurso = '';
	}

	$idcursoIn = substr($idcursoIn, 0, -1);

	if($idcursoIn!='') {
		fputs($file, str_repeat('=', 100) . chr(10));
		if(mysqli_query($conectar, "UPDATE cursos SET estado = 3, enviado = CURDATE() WHERE id IN(" . $idcursoIn .");")) {
			fputs($file, 'ID Cursos Modificados: ' . $idcursoIn . chr(10));
		} else {
			fputs($file, 'Errores al modificar: '. mysqli_error($conectar) . chr(10));
		}
	}

	fputs($file, str_repeat('=', 100) . chr(10));

	fclose($file);

	mysqli_close($conectar);
}

function enviarMail($mFile, $mHost, $mPort, $mUsername, $mPassword, $mEncryption, $mMessage, $mCorreo, $mReceptor, $mAsunto){
	$mail = new PHPMailer(true);							  // Passing `true` enables exceptions
	try {
		//Server settings
		$mail->SMTPDebug = 2;							   // Enable verbose debug output
		$mail->isSMTP();									// Set mailer to use SMTP
		$mail->Host = $mHost . ';' . $mHost;		  		// Specify main and backup SMTP servers
		$mail->SMTPAuth = true;							 // Enable SMTP authentication
		$mail->Username = $mUsername;						// SMTP username
		$mail->Password = $mPassword;						// SMTP password
		$mail->SMTPSecure = $mEncryption;					// Enable TLS encryption, `ssl` also accepted
		$mail->Port = $mPort;							   // TCP port to connect to

		//Recipients
		$mail->setFrom($mUsername, 'Intranet Tecnologia TI');
		$mail->addAddress($mCorreo, $mReceptor);	 // Add a recipient

		//Content
		$mail->isHTML(true);								  // Set email format to HTML
		$mail->Subject = $mAsunto;
		$mail->Body	= $mMessage;
		$mail->AltBody = $mMessage;

		$mail->send();
		fputs($mFile, 'Mensaje Enviado' . chr(10));
	} catch (Exception $e) {
		fputs($mFile, 'No se nvio por lo siguiete: ' . $mail->ErrorInfo . chr(10));
	}
}

?>