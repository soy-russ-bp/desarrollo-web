<?php


require_once 'proyectoWeb\GestorBaseDatos.php';
require_once 'config.inc.php';


try {
  
    // Abrir conexión
    $conexion = abrirConexion();

    // Obtener datos del formulario
    $descripcion = $_POST['descripcion'];
    $capacidad = $_POST['capacidad'];
    $precio = $_POST['precio'];
    $disponibles = $_POST['disponibles'];


    // Manejar la subida de la imagen
    if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] !== UPLOAD_ERR_NO_FILE) {
        $imagen = subirImagen($_FILES['imagen']);
    } else {
        $imagen = null; 
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

    // Insertar la habitación
    if (crearHabitacion($conexion, $datos)) {
        echo "Habitación creada exitosamente.";
    } else {
        echo "No se pudo crear la habitación.";
    }

    // Cerrar conexión
    cerrarConexion($conexion);
} catch (Exception $e) {
    // Registrar el error y mostrar un mensaje genérico
    error_log($e->getMessage());
    echo "Ocurrió un error al crear la habitación. Por favor, intenta nuevamente más tarde.";
}
?>
