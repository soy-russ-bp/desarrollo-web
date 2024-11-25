<?php


require_once 'proyectoWeb\GestorBaseDatos.php';

try {
    // Abrir conexión
    $conexion = abrirConexion();

    // Obtener todos los usuarios
    $usuarios = listarUsuarios($conexion);

    // Cerrar conexión
    cerrarConexion($conexion);

    // Mostrar mensajes si existen
    if (isset($_GET['mensaje'])) {
        echo "<p style='color: green;'>" . htmlspecialchars($_GET['mensaje']) . "</p>";
    }

    if (isset($_GET['error'])) {
        echo "<p style='color: red;'>" . htmlspecialchars($_GET['error']) . "</p>";
    }

    // Mostrar los usuarios en una tabla HTML
    echo "<h2>Listado de Usuarios</h2>";
    echo "<a href='../formularios/formularioCrearUsuario.php'>Crear Nuevo Usuario</a><br><br>";
    echo "<table border='1' cellpadding='10'>";
    echo "<tr>
            <th>ID</th>
            <th>Nombre de Usuario</th>
            <th>Tipo de Usuario</th>
            <th>Nombre Completo</th>
            <th>Email</th>
            <th>Fecha de Registro</th>
            <th>Acciones</th>
          </tr>";

    foreach ($usuarios as $usuario) {
        echo "<tr>
                <td>" . htmlspecialchars($usuario['id_usuario']) . "</td>
                <td>" . htmlspecialchars($usuario['nombre_usuario']) . "</td>
                <td>" . htmlspecialchars($usuario['tipo_usuario']) . "</td>
                <td>" . htmlspecialchars($usuario['nombre_completo']) . "</td>
                <td>" . htmlspecialchars($usuario['email']) . "</td>
                <td>" . htmlspecialchars($usuario['fecha_registro']) . "</td>
                <td>
                    ".
                    //Donde se va a editar el usuario o borra, ejemplos...
                    //<a href='../formularios/formularioEditarUsuario.php?id=" . urlencode($usuario['id_usuario']) . "'>Editar</a> | 
                    //<a href='../formularios/formularioBorrarUsuario.php?id=" . urlencode($usuario['id_usuario']) . "'>Borrar</a>
                "</td>
              </tr>";
    }

    echo "</table>";
} catch (Exception $e) {
    // Registrar el error y mostrar un mensaje genérico
    error_log($e->getMessage());
    echo "Ocurrió un error al listar los usuarios. Por favor, intenta nuevamente más tarde.";
}
?>
