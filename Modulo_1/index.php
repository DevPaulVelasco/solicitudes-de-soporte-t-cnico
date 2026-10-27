<?php
require_once __DIR__ . '/../conexion.php';

$consultaUsuarios = mysqli_query($conexion, 'SELECT id, nombre, correo FROM usuarios ORDER BY id DESC');
if ($consultaUsuarios === false) {
    die('Error al consultar usuarios: ' . htmlspecialchars(mysqli_error($conexion), ENT_QUOTES, 'UTF-8'));
}

$consultaEquipos = mysqli_query($conexion, 'SELECT id, nombre, descripcion FROM equipos ORDER BY id DESC');
if ($consultaEquipos === false) {
    die('Error al consultar equipos: ' . htmlspecialchars(mysqli_error($conexion), ENT_QUOTES, 'UTF-8'));
}

function escapar($valor)
{
    return htmlspecialchars((string) $valor, ENT_QUOTES, 'UTF-8');
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Catálogos de Usuarios y Equipos</title>
    <link rel="stylesheet" href="../css/estilos.css">
</head>
<body>
    <main class="container">
        <h1>Catálogos de Usuarios y Equipos</h1>

        <?php if (isset($_GET['error']) && $_GET['error'] === 'datos'): ?>
            <p role="alert">Completa todos los campos antes de enviar el formulario.</p>
        <?php endif; ?>

        <section aria-labelledby="titulo-usuario">
            <h2 id="titulo-usuario">Registrar Usuario</h2>
            <form action="guardar.php" method="POST">
                <input type="hidden" name="tipo" value="usuario">

                <label for="usuario-nombre">Nombre</label>
                <input type="text" id="usuario-nombre" name="nombre" maxlength="100" required>

                <label for="usuario-correo">Correo</label>
                <input type="email" id="usuario-correo" name="correo" maxlength="100" required>

                <button type="submit">Guardar Usuario</button>
            </form>
        </section>

        <hr>

        <section aria-labelledby="titulo-equipo">
            <h2 id="titulo-equipo">Registrar Equipo</h2>
            <form action="guardar.php" method="POST">
                <input type="hidden" name="tipo" value="equipo">

                <label for="equipo-nombre">Nombre</label>
                <input type="text" id="equipo-nombre" name="nombre" maxlength="100" required>

                <label for="equipo-descripcion">Descripción</label>
                <textarea id="equipo-descripcion" name="descripcion" rows="4" required></textarea>

                <button type="submit">Guardar Equipo</button>
            </form>
        </section>

        <hr>

        <section aria-labelledby="usuarios-registrados">
            <h2 id="usuarios-registrados">Usuarios Registrados</h2>
            <table>
                <thead>
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Nombre</th>
                        <th scope="col">Correo</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (mysqli_num_rows($consultaUsuarios) === 0): ?>
                        <tr><td colspan="3">Aún no hay usuarios registrados.</td></tr>
                    <?php else: ?>
                        <?php while ($usuario = mysqli_fetch_assoc($consultaUsuarios)): ?>
                            <tr>
                                <td><?= escapar($usuario['id']) ?></td>
                                <td><?= escapar($usuario['nombre']) ?></td>
                                <td><?= escapar($usuario['correo']) ?></td>
                            </tr>
                        <?php endwhile; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </section>

        <hr>

        <section aria-labelledby="equipos-registrados">
            <h2 id="equipos-registrados">Equipos Registrados</h2>
            <table>
                <thead>
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Nombre</th>
                        <th scope="col">Descripción</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (mysqli_num_rows($consultaEquipos) === 0): ?>
                        <tr><td colspan="3">Aún no hay equipos registrados.</td></tr>
                    <?php else: ?>
                        <?php while ($equipo = mysqli_fetch_assoc($consultaEquipos)): ?>
                            <tr>
                                <td><?= escapar($equipo['id']) ?></td>
                                <td><?= escapar($equipo['nombre']) ?></td>
                                <td><?= nl2br(escapar($equipo['descripcion'])) ?></td>
                            </tr>
                        <?php endwhile; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </section>
    </main>
</body>
</html>