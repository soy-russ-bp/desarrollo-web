<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once("../GestorBaseDatos.php");

// Función para validar si un usuario ya existe (nombre de usuario o correo)
function usuarioExiste($nombre, $email) {
    $conexion = abrirConexion();
    
    // Verificar si ya existe el nombre de usuario
    $consultaNombre = "SELECT * FROM usuarios WHERE nombre_usuario = '$nombre'";
    $resultadoNombre = mysqli_query($conexion, $consultaNombre);
    $nombreExiste = mysqli_num_rows($resultadoNombre) > 0;

    // Verificar si ya existe el correo electrónico
    $consultaEmail = "SELECT * FROM usuarios WHERE email = '$email'";
    $resultadoEmail = mysqli_query($conexion, $consultaEmail);
    $emailExiste = mysqli_num_rows($resultadoEmail) > 0;

    cerrarConexion($conexion);

    if ($nombreExiste && $emailExiste) {
        return "El nombre de usuario y el correo electrónico ya están registrados.";
    } elseif ($nombreExiste) {
        return "El nombre de usuario ya está registrado.";
    } elseif ($emailExiste) {
        return "El correo electrónico ya está registrado.";
    }

    return false; // No hay duplicados
}

// Función para registrar un nuevo usuario
function registrarUsuario($nombre, $email, $password) {
    $conexion = abrirConexion();
    $password_hash = password_hash($password, PASSWORD_BCRYPT);
    $insertar_usuario = "INSERT INTO usuarios (nombre_usuario, contrasena, tipo_usuario, email) 
                         VALUES ('$nombre','$password_hash', 'Huesped', '$email')";
    $resultado = mysqli_query($conexion, $insertar_usuario);
    cerrarConexion($conexion);
    return $resultado;
}

// Procesar el formulario de registro
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = trim($_POST["nombre"]);
    $email = trim($_POST["email"]);
    $password = trim($_POST["password"]);
    $confirm_password = trim($_POST["confirm-password"]);

    // Validar que las contraseñas coincidan
    if ($password !== $confirm_password) {
        header("Location: registro.php?error=" . urlencode("Las contraseñas no coinciden."));
        exit();
    }

    // Validar si el correo o el nombre de usuario ya están registrados
    $error = usuarioExiste($nombre, $email);
    if ($error) {
        header("Location: registro.php?error=" . urlencode($error));
        exit();
    }

    // Registrar el nuevo usuario
    if (registrarUsuario($nombre, $email, $password)) {
        header("Location: registro.php?success=" . urlencode("Registro exitoso."));
        exit();
    } else {
        header("Location: registro.php?error=" . urlencode("Error al registrar el usuario. Inténtalo de nuevo."));
        exit();
    }
}
?>