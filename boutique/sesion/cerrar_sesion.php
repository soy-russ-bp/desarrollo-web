<?php   
//Es necesario activar o inicializar la sesión antes de destruirla
session_start();
//Elimina todas las variables de la sesión 
session_unset(); 
session_destroy();
 
$cdestino = "Location:../index.php";

//aviso de que la sesión está cerrada

header($cdestino);
exit();
?>