<?php
require_once '../GestorBaseDatos.php';
require_once '../config.inc.php';

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    echo "ID de habitación inválido.";
    exit;
}

$roomId = intval($_GET['id']);

try {
    // Abrir conexión a la base de datos
    $conexion = abrirConexion();

    // Preparar consulta
    $query = "SELECT tipo, descripcion, precio FROM habitaciones WHERE id_habitacion = ?";
    $stmt = $conexion->prepare($query);
    $stmt->bind_param("i", $roomId);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Obtener los detalles de la habitación
        $room = $result->fetch_assoc();
        // Crear el contenido para el popup
        $html = "<strong>Tipo:</strong> {$room['tipo']}<br>";
        $html .= "<strong>Descripción:</strong> {$room['descripcion']}<br>";
        $html .= "<strong>Precio:</strong> \${$room['precio']} / noche";
        echo $html;
    } else {
        echo "No se encontró información para esta habitación.";
    }

    // Cerrar conexión
    cerrarConexion($conexion);
} catch (Exception $e) {
    echo "Error al obtener los detalles: " . $e->getMessage();
}
?>
