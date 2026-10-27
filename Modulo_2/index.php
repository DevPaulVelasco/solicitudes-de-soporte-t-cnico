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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Módulo 2 - Solicitudes</title>
    <link rel="stylesheet" href="../css/estilos.css?v=4">
</head>
<body>
    <div class="layout">
        <?php include __DIR__ . '/../menu.php'; ?>
        <main class="container">
        <h2>Registrar Solicitud de Soporte</h2>

        <?php if (isset($_GET['guardado'])): ?>
            <p role="status">Solicitud guardada correctamente.</p>
        <?php elseif (isset($_GET['error']) && $_GET['error'] === 'datos'): ?>
            <p role="alert">Selecciona un usuario y un equipo, y escribe la descripción del problema.</p>
        <?php elseif (isset($_GET['error']) && $_GET['error'] === 'guardar'): ?>
            <p role="alert">No se pudo guardar la solicitud. Revisa la conexión y la base de datos, e inténtalo de nuevo.</p>
        <?php endif; ?>

        <form action="guardar_solicitud.php" method="POST" onsubmit="return validar()">
            
            <!-- Lista desplegable de Usuarios -->
            <label>Seleccionar Usuario:</label>
            <select name="usuario_id" id="usuario_id" required>
                <option value="">-- Selecciona un usuario --</option>
                <?php
                // Recorremos los usuarios uno por uno
                while ($fila_usuario = mysqli_fetch_array($consulta_usuarios)) {
                    $id_usuario = $fila_usuario['id'];
                    $nombre_usuario = $fila_usuario['nombre'];
                ?>
                    <option value="<?php echo $id_usuario; ?>">
                        <?php echo htmlspecialchars((string) $nombre_usuario, ENT_QUOTES, 'UTF-8'); ?>
                    </option>
                <?php
                }
                ?>
            </select>

            <!-- Lista desplegable de Equipos -->
            <label>Seleccionar Equipo:</label>
            <select name="equipo_id" id="equipo_id" required>
                <option value="">-- Selecciona un equipo --</option>
                <?php
                // Recorremos los equipos uno por uno
                while ($fila_equipo = mysqli_fetch_array($consulta_equipos)) {
                    $id_equipo = $fila_equipo['id'];
                    $nombre_equipo = $fila_equipo['nombre'];
                ?>
                    <option value="<?php echo $id_equipo; ?>">
                        <?php echo htmlspecialchars((string) $nombre_equipo, ENT_QUOTES, 'UTF-8'); ?>
                    </option>
                <?php
                }
                ?>
            </select>

            <label>Descripción del Problema:</label>
            <textarea name="descripcion" id="descripcion" rows="3" required></textarea>

            <button type="submit">Guardar Solicitud</button>
        </form>

        <hr>

        <h2>Consultar Solicitudes</h2>
        <table border="1">
            <thead>
            <tr>
                <th>ID</th>
                <th>Usuario</th>
                <th>Equipo</th>
                <th>Descripción</th>
                <th>Estado</th>
            </tr>
            </thead>
            <tbody>
            <?php
            // Recorremos cada solicitud registrada y la mostramos en la tabla
            if (mysqli_num_rows($consulta_solicitudes) === 0) {
                echo '<tr><td colspan="5">Aún no hay solicitudes registradas.</td></tr>';
            }
            while ($fila = mysqli_fetch_array($consulta_solicitudes)) {
                $id = $fila['id'];
                $usuario = $fila['usuario'];
                $equipo = $fila['equipo'];
                $descripcion = $fila['descripcion_problema'];
                $estado = $fila['estado'];
            ?>
                <tr>
                    <td><?php echo (int) $id; ?></td>
                    <td><?php echo htmlspecialchars((string) $usuario, ENT_QUOTES, 'UTF-8'); ?></td>
                    <td><?php echo htmlspecialchars((string) $equipo, ENT_QUOTES, 'UTF-8'); ?></td>
                    <td><?php echo nl2br(htmlspecialchars((string) $descripcion, ENT_QUOTES, 'UTF-8')); ?></td>
                    <td><?php echo htmlspecialchars((string) $estado, ENT_QUOTES, 'UTF-8'); ?></td>
                </tr>
            <?php
            }
            ?>
            </tbody>
        </table>
        </main>
    </div>

    <script src="validar.js"></script>
</body>
</html>