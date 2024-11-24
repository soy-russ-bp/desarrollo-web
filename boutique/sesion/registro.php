<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chilangolandia</title>
    <link rel="stylesheet" href="CSS/styles.css">
</head>
<body>
    <section class="background" style="background-image: url('imagenes/imagen-registro.jpg');">
        <div class="form-container">
            <h2>Registrarse</h2>
            <form action="#" method="POST">
                <label for="nombre">Nombre:</label>
                <input type="text" id="nombre" name="nombre" required>

                <label for="email">Correo electrónico:</label>
                <input type="email" id="email" name="email" required>

                <label for="password">Contraseña:</label>
                <input type="password" id="password" name="password" required>

                <label for="confirm-password">Confirmar contraseña:</label>
                <input type="password" id="confirm-password" name="confirm-password" required>

                <button type="submit">Registrarse</button>
                <a href="ingreso.php" class="link">Ya tengo una cuenta</a>
            </form>
        </div>

        <script src="js/registro.js"></script>
    </section>
</body>
</html>