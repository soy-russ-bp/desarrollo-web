<?php

require_once 'db_config.php';

// Configuración de la base de datos
define('DB_SERVER', $GLOBALS["servidor"]);       
define('DB_USER', $GLOBALS["usuario"]);          
define('DB_PASSWORD', $GLOBALS["contrasena"]);   
define('DB_NAME', $GLOBALS["base_datos"]);       



/**
 * Abre una conexión con la base de datos.
 *
 * @return mysqli La conexión a la base de datos.
 * @throws Exception Si no se puede conectar a la base de datos.
 */
function abrirConexion(){
    // Crear conexión
    $conexion = mysqli_connect(DB_SERVER, DB_USER, DB_PASSWORD, DB_NAME);

    // Verificar conexión
    if (!$conexion) {
        throw new Exception("Error de conexión: " . mysqli_connect_error());
    }

    // Establecer el conjunto de caracteres a utf8
    if (!mysqli_set_charset($conexion, "utf8")) {
        throw new Exception("Error cargando el conjunto de caracteres utf8: " . mysqli_error($conexion));
    }

    return $conexion;
}


/**
 * Cierra una conexión con la base de datos.
 *
 * @param mysqli $conexion La conexión a cerrar.
 * @return void
 */
function cerrarConexion($conexion){
    mysqli_close($conexion);
}



/**
 * Inserta una nueva habitación en la base de datos.
 *
 * @param mysqli $conexion La conexión a la base de datos.
 * @param array $datos Asociativo con los datos de la habitación.
 * @return bool Verdadero si se insertó correctamente, falso de lo contrario.
 * @throws Exception Si ocurre un error en la consulta.
 */
function crearHabitacion($conexion, $datos){
    $stmt = mysqli_prepare($conexion, "INSERT INTO habitaciones (tipo, descripcion, capacidad, precio, disponibles, imagen) VALUES (?, ?, ?, ?, ?, ?)");
    if (!$stmt) {
        throw new Exception("Error en la preparación de la sentencia: " . mysqli_error($conexion));
    }

    mysqli_stmt_bind_param($stmt, "ssiddi", 
        $datos['tipo'], 
        $datos['descripcion'], 
        $datos['capacidad'], 
        $datos['precio'], 
        $datos['disponibles'], 
        $datos['imagen']
    );

    if (!mysqli_stmt_execute($stmt)) {
        throw new Exception("Error en la ejecución de la sentencia: " . mysqli_stmt_error($stmt));
    }

    $exito = mysqli_stmt_affected_rows($stmt) > 0;

    mysqli_stmt_close($stmt);

    return $exito;
}

/**
 * Obtiene todas las habitaciones de la base de datos.
 *
 * @param mysqli $conexion La conexión a la base de datos.
 * @return array Array de habitaciones.
 * @throws Exception Si ocurre un error en la consulta.
 */
function listarHabitaciones($conexion){
    $query = "SELECT * FROM habitaciones";
    $resultado = mysqli_query($conexion, $query);

    if (!$resultado) {
        throw new Exception("Error al listar habitaciones: " . mysqli_error($conexion));
    }

    $habitaciones = [];
    while ($fila = mysqli_fetch_assoc($resultado)) {
        $habitaciones[] = $fila;
    }

    mysqli_free_result($resultado);
    return $habitaciones;
}

/**
 * Obtiene una habitación específica por su ID.
 *
 * @param mysqli $conexion La conexión a la base de datos.
 * @param int $id_habitacion ID de la habitación.
 * @return array|null La habitación como array asociativo o null si no se encuentra.
 * @throws Exception Si ocurre un error en la consulta.
 */
function obtenerHabitacion($conexion, $id_habitacion){
    $stmt = mysqli_prepare($conexion, "SELECT * FROM habitaciones WHERE id_habitacion = ?");
    if (!$stmt) {
        throw new Exception("Error en la preparación de la sentencia: " . mysqli_error($conexion));
    }

    mysqli_stmt_bind_param($stmt, "i", $id_habitacion);

    if (!mysqli_stmt_execute($stmt)) {
        throw new Exception("Error en la ejecución de la sentencia: " . mysqli_stmt_error($stmt));
    }

    $resultado = mysqli_stmt_get_result($stmt);
    $habitacion = mysqli_fetch_assoc($resultado);

    mysqli_stmt_close($stmt);

    return $habitacion ? $habitacion : null;
}

/**
  * Actualiza una habitación en la base de datos.
  *
  * @param mysqli $conexion La conexión a la base de datos.
  * @param int $id_habitacion ID de la habitación a actualizar.
  * @param array $datos Asociativo con los datos actualizados.
  *                     Si 'imagen' es null, no se actualiza.
  * @return bool Verdadero si se actualizó correctamente, falso de lo contrario.
  * @throws Exception Si ocurre un error en la consulta.
  */
  function editarHabitacion($conexion, $id_habitacion, $datos){
    if (!empty($datos['imagen'])) {
        // Si se actualiza la imagen
        $stmt = mysqli_prepare($conexion, "UPDATE habitaciones SET tipo = ?, descripcion = ?, capacidad = ?, precio = ?, disponibles = ?, imagen = ? WHERE id_habitacion = ?");
        if (!$stmt) {
            throw new Exception("Error en la preparación de la sentencia: " . mysqli_error($conexion));
        }
        mysqli_stmt_bind_param($stmt, "ssiddsi", 
            $datos['tipo'], 
            $datos['descripcion'], 
            $datos['capacidad'], 
            $datos['precio'], 
            $datos['disponibles'], 
            $datos['imagen'],
            $id_habitacion
        );
    } else {
        // Si no se actualiza la imagen
        $stmt = mysqli_prepare($conexion, "UPDATE habitaciones SET tipo = ?, descripcion = ?, capacidad = ?, precio = ?, disponibles = ? WHERE id_habitacion = ?");
        if (!$stmt) {
            throw new Exception("Error en la preparación de la sentencia: " . mysqli_error($conexion));
        }
        mysqli_stmt_bind_param($stmt, "ssiddi", 
            $datos['tipo'], 
            $datos['descripcion'], 
            $datos['capacidad'], 
            $datos['precio'], 
            $datos['disponibles'], 
            $id_habitacion
        );
    }

    if (!mysqli_stmt_execute($stmt)) {
        throw new Exception("Error en la ejecución de la sentencia: " . mysqli_stmt_error($stmt));
    }

    $exito = mysqli_stmt_affected_rows($stmt) > 0;

    mysqli_stmt_close($stmt);

    return $exito;
}

/**
 * Elimina una habitación de la base de datos.
 *
 * @param mysqli $conexion La conexión a la base de datos.
 * @param int $id_habitacion ID de la habitación a eliminar.
 * @return bool Verdadero si se eliminó correctamente, falso de lo contrario.
 * @throws Exception Si ocurre un error en la consulta.
 */
function eliminarHabitacion($conexion, $id_habitacion){
    $stmt = mysqli_prepare($conexion, "DELETE FROM habitaciones WHERE id_habitacion = ?");
    if (!$stmt) {
        throw new Exception("Error en la preparación de la sentencia: " . mysqli_error($conexion));
    }

    mysqli_stmt_bind_param($stmt, "i", $id_habitacion);

    if (!mysqli_stmt_execute($stmt)) {
        throw new Exception("Error en la ejecución de la sentencia: " . mysqli_stmt_error($stmt));
    }

    $exito = mysqli_stmt_affected_rows($stmt) > 0;

    mysqli_stmt_close($stmt);

    return $exito;
}

/**
 * Maneja la subida de una imagen de manera segura.
 *
 * @param array $archivo Información del archivo subido ($_FILES['imagen']).
 * @return string Nombre único de la imagen guardada.
 * @throws Exception Si ocurre un error durante la subida.
 */
function subirImagen($archivo){
    $directorio = __DIR__ . '/recursos/habitaciones/';
    if (!is_dir($directorio)) {
        if (!mkdir($directorio, 0755, true)) {
            throw new Exception("No se pudo crear el directorio de subidas.");
        }
    }

    // Verificar si hubo un error en la subida
    if ($archivo['error'] !== UPLOAD_ERR_OK) {
        throw new Exception("Error en la subida del archivo.");
    }

    // Validar el tipo de archivo (permitir solo imágenes)
    $tiposPermitidos = ['image/jpeg', 'image/png'];
    if (!in_array($archivo['type'], $tiposPermitidos)) {
        throw new Exception("Tipo de archivo no permitido. Solo se permiten JPEG y PNG.");
    }

    // Validar el tamaño del archivo (por ejemplo, máximo 2MB)
    $tamanoMaximo = 2 * 1024 * 1024; // 2MB
    if ($archivo['size'] > $tamanoMaximo) {
        throw new Exception("El tamaño del archivo excede el límite permitido de 2MB.");
    }

    // Generar un nombre único para el archivo
    $ext = pathinfo($archivo['name'], PATHINFO_EXTENSION);
    $nombreUnico = uniqid('habitacion_', true) . '.' . $ext;

    // Mover el archivo al directorio de subidas
    $rutaDestino = $directorio . $nombreUnico;
    if (!move_uploaded_file($archivo['tmp_name'], $rutaDestino)) {
        throw new Exception("No se pudo mover el archivo subido.");
    }

    return $nombreUnico;
}

?>
