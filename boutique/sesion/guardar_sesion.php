<?php 

function guardar_variables_sesion($email, $tipo_usuario) {
    if (session_status() == PHP_SESSION_NONE) {
        session_start(); // Inicia la sesión si no está ya iniciada
    }

    $_SESSION['email'] = $email;
    $_SESSION['tipo_usuario'] = $tipo_usuario;
}

?>
