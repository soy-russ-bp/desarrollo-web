<?php
// operaciones/crearHabitacion.php

require_once __DIR__ . '/../GestorBaseDatos.php';


// Verificar si el usuario está logueado y es administrador


try {

    
    // Verificar si el formulario fue enviado mediante POST
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        throw new Exception("Método de solicitud no permitido.");
    }

    // Abrir conexión a la base de datos
    $conexion = abrirConexion();

    // Obtener datos del formulario
    $tipo = $_POST['tipo'];
    $descripcion = $_POST['descripcion'];
    $capacidad = $_POST['capacidad'];
    $precio = $_POST['precio'];
    $disponibles = $_POST['disponibles'];

    
    // Manejar la subida de la imagen
    if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] === UPLOAD_ERR_OK) {
        $imagen = subirImagen($_FILES['imagen']);
    } else {
        $imagen = null; // O maneja el caso en que no se suba imagen
    }

    // Preparar los datos para insertar
    $datos = [
        'tipo' => $tipo,
        'descripcion' => $descripcion,
        'capacidad' => $capacidad,
        'precio' => $precio,
        'disponibles' => $disponibles,
        'imagen' => $imagen
    ];

    // Insertar la nueva habitación en la base de datos
    if (crearHabitacion($conexion, $datos)) {
        // Redirigir al panel de administración con mensaje de éxito
        cerrarConexion($conexion);

        header("Location: ../admin/formularioCrearHabitacion.php?mensaje=Habitación creada exitosamente");
        exit;
    } else {
        cerrarConexion($conexion);

        throw new Exception("No se pudo crear la habitación. Inténtalo nuevamente.");
    }

} catch (Exception $e) {
    // Registrar el error
    error_log($e->getMessage());

    // Redirigir al formulario con mensaje de error
    header("Location: ../admin/formularioCrearHabitacion.php?error=" . urlencode($e->getMessage()));
    exit;
}
?>