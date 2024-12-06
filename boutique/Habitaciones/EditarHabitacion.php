<?php
// operaciones/editarHabitacion.php

require_once '../GestorBaseDatos.php';


try {
    // Verificar si el formulario fue enviado mediante POST
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        throw new Exception("Método de solicitud no permitido.");
    }

    // Abrir conexión a la base de datos
    $conexion = abrirConexion();

    // Obtener y sanitizar datos del formulario
    $id_habitacion = $_POST['id_habitacion'];
    $tipo = $_POST['tipo'];
    $descripcion = $_POST['descripcion'];
    $capacidad = $_POST['capacidad'];
    $precio = $_POST['precio'];
    $disponibles = $_POST['disponibles'];

    // Obtener la habitación actual para manejar la imagen existente
    $habitacionActual = obtenerHabitacion($conexion, $id_habitacion);
    if (!$habitacionActual) {
        throw new Exception("La habitación especificada no existe.");
    }


    // Manejar la subida de una nueva imagen si se proporcionó
    if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] === UPLOAD_ERR_OK) {
        // Subir la nueva imagen
        $imagen = subirImagen($_FILES['imagen']);
    
        // Eliminar la imagen anterior si existe
        if (!empty($habitacionActual['imagen'])) {
            $rutaImagenAnterior = __DIR__ . '/../Habitaciones/imagenes/' . $habitacionActual['imagen'];
            if (file_exists($rutaImagenAnterior)) {
                unlink($rutaImagenAnterior);
            }
        }
    } else {
        // Mantener la imagen existente si no se sube una nueva
        $imagen = $habitacionActual['imagen'];
    }

    // Preparar los datos para actualizar
    $datos = [
        'tipo' => $tipo,
        'descripcion' => $descripcion,
        'capacidad' => $capacidad,
        'precio' => $precio,
        'disponibles' => $disponibles,
        'imagen' => $imagen // Puede ser null si no se actualiza la imagen
    ];

    // Actualizar la habitación
    if (editarHabitacion($conexion, $id_habitacion, $datos)) {
        // Redirigir al listado con mensaje de éxito
        header("Location: ../admin/admin.php?mensaje=Habitación actualizada exitosamente");
        cerrarConexion($conexion);
        exit;
    } else {
        cerrarConexion($conexion);
        throw new Exception("No se pudo actualizar la habitación o no hubo cambios.");
    }

    // Cerrar conexión

} catch (Exception $e) {
    // Registrar el error y redirigir con mensaje de error
    error_log($e->getMessage());
    header("Location: ../admin/formularioEditarHabitacion.php?id=" . urlencode($id_habitacion) . "&error=Ocurrió un error al editar la habitación");
    exit;
}
?>