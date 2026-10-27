<?php
require_once __DIR__ . '/../conexion.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    exit('Método no permitido.');
}

if (!isset($_POST['id'], $_POST['estado'], $_POST['observacion'])) {
    http_response_code(400);
    exit('Faltan datos obligatorios para actualizar la solicitud.');
}

if (!is_string($_POST['estado']) || !is_string($_POST['observacion'])) {
    http_response_code(400);
    exit('Los datos enviados no son válidos.');
}

$id = filter_var($_POST['id'], FILTER_VALIDATE_INT);
$estado = trim($_POST['estado']);
$observacion = trim($_POST['observacion']);

if ($id === false || $id < 1 || $estado === '' || strlen($estado) > 50) {
    http_response_code(400);
    exit('Los datos enviados no son válidos.');
}

$sql = "UPDATE solicitudes SET estado = ?, observacion = ? WHERE id = ?";
$sentencia = mysqli_prepare($conexion, $sql);

if (!$sentencia) {
    http_response_code(500);
    exit("Error al preparar la actualización: " . htmlspecialchars(mysqli_error($conexion), ENT_QUOTES, 'UTF-8'));
}

mysqli_stmt_bind_param($sentencia, "ssi", $estado, $observacion, $id);

if (!mysqli_stmt_execute($sentencia)) {
    http_response_code(500);
    $error = mysqli_stmt_error($sentencia);
    mysqli_stmt_close($sentencia);
    mysqli_close($conexion);
    exit("Error al actualizar la solicitud: " . htmlspecialchars($error, ENT_QUOTES, 'UTF-8'));
}

mysqli_stmt_close($sentencia);
mysqli_close($conexion);

header("Location: index.php");
exit;
?>
