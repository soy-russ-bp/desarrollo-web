<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Panel de Administración</title>
    <link rel="stylesheet" href="css/estilos.css">
</head>
<body>
    <header>
        <div class="logo">
            <h1>Admin Panel</h1>
        </div>
        <nav>
            <ul>
                <li><a href="../index.php">Inicio</a></li>
                <li><a href="admin.php">Administración</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <section id="admin-catalogo">
            <h2>Catálogo de Habitaciones</h2>
            <button id="agregar-habitacion">Agregar Nueva Habitación</button>
            <table id="tabla-habitaciones">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Precio</th>
                        <th>Disponibles</th>
                        <th>Categoría</th>
                        <th>Imagen</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Las habitaciones se cargarán aquí dinámicamente -->
                </tbody>
            </table>
        </section>
    </main>

    <!-- Ventana Modal para Agregar/Editar Habitación -->
    <div id="modal-habitacion" class="modal">
        <div class="modal-contenido">
            <span class="cerrar-modal">&times;</span>
            <h2 id="modal-titulo">Agregar Habitación</h2>
            <form id="form-habitacion">
                <input type="hidden" id="habitacion-id">
                <label for="nombre">Nombre:</label>
                <input type="text" id="nombre" required>
                <label for="precio">Precio:</label>
                <input type="number" id="precio" required>
                <label for="disponibles">Disponibles:</label>
                <input type="number" id="disponibles" required>
                <label for="categoria">Categoría:</label>
                <input type="text" id="categoria" required>
                <label for="descripcion">Descripción:</label>
                <textarea id="descripcion" required></textarea>
                <label for="imagen">Imagen:</label>
                <input type="file" id="imagen">
                <button type="submit">Guardar</button>
            </form>
        </div>
    </div>

    <script src="js/admin.js"></script>
</body>
</html>
