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
       
        <nav>
            <ul>
                <li><a href="../index.php">Inicio</a></li>
                
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

        <!-- Sección del Pago -->
        <section id="pago" style="display: none;">
            <h1>Pago con tarjeta</h1>
            <p>Introduzca los datos de su tarjeta de crédito o débito.</p><br>
            <form id="paymentForm">
                <label for="cardNumber">Número de tarjeta:</label>
                <div class="card-number-container">
                    <input type="text" id="card1" maxlength="4" class="card-input" required>
                    <input type="text" id="card2" maxlength="4" class="card-input" required>
                    <input type="text" id="card3" maxlength="4" class="card-input" required>
                    <input type="text" id="card4" maxlength="4" class="card-input" required>
                </div>
                <label for="expiraDate">Fecha de vencimiento (MMYY):</label><br>
                <input type="text" id="expiraDate" maxlength="4" placeholder="MMYY" required>
                <br><br>
                <label for="cvv">CVV:</label><br>
                <input type="text" id="cvv" maxlength="3" placeholder="" required>
                <br><br>
                <button type="submit">Enviar</button>
                <p class="message" id="message"></p>
            </form>
        </section>
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