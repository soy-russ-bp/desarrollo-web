<?php 

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

//include_once("mantener_sesion.php");
require_once("../GestorBaseDatos.php");

$destino = "Location:ingreso.php";
$tipo_usuario = "";




//función para revisar si el usuario existe en la base de datos:
function iniciarSesion($email, $password){
    $conexion = abrirConexion();
    $usuario_encontrado = "SELECT * FROM usuarios WHERE email = '$email' AND contrasena = '$password'";
    $resultado = mysqli_query($conexion,$usuario_encontrado);
    $usuario = mysqli_fetch_assoc($resultado); //regresa un arreglo asociativo con los datos del usuario
    cerrarConexion($conexion);
    return $usuario;
}



if ( (isset($_POST["btn_aceptar"])) && ($_POST["btn_aceptar"]=="Aceptar") ){

    $usuario = iniciarSesion($_POST["email"], $_POST["password"]);
    $tipo_usuario = $usuario["tipo_usuario"];
   
    if ( $usuario != null ){ //si el usuario existe en la base de datos
        
        if($tipo_usuario == "Huesped"){
            //session_start();
            //iniciarSesion($_POST["email"]);
            $destino = "Location:../index.php";
            echo "Ingresando...";

        }elseif($tipo_usuario == "Administrador"){
            $destino = "Location:../admin/admin.php";
            
        }
    }else{
        echo "Usuario o contraseña incorrectos";
    }
   
}
header($destino);
exit();

?>

