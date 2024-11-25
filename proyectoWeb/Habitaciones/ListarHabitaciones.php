<?php


require_once 'proyectoWeb\GestorBaseDatos.php';
require_once 'config.inc.php';

try {
    // Abrir conexión
    $conexion = abrirConexion();

    // Obtener todas las habitaciones
    $habitaciones = listarHabitaciones($conexion);

    // Cerrar conexión
    cerrarConexion($conexion);

    // Mostrar las habitaciones en una tabla HTML
    echo "<h2>Listado de Habitaciones</h2>";
    echo "<table border='1' cellpadding='10'>";
    echo "<tr>
            <th>ID</th>
            <th>Tipo</th>
            <th>Descripción</th>
            <th>Capacidad</th>
            <th>Precio</th>
            <th>Disponibles</th>
            <th>Imagen</th>
            <th>Acciones</th>
          </tr>";

    foreach ($habitaciones as $habitacion) {
        echo "<tr>
                <td>{$habitacion['id_habitacion']}</td>
                <td>{$habitacion['tipo']}</td>
                <td>{$habitacion['descripcion']}</td>
                <td>{$habitacion['capacidad']}</td>
                <td>\${$habitacion['precio']}</td>
                <td>{$habitacion['disponibles']}</td>
                <td>";
        if ($habitacion['imagen']) {
            echo "<img src='../recursos/habitaciones/{$habitacion['imagen']}' alt='Imagen' width='100'>";
        } else {
            echo "No disponible";
        }
        echo "</td>
                <td>
                    ingresar funciones de borrado y editado
                </td>
              </tr>";
    }

    echo "</table>";
} catch (Exception $e) {
    // Registrar el error y mostrar un mensaje genérico
    error_log($e->getMessage());
    echo "Ocurrió un error al listar las habitaciones. Por favor, intenta nuevamente más tarde.";
}
?>
