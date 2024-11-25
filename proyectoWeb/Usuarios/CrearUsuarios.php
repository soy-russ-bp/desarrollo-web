<?php


require_once 'proyectoWeb\GestorBaseDatos.php';

try {
    // Verificar si el formulario fue enviado
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        throw new Exception("Método de solicitud no permitido.");
    }

    // Abrir conexión
    $conexion = abrirConexion();

    // Obtener datos del formulario
    $nombre_usuario = $_POST['nombre_usuario'];
    $contrasena = $_POST['contrasena'];
    $tipo_usuario = $_POST['tipo_usuario'];
    $nombre_completo = $_POST['nombre_completo'];
    $email = $_POST['email'];

    // Validar datos
    if (empty($nombre_usuario) || empty($contrasena) || empty($tipo_usuario) || empty($nombre_completo) || empty($email)) {
        throw new Exception("Todos los campos son obligatorios.");
    }

    // Validar tipo de usuario
    if (!validarTipoUsuario($tipo_usuario)) {
        throw new Exception("Tipo de usuario inválido.");
    }

    // Validar formato de email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        throw new Exception("Formato de email inválido.");
    }

    // Preparar los datos para insertar
    $datos = [
        'nombre_usuario' => $nombre_usuario,
        'contrasena' => $contrasena,
        'tipo_usuario' => $tipo_usuario,
        'nombre_completo' => $nombre_completo,
        'email' => $email
    ];

    // Insertar el usuario
    if (crearUsuario($conexion, $datos)) {
        // Redirigir al listado con mensaje de éxito
        header("Location: ../Usuarios/ListarUsuarios.php?mensaje=Usuario creado exitosamente");
        // Cerrar conexión
        cerrarConexion($conexion);
        exit;
    } else {
        // Cerrar conexión
        cerrarConexion($conexion);
        throw new Exception("No se pudo crear el usuario.");

    }


} catch (Exception $e) {
    // Registrar el error y redirigir con mensaje de error
    error_log($e->getMessage());
    //Donde se va a crear el usuario
    //header("Location: ../formularioCrearUsuario.php?error=Ocurrió un error al crear el usuario");
    exit;
}
?>