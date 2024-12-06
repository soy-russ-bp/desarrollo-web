<?php
// formularios/formularioBorrarHabitacion.php

require_once  '../GestorBaseDatos.php';

try {
    // Verificar si se proporcionó el ID de la habitación
    if (!isset($_GET['id'])) {
        throw new Exception("ID de habitación no proporcionado.");
    }

    $id_habitacion = intval($_GET['id']);
    if ($id_habitacion <= 0) {
        throw new Exception("ID de habitación inválido.");
    }

    // Abrir conexión
    $conexion = abrirConexion();

    // Obtener los datos actuales de la habitación
    $habitacion = obtenerHabitacion($conexion, $id_habitacion);
    if (!$habitacion) {
        throw new Exception("La habitación especificada no existe.");
    }

    // Cerrar conexión
    cerrarConexion($conexion);

    
} catch (Exception $e) {
    // Registrar el error y mostrar mensaje
    error_log($e->getMessage());
    echo "Error: " . htmlspecialchars($e->getMessage());
    exit;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Borrar Habitación</title>
    <link rel="stylesheet" href="css/estilos.css">
</head>
<body>
    <header>
        <div class="logo">
            <h1>Borrar Habitación</h1>
        </div>
        <nav>
            <ul>
                <li><a href="../index.php">Inicio</a></li>
                <li><a href="admin.php">Administración</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <?php
        // Mostrar mensajes de error si existen
        if (isset($_GET['error'])) {
            echo "<p style='color: red;'>" . htmlspecialchars($_GET['error']) . "</p>";
        }
        ?>
        <p>¿Estás seguro de que deseas eliminar la siguiente habitación?</p>
        <ul>
            <li><strong>ID:</strong> <?php echo htmlspecialchars($habitacion['id_habitacion']); ?></li>
            <li><strong>Tipo:</strong> <?php echo htmlspecialchars($habitacion['tipo']); ?></li>
            <li><strong>Descripción:</strong> <?php echo htmlspecialchars($habitacion['descripcion']); ?></li>
            <li><strong>Capacidad:</strong> <?php echo htmlspecialchars($habitacion['capacidad']); ?></li>
            <li><strong>Precio:</strong> \$<?php echo htmlspecialchars($habitacion['precio']); ?></li>
            <li><strong>Disponibles:</strong> <?php echo htmlspecialchars($habitacion['disponibles']); ?></li>
            <li>
                <strong>Imagen:</strong><br>
                <?php
                if ($habitacion['imagen']) {
                    echo "<img src='../Habitaciones/imagenes/" . htmlspecialchars($habitacion['imagen']) . "' alt='Imagen' width='150'>";
                } else {
                    echo "No disponible";
                }
                ?>
            </li>
        </ul>
        <form action="../operaciones/borrarHabitacion.php" method="POST">
            <input type="hidden" name="id_habitacion" value="<?php echo htmlspecialchars($habitacion['id_habitacion']); ?>">
            <input type="submit" value="Confirmar Eliminación">
            <a href="admin.php">Cancelar</a>
        </form>
    </main>

    <script src="js/admin.js"></script>
</body>
</html>
