<?php


require_once 'proyectoWeb\GestorBaseDatos.php';
require_once 'proyectoWeb\config.inc.php';

try {

    // Abrir conexión a la base de datos
    $conexion = abrirConexion();

    $id_habitacion = $_POST['id_habitacion'];
    $tipo = $_POST['tipo'];
    $descripcion = $_POST['descripcion'];
    $capacidad = $_POST['capacidad'];
    $precio = $_POST['precio'];
    $disponibles = $_POST['disponibles'];

    // Validar datos
    if ($id_habitacion <= 0 || empty($tipo) || empty($descripcion) || $capacidad <= 0 || $precio <= 0 || $disponibles < 0) {
        throw new Exception("Todos los campos son obligatorios y deben contener valores válidos.");
    }

    // Obtener la habitación actual para manejar la imagen existente
    $habitacionActual = obtenerHabitacion($conexion, $id_habitacion);
    if (!$habitacionActual) {
        throw new Exception("La habitación especificada no existe.");
    }

    // Manejar la subida de una nueva imagen si se proporcionó
    if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] !== UPLOAD_ERR_NO_FILE) {
        // Subir la nueva imagen
        $imagen = subirImagen($_FILES['imagen']);

        // Eliminar la imagen anterior si existe
        if ($habitacionActual['imagen']) {
            $rutaImagenAnterior = __DIR__ . '/../uploads/habitaciones/' . $habitacionActual['imagen'];
            if (file_exists($rutaImagenAnterior)) {
                unlink($rutaImagenAnterior);
            }
        }
    } else {
        // No se actualiza la imagen, mantener la existente
        $imagen = null;
    }

    // Preparar los datos para actualizar
    $datos = [
        'tipo' => $tipo,
        'descripcion' => $descripcion,
        'capacidad' => $capacidad,
        'precio' => $precio,
        'disponibles' => $disponibles,
        'imagen' => $imagen 
    ];

    // Actualizar la habitación
    if (editarHabitacion($conexion, $id_habitacion, $datos)) {
        echo "Habitación actualizada exitosamente.";
    } else {
        echo "No se pudo actualizar la habitación o no hubo cambios.";
    }

    // Cerrar conexión
    cerrarConexion($conexion);
} catch (Exception $e) {
    // Registrar el error y mostrar un mensaje genérico
    error_log($e->getMessage());
    echo "Ocurrió un error al editar la habitación. Por favor, intenta nuevamente más tarde.";
}
?>
