<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Hotel Boutique - Carrito de Reservaciones</title>
    <link rel="stylesheet" href="css/estilos.css">
    <!-- Meta etiquetas para diseño responsivo -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>

    <!-- Encabezado -->
    <header>
        <div class="logo">
            <img src="imagenes/logo_hotel.jpg" alt="Hotel Boutique">
        </div>
        <nav>
            <ul>
                <li><a href="../index.php">Inicio</a></li>
                <li><a href="">Habitaciones</a></li>
                <li><a href="#">Servicios</a></li>
                <li><a href="#">Contacto</a></li>
            </ul>
        </nav>
    </header>

    <!-- Sección de Productos -->
    <main>
        <section id="productos">
            <h1>Nuestras Habitaciones</h1>
            <!-- Los productos se generarán dinámicamente -->
        </section>

        <!-- Sección del Carrito -->
        <aside id="carrito">
            <h2>Carrito de Reservaciones</h2>
            <div id="lista-carrito">
                <!-- Los ítems del carrito se mostrarán aquí -->
            </div>
            <button id="finalizar-compra">Finalizar Compra</button>
        </aside>
    </main>

    <!-- Pie de página -->
    <footer>
        <p>&copy; 2024 Hotel Boutique. Todos los derechos reservados.</p>
    </footer>

    <!-- Incluir los archivos JavaScript -->
    <script src="js/productos.js"></script>
    <script src="js/carrito.js"></script>
    <script src="js/app.js"></script>
</body>
</html>
