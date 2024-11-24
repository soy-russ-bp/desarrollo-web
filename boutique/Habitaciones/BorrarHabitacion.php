<?php


require_once 'proyectoWeb\GestorBaseDatos.php';
require_once 'proyectoWeb\config.inc.php';

try {
    

    // Abrir conexión
    $conexion = abrirConexion();

    // Obtener el ID de la habitación a borrar
    $id_habitacion = isset($_POST['id_habitacion']) ? intval($_POST['id_habitacion']) : 0;

    if ($id_habitacion <= 0) {
        throw new Exception("ID de habitación inválido.");
    }

    // Obtener la habitación actual para eliminar la imagen si existe
    $habitacionActual = obtenerHabitacion($conexion, $id_habitacion);
    if (!$habitacionActual) {
        throw new Exception("La habitación especificada no existe.");
    }

    // Eliminar la imagen asociada si existe
    if ($habitacionActual['imagen']) {
        $rutaImagen = __DIR__ . '/../recursos/habitaciones/' . $habitacionActual['imagen'];
        if (file_exists($rutaImagen)) {
            unlink($rutaImagen);
        }
    }

    // Eliminar la habitación de la base de datos
    if (eliminarHabitacion($conexion, $id_habitacion)) {
        echo "Habitación eliminada exitosamente.";
    } else {
        echo "No se pudo eliminar la habitación o no existe.";
    }

    // Cerrar conexión
    cerrarConexion($conexion);
} catch (Exception $e) {
    // Registrar el error y mostrar un mensaje genérico
    error_log($e->getMessage());
    echo "Ocurrió un error al eliminar la habitación. Por favor, intenta nuevamente más tarde.";
}
?>
