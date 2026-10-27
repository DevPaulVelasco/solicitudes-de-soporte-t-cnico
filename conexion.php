<?php
$host = "localhost";
$user = "root";
$password = "";
$dbname = "soporte_tecnico";

$conexion = new mysqli($host, $user, $password, $dbname);

if ($conexion->connect_error) {
    die("Error de conexión a la base de datos: " . $conexion->connect_error);
}

$conexion->set_charset("utf8");
?>