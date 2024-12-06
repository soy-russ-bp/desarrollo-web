<?php
// buscar.php

require_once __DIR__ . '/GestorBaseDatos.php';

try {
    // Abrir conexión a la base de datos
    $conexion = abrirConexion();

    // Obtener parámetros de búsqueda desde la URL
    $tipo = isset($_GET['tipo']) ? trim($_GET['tipo']) : '';
    $keywords = isset($_GET['keywords']) ? trim($_GET['keywords']) : '';

    // Inicializar variables para mensajes
    $mensaje = '';
    $error = '';

    if (!empty($tipo) || !empty($keywords)) {
        // Realizar búsqueda con los parámetros proporcionados
        $habitaciones = buscarHabitaciones($conexion, $tipo, $keywords);

        if (empty($habitaciones)) {
            $mensaje = "No se encontraron habitaciones que coincidan con tu búsqueda.";
        }
    } else {
        // Si no hay búsqueda, redirigir al index o mostrar todas las habitaciones
        header("Location: index.php");
        exit;
    }

    // Cerrar conexión
    cerrarConexion($conexion);
} catch (Exception $e) {
    // En caso de error, registrar y asignar un array vacío
    error_log($e->getMessage());
    $habitaciones = [];
    $error = "Ocurrió un error al realizar la búsqueda. Por favor, inténtalo nuevamente.";
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style/navigator.css">
    <link rel="stylesheet" href="style/general.css">
    <link rel="stylesheet" href="style/font-section.css">
    <link rel="stylesheet" href="style/content.css">
    <link rel="stylesheet" href="style/content-home.css">
    <link rel="stylesheet" href="style/content-services.css">
    <link rel="stylesheet" href="style/content-amenities.css">
    <link rel="stylesheet" href="style/content-testimonial.css">
    <title>Resultados de Búsqueda - Hotel Boutique</title>
    <style>
        /* Estilos para la sección de búsqueda y resultados */
        .search-container {
            margin: 20px;
            text-align: center;

        }

        .habitacion {}

        .search-container form {

            text-align: left;
        }

        .search-container input[type="text"],
        .search-container select {
            padding: 8px;
            margin-right: 10px;
            width: 200px;
        }

        .search-container button {
            padding: 8px 16px;
            background-color: #4CAF50;
            color: white;
            border: none;
            cursor: pointer;
            border-radius: 4px;
        }

        .search-container button:hover {
            background-color: #45a049;
        }

        /* Estilos para mensajes */
        .mensaje {
            color: green;
            text-align: center;
            font-weight: bold;
            margin: 10px 0;
        }

        .error {
            color: red;
            text-align: center;
            font-weight: bold;
            margin: 10px 0;
        }

        /* Estilos para las habitaciones */
        .habitaciones-navegacion {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            /* Asegura la alineación al centro */
            gap: 20px;
            /* Espaciado entre elementos */
            margin: 20px 0;
        }

        .habitacion {
            position: relative;
            /* Cambiado de absolute */
            width: 300px;
            height: auto;
            /* Ajusta según contenido */
            opacity: 1;
            /* Asegura visibilidad */
            z-index: 1;
            display: flex;
            flex-direction: column;
            align-items: center;
            font-size: 1.2rem;
            color: #333;
            border: 1px solid #ddd;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s, opacity 0.5s ease;
        }

        .habitacion:hover {
            transform: scale(1.05);
        }

        .habitacion img {
            width: 100%;
            height: 200px;
            object-fit: cover;
        }

        .habitacion-info {
            padding: 15px;
            text-align: center;
        }

        .habitacion-info .descripcion {
            font-size: 18px;
            font-weight: 500;
            margin-bottom: 10px;
        }

        .habitacion-info .precio {
            font-size: 16px;
            color: #555;
            margin-bottom: 15px;
        }

        .btn-reservar {
            padding: 8px 16px;
            background-color: #008CBA;
            /* Azul */
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        .btn-reservar:hover {
            background-color: #007B9E;
        }

        .seccion {
            height: auto;
        }

        /* js */
        .room-container {
            position: relative;
            display: inline-block;
            margin: 20px;
        }

        .popup {
            display: none;
            position: absolute;
            bottom: 100%;
            left: 50%;
            transform: translateX(-50%);
            background: rgba(0, 0, 0, 0.8);
            color: white;
            padding: 10px;
            border-radius: 5px;
            text-align: center;
            z-index: 10;
            width: 200px;
        }

        .room-container:hover .popup {
            display: block;
        }
    </style>
</head>

<body>
    <!-- Barra de navegación -->
    <nav class="navbar">
        <a href="index.php#inicio"><img src="img/logo.png" alt="Logo del Hotel" height="50"></a>
        <div class="search-container">
            <form action="buscar.php" method="GET">
                <select id="tipo" name="tipo">
                    <option value="" selected>Categoria</option>
                    <option value="Sencilla">Sencilla</option>
                    <option value="Doble">Doble</option>
                    <option value="Deluxe">Deluxe</option>
                    <option value="Ejecutiva">Ejecutiva</option>
                    <option value="Presidencial">Presidencial</option>
                </select>
                <input type="text" name="keywords" placeholder="Buscar..."
                    value="<?php echo isset($_GET['keywords']) ? htmlspecialchars($_GET['keywords']) : ''; ?>">
                <button type="submit">Buscar</button>
            </form>
        </div>
        <a href="admin/admin.php" class="admin-panel">
            <lord-icon src="https://cdn.lordicon.com/exymduqj.json" trigger="hover"
                style="width: 60%;height:80%;"></lord-icon>
        </a>
        <a href="sesion/ingreso.php">
            <lord-icon src="https://cdn.lordicon.com/kdduutaw.json" trigger="hover" state="hover-looking-around"
                colors="primary:#121331,secondary:#109173" style="width:70%;height:80%"></lord-icon>
        </a>
    </nav>

    <!-- Menú de navegación secundario -->
    <nav id="menu">
        <a href="index.php#habitaciones">Inicio</a>
        <a href="index.php#servicios">Habitaciones</a>
        <a href="index.php#galeria">Amenidades</a>
        <a href="index.php#contacto">Testimonios</a>
        <span class="indicador" id="indicador"></span>
    </nav>

    <!-- Sección de contenido -->
    <div class="secciones">
        <!-- Mensajes de éxito y error -->
        <?php if (!empty($mensaje)): ?>
            <p class="mensaje"><?php echo htmlspecialchars($mensaje); ?></p>
        <?php endif; ?>

        <?php if (!empty($error)): ?>
            <p class="error"><?php echo htmlspecialchars($error); ?></p>
        <?php endif; ?>

        <!-- Resultados de la búsqueda -->
        <div class="seccion" id="servicios">
            <div class="card" class="card-container">
                <h1>Resultados de Búsqueda</h1>
                <div class="habitaciones-navegacion">
                    <?php if (!empty($habitaciones)): ?>
                        <?php foreach ($habitaciones as $habitacion): ?>
                            <div class="room-container"
                                onmouseover="fetchRoomDetails(<?php echo $habitacion['id_habitacion']; ?>)">
                                <div class="habitacion">
                                    <img src="Habitaciones/imagenes/<?php echo htmlspecialchars($habitacion['imagen']); ?>"
                                        alt="Habitación <?php echo htmlspecialchars($habitacion['tipo']); ?>">
                                    <div class="habitacion-info">
                                        <p class="descripcion"><?php echo htmlspecialchars($habitacion['tipo']); ?></p>
                                        <p class="precio">Precio: $<?php echo htmlspecialchars($habitacion['precio']); ?> /
                                            noche</p>
                                        <button class="btn-reservar">Reservar</button>
                                    </div>
                                </div>
                                <div class="popup" id="popup-<?php echo $habitacion['id_habitacion']; ?>"></div>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <p>No hay habitaciones disponibles que coincidan con tu búsqueda.</p>
                    <?php endif; ?>
                </div>

            </div>
        </div>
    </div>


    <!-- Scripts -->
    <script src="js/app.js"></script>
    <script src="https://cdn.lordicon.com/lordicon.js"></script>
    <script src="js/detalles.js"></script>

</body>

</html>