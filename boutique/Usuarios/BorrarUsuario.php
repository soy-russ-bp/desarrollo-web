<?php
// operaciones/borrarUsuario.php

require_once 'proyectoWeb\GestorBaseDatos.php';

try {
    // Verificar si el formulario fue enviado mediante POST
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        throw new Exception("Método de solicitud no permitido.");
    }

    // Abrir conexión a la base de datos
    $conexion = abrirConexion();

    // Obtener el ID del usuario a borrar
    $id_usuario = isset($_POST['id_usuario']) ? intval($_POST['id_usuario']) : 0;

    if ($id_usuario <= 0) {
        throw new Exception("ID de usuario inválido.");
    }

    // Eliminar el usuario de la base de datos
    if (eliminarUsuario($conexion, $id_usuario)) {
        // Redirigir al listado con mensaje de éxito
        header("Location: ../Usuarios/ListarUsuarios.php?mensaje=Usuario creado exitosamente");

        // Cerrar conexión
    cerrarConexion($conexion);
        exit;
    } else {
        // Cerrar conexión
    cerrarConexion($conexion);
        throw new Exception("No se pudo eliminar el usuario o no existe.");
    }

    
} catch (Exception $e) {
    // Registrar el error y redirigir con mensaje de error
    error_log($e->getMessage());
    header("Location: ../formularios/formularioBorrarUsuario.php?id=" . urlencode($id_usuario) . "&error=Ocurrió un error al eliminar el usuario");
    exit;
}
?>
