<?php
require_once __DIR__ . '/../conexion.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: index.php');
    exit;
}

$usuario_id = filter_input(INPUT_POST, 'usuario_id', FILTER_VALIDATE_INT);
$equipo_id = filter_input(INPUT_POST, 'equipo_id', FILTER_VALIDATE_INT);
$descripcion = trim($_POST['descripcion'] ?? '');

if ($usuario_id === false || $usuario_id === null || $usuario_id < 1
    || $equipo_id === false || $equipo_id === null || $equipo_id < 1
    || $descripcion === '') {
    header('Location: index.php?error=datos');
    exit;
}

$estado = 'Pendiente';
$observacion = '';
$sql = 'INSERT INTO solicitudes (usuario_id, equipo_id, descripcion_problema, estado, observacion) VALUES (?, ?, ?, ?, ?)';

try {
    $sentencia = mysqli_prepare($conexion, $sql);
    if ($sentencia === false) {
        error_log('Error al preparar solicitud: ' . mysqli_error($conexion));
        header('Location: index.php?error=guardar');
        exit;
    }

    mysqli_stmt_bind_param($sentencia, 'iisss', $usuario_id, $equipo_id, $descripcion, $estado, $observacion);
    mysqli_stmt_execute($sentencia);
} catch (mysqli_sql_exception $error) {
    error_log('Error al guardar solicitud: ' . $error->getMessage());
    header('Location: index.php?error=guardar');
    exit;
}

mysqli_stmt_close($sentencia);
header('Location: index.php?guardado=1');
exit;