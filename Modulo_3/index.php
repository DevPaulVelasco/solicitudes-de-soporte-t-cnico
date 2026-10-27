<?php
require_once __DIR__ . '/../conexion.php';

$sql = "SELECT solicitudes.id, usuarios.nombre AS usuario, equipos.nombre AS equipo,
               solicitudes.descripcion_problema, solicitudes.estado, solicitudes.observacion
        FROM solicitudes
        JOIN usuarios ON solicitudes.usuario_id = usuarios.id
        JOIN equipos ON solicitudes.equipo_id = equipos.id
        ORDER BY solicitudes.id DESC";
$consulta_solicitudes = mysqli_query($conexion, $sql);

if (!$consulta_solicitudes) {
    die("Error al consultar las solicitudes: " . htmlspecialchars(mysqli_error($conexion), ENT_QUOTES, 'UTF-8'));
}

$estados = array("Pendiente", "En proceso", "Resuelta");
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Módulo 3 - Seguimiento de solicitudes</title>
    <link rel="stylesheet" href="../css/estilos.css?v=4">
</head>
<body>
    <div class="layout">
        <?php include __DIR__ . '/../menu.php'; ?>
        <main class="container">
        <h2>Actualización y Seguimiento de Solicitudes</h2>

        <div style="overflow-x: auto;">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Usuario</th>
                        <th>Equipo</th>
                        <th>Descripción del problema</th>
                        <th>Estado actual</th>
                        <th>Observaciones técnicas</th>
                        <th>Acción</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (mysqli_num_rows($consulta_solicitudes) === 0) { ?>
                        <tr>
                            <td colspan="7">Aún no hay solicitudes. Registra una en el Módulo 2 para darle seguimiento.</td>
                        </tr>
                    <?php } else { ?>
                    <?php while ($solicitud = mysqli_fetch_assoc($consulta_solicitudes)) { ?>
                        <?php
                        $estado_actual = (string) $solicitud['estado'];
                        $opciones_estado = $estados;
                        if ($estado_actual !== '' && !in_array($estado_actual, $opciones_estado, true)) {
                            $opciones_estado[] = $estado_actual;
                        }
                        ?>
                        <tr>
                            <td><?php echo (int) $solicitud['id']; ?></td>
                            <td><?php echo htmlspecialchars((string) $solicitud['usuario'], ENT_QUOTES, 'UTF-8'); ?></td>
                            <td><?php echo htmlspecialchars((string) $solicitud['equipo'], ENT_QUOTES, 'UTF-8'); ?></td>
                            <td><?php echo nl2br(htmlspecialchars((string) $solicitud['descripcion_problema'], ENT_QUOTES, 'UTF-8')); ?></td>
                            <td><?php echo htmlspecialchars($estado_actual, ENT_QUOTES, 'UTF-8'); ?></td>
                            <td><?php echo nl2br(htmlspecialchars((string) $solicitud['observacion'], ENT_QUOTES, 'UTF-8')); ?></td>
                            <td>
                                <form action="actualizar.php" method="POST">
                                    <input type="hidden" name="id" value="<?php echo (int) $solicitud['id']; ?>">

                                    <label for="estado-<?php echo (int) $solicitud['id']; ?>">Nuevo estado:</label>
                                    <select name="estado" id="estado-<?php echo (int) $solicitud['id']; ?>" required>
                                        <?php foreach ($opciones_estado as $estado) { ?>
                                            <option value="<?php echo htmlspecialchars($estado, ENT_QUOTES, 'UTF-8'); ?>"<?php echo $estado === $estado_actual ? ' selected' : ''; ?>>
                                                <?php echo htmlspecialchars($estado, ENT_QUOTES, 'UTF-8'); ?>
                                            </option>
                                        <?php } ?>
                                    </select>

                                    <label for="observacion-<?php echo (int) $solicitud['id']; ?>">Observaciones técnicas:</label>
                                    <textarea name="observacion" id="observacion-<?php echo (int) $solicitud['id']; ?>" rows="3"><?php echo htmlspecialchars((string) $solicitud['observacion'], ENT_QUOTES, 'UTF-8'); ?></textarea>

                                    <button type="submit">Actualizar solicitud</button>
                                </form>
                            </td>
                        </tr>
                    <?php } ?>
                    <?php } ?>
                </tbody>
            </table>
            </main>
        </div>
</body>
</html>
<?php
mysqli_free_result($consulta_solicitudes);
mysqli_close($conexion);
?>
