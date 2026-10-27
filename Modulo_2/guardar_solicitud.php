<?php
include("../conexion.php");

// Recibimos los datos enviados por el formulario
$usuario_id = $_POST['usuario_id'];
$equipo_id = $_POST['equipo_id'];
$descripcion = $_POST['descripcion'];
$estado = "Pendiente";

// Verificamos que no vengan vacíos
if ($usuario_id != "" && $equipo_id != "" && $descripcion != "") {

    // Consulta para insertar
    $sql = "INSERT INTO solicitudes (usuario_id, equipo_id, descripcion_problema, estado) 
            VALUES ('$usuario_id', '$equipo_id', '$descripcion', '$estado')";

    // Ejecutamos la consulta
    $resultado = mysqli_query($conexion, $sql);

    // Si se guardó correctamente, regresamos a la pantalla principal
    if ($resultado) {
        header("Location: index.php");
    } else {
        echo "Error al guardar: " . mysqli_error($conexion);
    }

} else {
    echo "Faltan datos obligatorios por llenar.";
}

// Cerramos la conexión
mysqli_close($conexion);
?>