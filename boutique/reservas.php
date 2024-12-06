<?php
// reservas.php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once 'GestorBaseDatos.php';
session_start();

if (!isset($_SESSION['id_usuario'])) {
    header("Location: sesion/ingreso.php?error=Debes iniciar sesión para ver tus reservaciones.");
    exit;
}

try {
    $conexion = abrirConexion();
    
    // Obtener todas las reservaciones del usuario
    $stmt = mysqli_prepare($conexion, "SELECT r.id_reservacion, r.fecha_reservacion, r.fecha_entrada, r.fecha_salida, r.estado, r.total, d.cantidad, h.tipo 
                                      FROM reservaciones r 
                                      JOIN detalle_reservacion d ON r.id_reservacion = d.id_reservacion 
                                      JOIN habitaciones h ON d.id_habitacion = h.id_habitacion 
                                      WHERE r.id_usuario = ? 
                                      ORDER BY r.fecha_reservacion DESC");
    if (!$stmt) {
        throw new Exception("Error en la preparación de la sentencia: " . mysqli_error($conexion));
    }
    
    mysqli_stmt_bind_param($stmt, "i", $_SESSION['id_usuario']);
    
    if (!mysqli_stmt_execute($stmt)) {
        throw new Exception("Error en la ejecución de la sentencia: " . mysqli_stmt_error($stmt));
    }
    
    $resultado = mysqli_stmt_get_result($stmt);
    $reservaciones = [];
    while ($fila = mysqli_fetch_assoc($resultado)) {
        $reservaciones[] = $fila;
    }
    
    mysqli_stmt_close($stmt);
    cerrarConexion($conexion);
    
} catch (Exception $e) {
    error_log($e->getMessage());
    $reservaciones = [];
    $error = "Ocurrió un error al obtener tus reservaciones. Por favor, intenta nuevamente más tarde.";
}

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Mis Reservaciones</title>
    <link rel="stylesheet" href="style/general.css">
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        
        table, th, td {
            border: 1px solid #ddd;
        }
        
        th, td {
            padding: 12px;
            text-align: left;
        }
        
        th {
            background-color: #109173;
            color: white;
        }
        
        tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        
        .mensaje {
            color: green;
            margin-top: 20px;
        }
        
        .error {
            color: red;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <!-- Barra de navegación (puedes reutilizar la existente) -->
    <nav class="navbar">
        <a href="index.php"><img src="img/logo.png" alt="Logo"></a>
        <!-- ... otros enlaces de navegación ... -->
        <a href="sesion/cerrar.php">
            <lord-icon src="https://cdn.lordicon.com/kdduutaw.json" trigger="hover" 
                       state="hover-looking-around" colors="primary:#121331,secondary:#109173" 
                       style="width:70%;height:80%"></lord-icon>
        </a>
    </nav>

    <h1>Mis Reservaciones</h1>

    <?php
    if (isset($_GET['mensaje'])) {
        echo "<p class='mensaje'>" . htmlspecialchars($_GET['mensaje']) . "</p>";
    }

    if (isset($_SESSION['errores_reservacion'])) {
        foreach ($_SESSION['errores_reservacion'] as $error_msg) {
            echo "<p class='error'>" . htmlspecialchars($error_msg) . "</p>";
        }
        unset($_SESSION['errores_reservacion']);
    }

    if (isset($error)) {
        echo "<p class='error'>" . htmlspecialchars($error) . "</p>";
    }
    ?>

    <?php if (!empty($reservaciones)): ?>
        <table>
            <tr>
                <th>ID Reservación</th>
                <th>Fecha de Reservación</th>
                <th>Tipo de Habitación</th>
                <th>Cantidad</th>
                <th>Fecha de Entrada</th>
                <th>Fecha de Salida</th>
                <th>Total</th>
                <th>Estado</th>
            </tr>
            <?php foreach ($reservaciones as $res): ?>
                <tr>
                    <td><?php echo htmlspecialchars($res['id_reservacion']); ?></td>
                    <td><?php echo htmlspecialchars($res['fecha_reservacion']); ?></td>
                    <td><?php echo htmlspecialchars($res['tipo']); ?></td>
                    <td><?php echo htmlspecialchars($res['cantidad']); ?></td>
                    <td><?php echo htmlspecialchars($res['fecha_entrada']); ?></td>
                    <td><?php echo htmlspecialchars($res['fecha_salida']); ?></td>
                    <td>$<?php echo htmlspecialchars($res['total']); ?></td>
                    <td><?php echo htmlspecialchars($res['estado']); ?></td>
                </tr>
            <?php endforeach; ?>
        </table>
    <?php else: ?>
        <p>No tienes reservaciones realizadas.</p>
    <?php endif; ?>

    <script src="https://cdn.lordicon.com/lordicon.js"></script>
</body>
</html>
