<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chilangolandia</title>
    <link rel="stylesheet" href="CSS/styles.css">
</head>
<body>
    <section class="background" style="background-image: url('imagenes/imagen-ingreso.jpg');">
        <div class="form-container">
            <h2>Ingresar</h2>
            <form method="POST" action="autenticar.php">
                <label for="login-email">Correo electrónico:</label>
                <input type="email" id="login-email" name="email" required>

                <label for="login-password">Contraseña:</label>
                <input type="password" id="login-password" name="password" required>

                <button name="btn_aceptar" type="submit" value="Aceptar">Ingresar</button>
                <a href="registro.php" class="link">Aún no tengo una cuenta</a>
            </form>
        </div>
    </section>
</body>
</html>