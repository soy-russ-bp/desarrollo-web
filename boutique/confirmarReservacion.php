<?php
// confirmarReservacion.php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once 'GestorBaseDatos.php';
session_start();

if (!isset($_SESSION[''])) {
    // Redirigir al usuario a la página de inicio de sesión si no está autenticado
    header("Location: sesion/ingreso.php?error=Debes iniciar sesión para realizar una reservación.");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    // Solo permitir solicitudes POST
    header("Location: index.php");
    exit;
}

// Validar y sanitizar los datos recibidos
$id_habitacion = isset($_POST['id_habitacion']) ? intval($_POST['id_habitacion']) : 0;
$fecha_entrada = isset($_POST['fecha_entrada']) ? $_POST['fecha_entrada'] : '';
$fecha_salida = isset($_POST['fecha_salida']) ? $_POST['fecha_salida'] : '';
$cantidad = isset($_POST['cantidad']) ? intval($_POST['cantidad']) : 1;

// Validaciones básicas
$errores = [];

if ($id_habitacion <= 0) {
    $errores[] = "Habitación inválida.";
}

if (empty($fecha_entrada) || empty($fecha_salida)) {
    $errores[] = "Fechas de entrada y salida son requeridas.";
} else {
    $fecha_entrada_date = DateTime::createFromFormat('Y-m-d', $fecha_entrada);
    $fecha_salida_date = DateTime::createFromFormat('Y-m-d', $fecha_salida);
    if (!$fecha_entrada_date || !$fecha_salida_date) {
        $errores[] = "Formato de fecha inválido. Usa YYYY-MM-DD.";
    } elseif ($fecha_salida_date <= $fecha_entrada_date) {
        $errores[] = "La fecha de salida debe ser posterior a la fecha de entrada.";
    }
}

if ($cantidad <= 0) {
    $errores[] = "Cantidad de habitaciones debe ser al menos 1.";
}

if (!empty($errores)) {
    // Redirigir de vuelta con errores
    $_SESSION['errores_reservacion'] = $errores;
    header("Location: index.php");
    exit;
}

try {
    // Abrir conexión
    $conexion = abrirConexion();
    
    // Iniciar una transacción
    mysqli_begin_transaction($conexion);
    
    // Obtener detalles de la habitación
    $habitacion = obtenerHabitacionDetalle($conexion, $id_habitacion);
    if (!$habitacion) {
        throw new Exception("La habitación seleccionada no existe.");
    }
    
    if ($habitacion['disponibles'] < $cantidad) {
        throw new Exception("No hay suficientes habitaciones disponibles.");
    }
    
    // Calcular el total
    $precio_por_noche = $habitacion['precio'];
    // Calcular el número de noches
    $interval = $fecha_entrada_date->diff($fecha_salida_date);
    $noches = $interval->days;
    if ($noches <= 0) {
        throw new Exception("El número de noches debe ser al menos 1.");
    }
    $total = $precio_por_noche * $noches * $cantidad;
    
    // Crear la reservación
    $datos_reservacion = [
        'id_usuario' => $_SESSION['id_usuario'],
        'fecha_entrada' => $fecha_entrada,
        'fecha_salida' => $fecha_salida,
        'total' => $total
    ];
    $id_reservacion = crearReservacion($conexion, $datos_reservacion);
    
    // Crear el detalle de la reservación
    $datos_detalle = [
        'id_reservacion' => $id_reservacion,
        'id_habitacion' => $id_habitacion,
        'cantidad' => $cantidad,
        'subtotal' => $precio_por_noche * $cantidad * $noches
    ];
    crearDetalleReservacion($conexion, $datos_detalle);
    
    // Actualizar la cantidad de habitaciones disponibles
    actualizarDisponiblesHabitacion($conexion, $id_habitacion, $cantidad);
    
    // Confirmar la transacción
    mysqli_commit($conexion);
    
    // Cerrar la conexión
    cerrarConexion($conexion);
    
    // Redirigir con éxito
    header("Location: reservas.php?mensaje=Reservación confirmada exitosamente.");
    exit;
    
} catch (Exception $e) {
    // Deshacer la transacción en caso de error
    mysqli_rollback($conexion);
    cerrarConexion($conexion);
    
    // Registrar el error y redirigir con mensaje de error
    error_log($e->getMessage());
    $_SESSION['errores_reservacion'][] = "Ocurrió un error al procesar tu reservación: " . $e->getMessage();
    header("Location: index.php");
    exit;
}

?>
