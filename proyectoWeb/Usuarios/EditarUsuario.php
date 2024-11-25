<?php


require_once 'proyectoWeb\GestorBaseDatos.php';


try {
    // Verificar si el formulario fue enviado mediante POST
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        throw new Exception("Método de solicitud no permitido.");
    }

    // Abrir conexión a la base de datos
    $conexion = abrirConexion();

    // Obtener datos del formulario
    $id_usuario = $_POST['id_usuario'];
    $nombre_usuario = $_POST['nombre_usuario'];
    $contrasena = $_POST['contrasena'];
    $tipo_usuario = $_POST['tipo_usuario'];
    $nombre_completo = $_POST['nombre_completo'];
    $email = $_POST['email'];

    // Validar datos
    if ($id_usuario <= 0 || empty($nombre_usuario) || empty($tipo_usuario) || empty($nombre_completo) || empty($email)) {
        throw new Exception("Todos los campos excepto la contraseña son obligatorios.");
    }

    // Validar tipo de usuario
    if (!validarTipoUsuario($tipo_usuario)) {
        throw new Exception("Tipo de usuario inválido.");
    }

    // Validar formato de email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        throw new Exception("Formato de email inválido.");
    }

    // Preparar los datos para actualizar
    $datos = [
        'nombre_usuario' => $nombre_usuario,
        'contrasena' => $contrasena, // Puede estar vacío si no se actualiza
        'tipo_usuario' => $tipo_usuario,
        'nombre_completo' => $nombre_completo,
        'email' => $email
    ];

    // Actualizar el usuario
    if (editarUsuario($conexion, $id_usuario, $datos)) {
        // Redirigir al listado con mensaje de éxito
        header("Location: ../Usuarios/ListarUsuarios.php?mensaje=Usuario creado exitosamente");

        // Cerrar conexión
        cerrarConexion($conexion);
        exit;
    } else {
        // Cerrar conexión
        cerrarConexion($conexion);
        throw new Exception("No se pudo actualizar el usuario o no hubo cambios.");
    }


} catch (Exception $e) {
    // Registrar el error y redirigir con mensaje de error
    error_log($e->getMessage());
    //Donde se va a editar el usuario.
    //header("Location: ../formularios/formularioEditarUsuario.php?id=" . urlencode($id_usuario) . "&error=Ocurrió un error al actualizar el usuario");
    exit;
}
?>