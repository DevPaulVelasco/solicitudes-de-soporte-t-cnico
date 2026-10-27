<?php
// 1. Incluimos el archivo de conexión
include("../conexion.php");

// 2. Hacemos las consultas a la base de datos de manera tradicional
$consulta_usuarios = mysqli_query($conexion, "SELECT id, nombre FROM usuarios");
$consulta_equipos = mysqli_query($conexion, "SELECT id, nombre FROM equipos");

// 3. Consulta para ver las solicitudes con el nombre del usuario y del equipo
$sql = "SELECT solicitudes.id, usuarios.nombre AS usuario, equipos.nombre AS equipo, solicitudes.descripcion_problema, solicitudes.estado 
        FROM solicitudes
        JOIN usuarios ON solicitudes.usuario_id = usuarios.id
        JOIN equipos ON solicitudes.equipo_id = equipos.id";

$consulta_solicitudes = mysqli_query($conexion, $sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Módulo 2 - Solicitudes</title>
    <link rel="stylesheet" href="../css/estilos.css">
</head>
<body>
    <div class="container">
        <h2>Registrar Solicitud de Soporte</h2>

        <form action="guardar_solicitud.php" method="POST" onsubmit="return validar()">
            
            <!-- Lista desplegable de Usuarios -->
            <label>Seleccionar Usuario:</label>
            <select name="usuario_id" id="usuario_id">
                <option value="">-- Selecciona un usuario --</option>
                <?php
                // Recorremos los usuarios uno por uno
                while ($fila_usuario = mysqli_fetch_array($consulta_usuarios)) {
                    $id_usuario = $fila_usuario['id'];
                    $nombre_usuario = $fila_usuario['nombre'];
                ?>
                    <option value="<?php echo $id_usuario; ?>">
                        <?php echo $nombre_usuario; ?>
                    </option>
                <?php
                }
                ?>
            </select>

            <!-- Lista desplegable de Equipos -->
            <label>Seleccionar Equipo:</label>
            <select name="equipo_id" id="equipo_id">
                <option value="">-- Selecciona un equipo --</option>
                <?php
                // Recorremos los equipos uno por uno
                while ($fila_equipo = mysqli_fetch_array($consulta_equipos)) {
                    $id_equipo = $fila_equipo['id'];
                    $nombre_equipo = $fila_equipo['nombre'];
                ?>
                    <option value="<?php echo $id_equipo; ?>">
                        <?php echo $nombre_equipo; ?>
                    </option>
                <?php
                }
                ?>
            </select>

            <label>Descripción del Problema:</label>
            <textarea name="descripcion" id="descripcion" rows="3"></textarea>

            <button type="submit">Guardar Solicitud</button>
        </form>

        <hr>

        <h2>Consultar Solicitudes</h2>
        <table border="1">
            <tr>
                <th>ID</th>
                <th>Usuario</th>
                <th>Equipo</th>
                <th>Descripción</th>
                <th>Estado</th>
            </tr>

            <?php
            // Recorremos cada solicitud registrada y la mostramos en la tabla
            while ($fila = mysqli_fetch_array($consulta_solicitudes)) {
                $id = $fila['id'];
                $usuario = $fila['usuario'];
                $equipo = $fila['equipo'];
                $descripcion = $fila['descripcion_problema'];
                $estado = $fila['estado'];
            ?>
                <tr>
                    <td><?php echo $id; ?></td>
                    <td><?php echo $usuario; ?></td>
                    <td><?php echo $equipo; ?></td>
                    <td><?php echo $descripcion; ?></td>
                    <td><?php echo $estado; ?></td>
                </tr>
            <?php
            }
            ?>
        </table>
    </div>

    <script src="validar.js"></script>
</body>
</html>