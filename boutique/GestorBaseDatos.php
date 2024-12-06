<?php

require_once 'config.inc.php';

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

    mysqli_stmt_bind_param($stmt, "ssidis", 
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
function subirImagen($archivo) {
    // Define el directorio de destino
    $directorio = __DIR__ . '/Habitaciones/imagenes/';

    // Verificar si el directorio existe
    if (!is_dir($directorio)) {
        throw new Exception("El directorio no existe: $directorio");
    }

    // Verificar si hubo un error en la subida
    if ($archivo['error'] !== UPLOAD_ERR_OK) {
        throw new Exception("Error al subir el archivo. Código de error: " . $archivo['error']);
    }

    // Verificar si el archivo temporal existe
    if (!file_exists($archivo['tmp_name'])) {
        throw new Exception("El archivo temporal no existe: " . $archivo['tmp_name']);
    }

    // Validar la extensión del archivo
    $extensionesPermitidas = ['jpg', 'jpeg', 'png', 'webp', 'gif'];
    $extension = strtolower(pathinfo($archivo['name'], PATHINFO_EXTENSION));
    if (!in_array($extension, $extensionesPermitidas)) {
        throw new Exception("Formato de archivo no permitido. Solo se permiten: " . implode(', ', $extensionesPermitidas));
    }

    // Generar un nombre único para evitar colisiones
    $nombreArchivo = uniqid('img_') . '.' . $extension;

    // Ruta completa de destino
    $rutaDestino = $directorio . $nombreArchivo;

    // Mover el archivo subido al directorio
    if (!move_uploaded_file($archivo['tmp_name'], $rutaDestino)) {
        throw new Exception("No se pudo mover el archivo al directorio destino: $rutaDestino");
    }

    // Retornar el nombre del archivo (sin la ruta completa)
    return $nombreArchivo;
}


/**
 * Crea un nuevo usuario en la base de datos.
 *
 * @param mysqli $conexion La conexión a la base de datos.
 * @param array $datos Asociativo con los datos del usuario.
 * @return bool Verdadero si se creó correctamente, falso de lo contrario.
 * @throws Exception Si ocurre un error en la consulta.
 */
function crearUsuario($conexion, $datos){
    $stmt = mysqli_prepare($conexion, "INSERT INTO usuarios (nombre_usuario, contrasena, tipo_usuario, nombre_completo, email) VALUES (?, ?, ?, ?, ?)");
    if (!$stmt) {
        throw new Exception("Error en la preparación de la sentencia: " . mysqli_error($conexion));
    }

    

    mysqli_stmt_bind_param($stmt, "sssss", 
        $datos['nombre_usuario'], 
        $datos['contrasena'], 
        $datos['tipo_usuario'], 
        $datos['nombre_completo'], 
        $datos['email']
    );

    if (!mysqli_stmt_execute($stmt)) {
        throw new Exception("Error en la ejecución de la sentencia: " . mysqli_stmt_error($stmt));
    }

    $exito = mysqli_stmt_affected_rows($stmt) > 0;

    mysqli_stmt_close($stmt);

    return $exito;
}

/**
 * Obtiene todos los usuarios de la base de datos.
 *
 * @param mysqli $conexion La conexión a la base de datos.
 * @return array Array de usuarios.
 * @throws Exception Si ocurre un error en la consulta.
 */
function listarUsuarios($conexion){
    $query = "SELECT id_usuario, nombre_usuario, tipo_usuario, nombre_completo, email, fecha_registro FROM usuarios";
    $resultado = mysqli_query($conexion, $query);

    if (!$resultado) {
        throw new Exception("Error al listar usuarios: " . mysqli_error($conexion));
    }

    $usuarios = [];
    while ($fila = mysqli_fetch_assoc($resultado)) {
        $usuarios[] = $fila;
    }

    mysqli_free_result($resultado);
    return $usuarios;
}

/**
 * Obtiene un usuario específico por su ID.
 *
 * @param mysqli $conexion La conexión a la base de datos.
 * @param int $id_usuario ID del usuario.
 * @return array|null El usuario como array asociativo o null si no se encuentra.
 * @throws Exception Si ocurre un error en la consulta.
 */
function obtenerUsuario($conexion, $id_usuario){
    $stmt = mysqli_prepare($conexion, "SELECT id_usuario, nombre_usuario, tipo_usuario, nombre_completo, email, fecha_registro FROM usuarios WHERE id_usuario = ?");
    if (!$stmt) {
        throw new Exception("Error en la preparación de la sentencia: " . mysqli_error($conexion));
    }

    mysqli_stmt_bind_param($stmt, "i", $id_usuario);

    if (!mysqli_stmt_execute($stmt)) {
        throw new Exception("Error en la ejecución de la sentencia: " . mysqli_stmt_error($stmt));
    }

    $resultado = mysqli_stmt_get_result($stmt);
    $usuario = mysqli_fetch_assoc($resultado);

    mysqli_stmt_close($stmt);

    return $usuario ? $usuario : null;
}

/**
 * Actualiza un usuario en la base de datos.
 *
 * @param mysqli $conexion La conexión a la base de datos.
 * @param int $id_usuario ID del usuario a actualizar.
 * @param array $datos Asociativo con los datos actualizados.
 *                     Si 'contrasena' está vacío, no se actualiza.
 * @return bool Verdadero si se actualizó correctamente, falso de lo contrario.
 * @throws Exception Si ocurre un error en la consulta.
 */
function editarUsuario($conexion, $id_usuario, $datos){
    if (!empty($datos['contrasena'])) {
        // Si se actualiza la contraseña
        $stmt = mysqli_prepare($conexion, "UPDATE usuarios SET nombre_usuario = ?, contrasena = ?, tipo_usuario = ?, nombre_completo = ?, email = ? WHERE id_usuario = ?");
        if (!$stmt) {
            throw new Exception("Error en la preparación de la sentencia: " . mysqli_error($conexion));
        }

        

        mysqli_stmt_bind_param($stmt, "sssssi", 
            $datos['nombre_usuario'], 
            $datos['contrasena'], 
            $datos['tipo_usuario'], 
            $datos['nombre_completo'], 
            $datos['email'],
            $id_usuario
        );
    } else {
        // Si no se actualiza la contraseña
        $stmt = mysqli_prepare($conexion, "UPDATE usuarios SET nombre_usuario = ?, tipo_usuario = ?, nombre_completo = ?, email = ? WHERE id_usuario = ?");
        if (!$stmt) {
            throw new Exception("Error en la preparación de la sentencia: " . mysqli_error($conexion));
        }

        mysqli_stmt_bind_param($stmt, "ssssi", 
            $datos['nombre_usuario'], 
            $datos['tipo_usuario'], 
            $datos['nombre_completo'], 
            $datos['email'],
            $id_usuario
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
 * Elimina un usuario de la base de datos.
 *
 * @param mysqli $conexion La conexión a la base de datos.
 * @param int $id_usuario ID del usuario a eliminar.
 * @return bool Verdadero si se eliminó correctamente, falso de lo contrario.
 * @throws Exception Si ocurre un error en la consulta.
 */
function eliminarUsuario($conexion, $id_usuario){
    $stmt = mysqli_prepare($conexion, "DELETE FROM usuarios WHERE id_usuario = ?");
    if (!$stmt) {
        throw new Exception("Error en la preparación de la sentencia: " . mysqli_error($conexion));
    }

    mysqli_stmt_bind_param($stmt, "i", $id_usuario);

    if (!mysqli_stmt_execute($stmt)) {
        throw new Exception("Error en la ejecución de la sentencia: " . mysqli_stmt_error($stmt));
    }

    $exito = mysqli_stmt_affected_rows($stmt) > 0;

    mysqli_stmt_close($stmt);

    return $exito;
}

/**
 * Validar el tipo de usuario.
 *
 * @param string $tipo_usuario Tipo de usuario a validar.
 * @return bool Verdadero si es válido, falso de lo contrario.
 */
function validarTipoUsuario($tipo_usuario){
    $tiposPermitidos = ['Administrador', 'Huesped'];
    return in_array($tipo_usuario, $tiposPermitidos);
}

/**
 * Busca habitaciones según tipo y/o palabras clave en la descripción.
 *
 * @param mysqli $conexion La conexión a la base de datos.
 * @param string $tipo El tipo de habitación para filtrar (puede estar vacío).
 * @param string $keywords Las palabras clave para la búsqueda en tipo y descripción.
 * @return array Array de habitaciones que coinciden con la búsqueda.
 * @throws Exception Si ocurre un error en la consulta.
 */
function buscarHabitaciones($conexion, $tipo = '', $keywords = ''){
    // Construir la consulta base
    $consulta = "SELECT * FROM habitaciones WHERE 1=1";
    $params = [];
    
    // Añadir condiciones según los parámetros proporcionados
    if (!empty($tipo)) {
        $consulta .= " AND tipo = ?";
        $params[] = $tipo;
    }
    
    if (!empty($keywords)) {
        $consulta .= " AND (tipo LIKE ? OR descripcion LIKE ?)";
        $likeKeywords = '%' . $keywords . '%';
        $params[] = $likeKeywords;
        $params[] = $likeKeywords;
    }
    
    // Preparar la sentencia
    $stmt = mysqli_prepare($conexion, $consulta);
    if (!$stmt) {
        throw new Exception("Error en la preparación de la sentencia: " . mysqli_error($conexion));
    }

    // Vincular los parámetros si existen
    if (!empty($params)) {
        // Crear una cadena de tipos para los parámetros
        $types = str_repeat('s', count($params));
        mysqli_stmt_bind_param($stmt, $types, ...$params);
    }

    // Ejecutar la sentencia
    if (!mysqli_stmt_execute($stmt)) {
        throw new Exception("Error en la ejecución de la sentencia: " . mysqli_stmt_error($stmt));
    }

    // Obtener el resultado
    $resultado = mysqli_stmt_get_result($stmt);
    $habitaciones = [];
    while ($fila = mysqli_fetch_assoc($resultado)) {
        $habitaciones[] = $fila;
    }

    mysqli_stmt_close($stmt);
    return $habitaciones;
}

// -------------- Nuevas Funciones para Reservaciones ---------------

/**
 * Crea una nueva reservación en la base de datos.
 *
 * @param mysqli $conexion La conexión a la base de datos.
 * @param array $datos Asociativo con los datos de la reservación.
 *                     Debe contener 'id_usuario', 'fecha_entrada', 'fecha_salida', 'total'.
 * @return int ID de la reservación creada.
 * @throws Exception Si ocurre un error en la consulta.
 */
function crearReservacion($conexion, $datos){
    $stmt = mysqli_prepare($conexion, "INSERT INTO reservaciones (id_usuario, fecha_entrada, fecha_salida, estado, total) VALUES (?, ?, ?, 'Confirmada', ?)");
    if (!$stmt) {
        throw new Exception("Error en la preparación de la sentencia: " . mysqli_error($conexion));
    }

    mysqli_stmt_bind_param($stmt, "issi", 
        $datos['id_usuario'], 
        $datos['fecha_entrada'], 
        $datos['fecha_salida'], 
        $datos['total']
    );

    if (!mysqli_stmt_execute($stmt)) {
        throw new Exception("Error en la ejecución de la sentencia: " . mysqli_stmt_error($stmt));
    }

    $id_reservacion = mysqli_insert_id($conexion);

    mysqli_stmt_close($stmt);

    return $id_reservacion;
}

/**
 * Crea un detalle de reservación en la base de datos.
 *
 * @param mysqli $conexion La conexión a la base de datos.
 * @param array $datos Asociativo con los datos del detalle de la reservación.
 *                     Debe contener 'id_reservacion', 'id_habitacion', 'cantidad', 'subtotal'.
 * @return bool Verdadero si se insertó correctamente, falso de lo contrario.
 * @throws Exception Si ocurre un error en la consulta.
 */
function crearDetalleReservacion($conexion, $datos){
    $stmt = mysqli_prepare($conexion, "INSERT INTO detalle_reservacion (id_reservacion, id_habitacion, cantidad, subtotal) VALUES (?, ?, ?, ?)");
    if (!$stmt) {
        throw new Exception("Error en la preparación de la sentencia: " . mysqli_error($conexion));
    }

    mysqli_stmt_bind_param($stmt, "iiid", 
        $datos['id_reservacion'], 
        $datos['id_habitacion'], 
        $datos['cantidad'], 
        $datos['subtotal']
    );

    if (!mysqli_stmt_execute($stmt)) {
        throw new Exception("Error en la ejecución de la sentencia: " . mysqli_stmt_error($stmt));
    }

    $exito = mysqli_stmt_affected_rows($stmt) > 0;

    mysqli_stmt_close($stmt);

    return $exito;
}

/**
 * Actualiza la cantidad de habitaciones disponibles.
 *
 * @param mysqli $conexion La conexión a la base de datos.
 * @param int $id_habitacion ID de la habitación.
 * @param int $cantidad Cantidad a restar de las disponibles.
 * @return bool Verdadero si se actualizó correctamente, falso de lo contrario.
 * @throws Exception Si ocurre un error en la consulta.
 */
function actualizarDisponiblesHabitacion($conexion, $id_habitacion, $cantidad){
    $stmt = mysqli_prepare($conexion, "UPDATE habitaciones SET disponibles = disponibles - ? WHERE id_habitacion = ? AND disponibles >= ?");
    if (!$stmt) {
        throw new Exception("Error en la preparación de la sentencia: " . mysqli_error($conexion));
    }

    mysqli_stmt_bind_param($stmt, "iii", 
        $cantidad, 
        $id_habitacion, 
        $cantidad
    );

    if (!mysqli_stmt_execute($stmt)) {
        throw new Exception("Error en la ejecución de la sentencia: " . mysqli_stmt_error($stmt));
    }

    $exito = mysqli_stmt_affected_rows($stmt) > 0;

    mysqli_stmt_close($stmt);

    return $exito;
}

/**
 * Obtiene los detalles de una habitación específica.
 *
 * @param mysqli $conexion La conexión a la base de datos.
 * @param int $id_habitacion ID de la habitación.
 * @return array|null La habitación como array asociativo o null si no se encuentra.
 * @throws Exception Si ocurre un error en la consulta.
 */
function obtenerHabitacionDetalle($conexion, $id_habitacion){
    return obtenerHabitacion($conexion, $id_habitacion);
}


?>
