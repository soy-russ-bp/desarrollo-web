<?php
require_once '../GestorBaseDatos.php';
require_once '../config.inc.php';

function listarHab(){
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
                    <td>" . htmlspecialchars($habitacion['id_habitacion']) . "</td>
                    <td>" . htmlspecialchars($habitacion['tipo']) . "</td>
                    <td>" . htmlspecialchars($habitacion['descripcion']) . "</td>
                    <td>" . htmlspecialchars($habitacion['capacidad']) . "</td>
                    <td>\$" . htmlspecialchars($habitacion['precio']) . "</td>
                    <td>" . htmlspecialchars($habitacion['disponibles']) . "</td>
                    <td>";
            if ($habitacion['imagen']) {
                echo "<img src='../Habitaciones/imagenes/" . htmlspecialchars($habitacion['imagen']) . "' alt='Imagen' width='100'>";
            } else {
                echo "No disponible";
            }
            echo "</td>
                    <td>

                        <button type='button' onclick=\"window.location.href='formularioEditarHabitacion.php?id=" . urlencode($habitacion['id_habitacion']) . "'\">Editar</button>
                        

                        <form action='../Habitaciones/BorrarHabitacion.php' method='POST' style='display:inline;' onsubmit=\"return confirm('¿Estás seguro de que deseas eliminar esta habitación?');\">
                            <input type='hidden' name='id_habitacion' value='" . htmlspecialchars($habitacion['id_habitacion']) . "'>
                            <button type='submit'>Eliminar</button>
                        </form>
                    </td>
                  </tr>";
        }
    
        echo "</table>";
    } catch (Exception $e) {
        // Registrar el error y mostrar un mensaje genérico
        error_log($e->getMessage());
        echo "Ocurrió un error al listar las habitaciones. Por favor, intenta nuevamente más tarde.";
    }
}
?>
