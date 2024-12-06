<?php
session_start();

if (isset($_SESSION['email'])) {
    // Si la sesión está activa, muestra la opción para cerrar sesión
    echo "
    <!DOCTYPE html>
    <html lang='en'>
    <head>
        <meta charset='UTF-8'>
        <meta name='viewport' content='width=device-width, initial-scale=1.0'>
        <title>Chilangolandia</title>
        <link rel='stylesheet' href='CSS/styles.css'>
    </head>
    <body>
        <section class='background' style='background-image: url(\"imagenes/imagen-ingreso.jpg\");'>
            <div class='form-container'>
                <h2>Bienvenido, " . htmlspecialchars($_SESSION['email']) . "</h2>
                <form method='POST' action='cerrar_sesion.php'>
                    <button type='submit'>Cerrar Sesión</button>
                </form>
                <a href='../index.php' class='link'>Volver al inicio</a>
            </div>
        </section>
    </body>
    </html>";
    exit();
}


?>
<!-- Si no hay sesión activa, muestra el formulario de ingreso-->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>La Sierra</title>
    <link rel="stylesheet" href="CSS/styles.css">
</head>
<body>
    <section class="background" style="background-image: url('imagenes/imagen-ingreso.jpg');">
        <div class="form-container">
            <h2>Ingresar</h2>
            <!-- Área para mostrar mensajes de error -->
            <div id="error-message" style="color: red;"></div>

            <form method="POST" action="autenticar.php">
            <label for="login-email">Correo electrónico:</label>
            <input type="email" id="login-email" name="email" required autocomplete="username">

                <label for="login-password">Contraseña:</label>
                <input type="password" id="login-password" name="password" required autocomplete="current-password">

                <button name="btn_aceptar" type="submit" value="Aceptar">Ingresar</button>
                <a href="registro.php" class="link">Aún no tengo una cuenta</a>
            </form>
            <a href="../index.php" class="link">Volver al inicio</a>
        </div>
    </section>
    <script src="js/ingreso.js" defer></script>
</body>
</html>