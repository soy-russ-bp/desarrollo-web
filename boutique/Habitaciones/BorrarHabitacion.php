<?php
// operaciones/borrarHabitacion.php

require_once '../GestorBaseDatos.php';

try {
    // Verificar si el formulario fue enviado mediante POST
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        throw new Exception("Método de solicitud no permitido.");
    }

    // Abrir conexión a la base de datos
    $conexion = abrirConexion();

    // Obtener el ID de la habitación a eliminar
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
        $rutaImagen = __DIR__ . '/../Habitaciones/imagenes/' . $habitacionActual['imagen'];
        if (file_exists($rutaImagen)) {
            unlink($rutaImagen);
        }
    }

    // Eliminar la habitación de la base de datos
    if (eliminarHabitacion($conexion, $id_habitacion)) {
        // Redirigir al panel de administración con mensaje de éxito
        header("Location: ../admin/admin.php?mensaje=Habitación eliminada exitosamente");
        cerrarConexion($conexion);

        exit;
    } else {
        cerrarConexion($conexion);
        throw new Exception("No se pudo eliminar la habitación o no existe.");
    }

} catch (Exception $e) {
    // Registrar el error y redirigir con mensaje de error
    error_log($e->getMessage());
    header("Location: ../formularios/formularioBorrarHabitacion.php?id=" . urlencode($id_habitacion) . "&error=Ocurrió un error al eliminar la habitación");
    exit;
}
?>