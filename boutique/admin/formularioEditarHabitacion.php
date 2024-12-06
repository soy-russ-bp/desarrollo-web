<?php


require_once '../GestorBaseDatos.php';

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
    <title>Editar Habitación</title>
    <link rel="stylesheet" href="css/estilos.css">
</head>

<body>
    <header>
        <div class="logo">
            <h1>Editar Habitación</h1>
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
        <form action="../Habitaciones/editarHabitacion.php" method="POST" enctype="multipart/form-data">
            <!-- Campo oculto para pasar el ID de la habitación -->
            <input type="hidden" name="id_habitacion"
                value="<?php echo htmlspecialchars($habitacion['id_habitacion']); ?>">

            <label for="tipo">Tipo de Habitación:</label><br>
            <Select id="tipo" name="tipo" required>
                <option value="Sencilla" <?php echo ($habitacion['tipo'] === 'Sencilla') ? 'selected' : ''; ?>>Sencilla
                </option>
                <option value="Doble" <?php echo ($habitacion['tipo'] === 'Doble') ? 'selected' : ''; ?>>Doble</option>
                <option value="Deluxe" <?php echo ($habitacion['tipo'] === 'Deluxe') ? 'selected' : ''; ?>>Deluxe</option>
                <option value="Ejecutiva" <?php echo ($habitacion['tipo'] === 'Ejecutiva') ? 'selected' : ''; ?>>Ejecutiva
                </option>
                <option value="Presidencial" <?php echo ($habitacion['tipo'] === 'Presidencial') ? 'selected' : ''; ?>>
                    Presidencial</option>
            </Select>
            <br><br>

            <label for="descripcion">Descripción:</label><br>
            <textarea id="descripcion" name="descripcion" rows="4" cols="50"
                required><?php echo htmlspecialchars($habitacion['descripcion']); ?></textarea><br><br>

            <label for="capacidad">Capacidad:</label><br>
            <input type="number" id="capacidad" name="capacidad" min="1"
                value="<?php echo htmlspecialchars($habitacion['capacidad']); ?>" required><br><br>

            <label for="precio">Precio por Noche ($):</label><br>
            <input type="number" id="precio" name="precio" step="0.01" min="0.01"
                value="<?php echo htmlspecialchars($habitacion['precio']); ?>" required><br><br>

            <label for="disponibles">Habitaciones Disponibles:</label><br>
            <input type="number" id="disponibles" name="disponibles" min="0"
                value="<?php echo htmlspecialchars($habitacion['disponibles']); ?>" required><br><br>

            <label for="imagen">Imagen de la Habitación (dejar en blanco para no cambiar):</label><br>
            <input type="file" id="imagen" name="imagen" accept="image/*"><br><br>
            <?php
            if ($habitacion['imagen']) {
                echo "<img src='../Habitaciones/imagenes/" . htmlspecialchars($habitacion['imagen']) . "' alt='Imagen Actual' width='150'><br><br>";
            } else {
                echo "No hay imagen actual.<br><br>";
            }
            ?>

            <input type="submit" value="Actualizar Habitación">
        </form>
        <br>
        <a href="admin.php">Volver al Panel de Administración</a>
    </main>

    <script src="js/admin.js"></script>
</body>

</html>