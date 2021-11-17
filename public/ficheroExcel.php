<?php
$nombre_archivo = $_POST['nombre_archivo'];
header("Content-type: application/excel");
header("Content-Disposition: filename=$nombre_archivo");
header("Pragma: no-cache");
header("Expires: 0");

$datos_recebido = iconv('utf-8','iso-8859-1',$_POST['datos_a_enviar']);
echo $datos_recebido;
?>