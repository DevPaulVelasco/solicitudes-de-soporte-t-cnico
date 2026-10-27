
<?php
require_once __DIR__ . '/../conexion.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: index.php');
    exit;
}

$tipo = $_POST['tipo'] ?? '';
$nombre = trim($_POST['nombre'] ?? '');

if ($nombre === '') {
    header('Location: index.php?error=datos');
    exit;
}

if ($tipo === 'usuario') {
    $correo = trim($_POST['correo'] ?? '');
    if ($correo === '') {
        header('Location: index.php?error=datos');
        exit;
    }

    $consulta = mysqli_prepare($conexion, 'INSERT INTO usuarios (nombre, correo) VALUES (?, ?)');
    if ($consulta === false) {
        die('Error al preparar el registro de usuario: ' . htmlspecialchars(mysqli_error($conexion), ENT_QUOTES, 'UTF-8'));
    }
    mysqli_stmt_bind_param($consulta, 'ss', $nombre, $correo);
} elseif ($tipo === 'equipo') {
    $descripcion = trim($_POST['descripcion'] ?? '');
    if ($descripcion === '') {
        header('Location: index.php?error=datos');
        exit;
    }

    $consulta = mysqli_prepare($conexion, 'INSERT INTO equipos (nombre, descripcion) VALUES (?, ?)');
    if ($consulta === false) {
        die('Error al preparar el registro de equipo: ' . htmlspecialchars(mysqli_error($conexion), ENT_QUOTES, 'UTF-8'));
    }
    mysqli_stmt_bind_param($consulta, 'ss', $nombre, $descripcion);
} else {
    header('Location: index.php?error=datos');
    exit;
}

if (!mysqli_stmt_execute($consulta)) {
    die('Error al guardar el registro: ' . htmlspecialchars(mysqli_stmt_error($consulta), ENT_QUOTES, 'UTF-8'));
}

mysqli_stmt_close($consulta);
header('Location: index.php?guardado=' . urlencode($tipo));
exit;
