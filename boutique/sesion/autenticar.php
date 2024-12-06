<?php 

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

//include_once("mantener_sesion.php");
require_once("../GestorBaseDatos.php");
require_once("guardar_sesion.php");

$destino = "Location:ingreso.php";
$tipo_usuario = "";




//función para revisar si el usuario existe en la base de datos:
function getUsuario($email) {
    $conexion = abrirConexion();
    $usuario_encontrado = "SELECT * FROM usuarios WHERE email = '$email'";
    $resultado = mysqli_query($conexion, $usuario_encontrado);
    $usuario = mysqli_fetch_assoc($resultado); // Devuelve un arreglo asociativo con los datos del usuario
    cerrarConexion($conexion);
    return $usuario;
}




if ((isset($_POST["btn_aceptar"])) && ($_POST["btn_aceptar"] == "Aceptar")) {
    $email = $_POST["email"];
    $password = $_POST["password"];

    // Obtener el usuario por email
    $usuario = getUsuario($email);

    if ($usuario != null) { // Si se encontró el usuario

        $tipo_usuario = $usuario["tipo_usuario"];

        // Verificar la contraseña usando password_verify
        if (password_verify($password, $usuario["contrasena"])) {
        
            if ($tipo_usuario == "Huesped") {
                $destino = "Location:../index.php";
            } elseif ($tipo_usuario == "Administrador") {
                $destino = "Location:../admin/admin.php";
            }

            guardar_variables_sesion($email, $tipo_usuario);

        } else {
            echo "Contraseña incorrecta.";
        }
    } else {
        echo "Usuario no encontrado.";
    }
}

header($destino);
exit();


?>

