<?php 
function validarSesion(){

   //La función session_start() carga las variables registradas en el arreglo $_SESSION
   session_start();
  
   if ( !isset($_SESSION["id_usuario"]) ){
      $cdestino = "Location:index.php";
      header($cdestino);
      exit();
   } 
 
}

function iniciarSesion($cidlogin){

   session_start(); 
   $_SESSION["id_usuario"] = $cidlogin;
 
}

?>