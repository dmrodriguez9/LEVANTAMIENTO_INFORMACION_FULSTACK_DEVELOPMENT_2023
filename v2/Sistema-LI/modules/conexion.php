<?php
date_default_timezone_set('America/Guayaquil');

$conexion = mysqli_connect("localhost", "root", "Michael64", "db_school");

if (mysqli_connect_errno()) {
	printf("Falló la conexión a la base de datos: %s\n", mysqli_connect_error());
	exit();
}

mysqli_set_charset($conexion, 'utf8');