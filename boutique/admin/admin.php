<?php
require_once("../config.inc.php");
require_once("../Habitaciones/ListarHabitaciones.php");

//manejo de sesiones
session_start();
if (!isset($_SESSION['tipo_usuario']) || $_SESSION['tipo_usuario'] !== 'Administrador') {
    // Si el usuario no es un administrador, redirigir al inicio
    header("Location: ../index.php");
    exit;
}


// Manejar acciones de agregar habitación
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['agregarHabitacion'])) {
    // Redirigir al formulario de creación de habitación
    header("Location:formularioCrearHabitacion.php");
    exit;
}



?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Panel de Administración</title>
    <link rel="stylesheet" href="css/estilos.css">
</head>
<body>
    <header>
        <div class="logo">
            <h1>Panel de administración</h1>
        </div>
        <nav>
            <ul>
                <li><a href="../index.php">Inicio</a></li>
            </ul>
        </nav>
    </header>
    <?php
        // Mostrar mensajes de error si existen
        if (isset($_GET['error'])) {
            echo "<p class='error'>" . htmlspecialchars($_GET['error']) . "</p>";
        }

        // Mostrar mensajes de éxito si existen
        if (isset($_GET['mensaje'])) {
            echo "<p class='mensaje'>" . htmlspecialchars($_GET['mensaje']) . "</p>";
        }

        //echo $_REQUEST['mensaje'];
        ?>
    <main>
        <form method="POST">
        <section id="admin-catalogo">
 
            <h2>Catálogo de Habitaciones</h2>
            <button type="submit" name="agregarHabitacion">Agregar Nueva Habitación</button>
            <?php echo listarHab()?>
        </section>
        </form>
    </main>

    
</body>
</html>
