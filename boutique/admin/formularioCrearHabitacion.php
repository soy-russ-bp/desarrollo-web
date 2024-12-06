<?php


require_once '../GestorBaseDatos.php';



// Verificar si el usuario está logueado y es administrador


?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Crear Nueva Habitación</title>
    <link rel="stylesheet" href="css/estilos.css">
</head>

<body>
    <header>
        <div class="logo">
            <h1>Aqui va el logo</h1>
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

        // Mostrar mensajes de éxito si existen
        if (isset($_GET['mensaje'])) {
            echo "<p style='color: green;'>" . htmlspecialchars($_GET['mensaje']) . "</p>";
        }
        ?>
        <form action="../Habitaciones/CrearHabitacion.php" method="POST" enctype="multipart/form-data">
            <label for="tipo">Tipo de Habitación:</label><br>
            <Select id="tipo" name="tipo">
                <option value="Sencilla">Sencilla</option>
                <option value="Doble">Doble</option>
                <option value="Deluxe">Deluxe</option>
                <option value="Ejecutiva">Ejecutiva</option>
                <option value="Presidencial">Presidencial</option>
            </Select><br><br>

            <label for="descripcion">Descripción:</label><br>
            <textarea id="descripcion" name="descripcion" rows="4" cols="50"></textarea><br><br>

            <label for="capacidad">Capacidad:</label><br>
            <input type="number" id="capacidad" name="capacidad" min="1" required><br><br>

            <label for="precio">Precio por Noche ($):</label><br>
            <input type="number" id="precio" name="precio" step="0.01" min="0.01" required><br><br>

            <label for="disponibles">Habitaciones Disponibles:</label><br>
            <input type="number" id="disponibles" name="disponibles" min="0" required><br><br>

            <label for="imagen">Imagen de la Habitación:</label><br>
            <input type="file" id="imagen" name="imagen" accept="image/*" ><br><br>

            <input type="submit" value="Crear Habitación">
        </form>
        <br>
        <a href="admin.php">Volver al Panel de Administración</a>
    </main>
</body>

</html>