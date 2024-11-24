<?php


require_once 'config.php';

/**
 * Establece una conexión con la base de datos.
 *
 * @return mysqli Conexión a la base de datos.
 * @throws Exception Si no se puede conectar a la base de datos.
 */
function conectarBD() {
    $conexion = mysqli_connect($GLOBALS["servidor"],$GLOBALS["usuario"],$GLOBALS["contrasena"]);

    if (!$conexion) {
        throw new Exception("Error de conexión: " . mysqli_connect_error());
    }


    return $conexion;
}

/**
 * Cierra la conexión a la base de datos.
 *
 * @param mysqli $conexion Conexión a la base de datos.
 */
function cerrarConexion($conexion) {
    mysqli_close($conexion);
}

/**
 * Ejecuta una consulta preparada y devuelve el resultado.
 *
 * @param mysqli $conexion Conexión a la base de datos.
 * @param string $query Consulta SQL con marcadores de posición (?).
 * @param string $tipos Tipos de los parámetros para bind_param.
 * @param array $parametros Parámetros para la consulta.
 * @return mysqli_stmt Objeto de la sentencia preparada.
 * @throws Exception Si ocurre un error en la preparación o ejecución de la consulta.
 */
function ejecutarConsulta($conexion, $query, $tipos = '', $parametros = []) {
    $stmt = mysqli_prepare($conexion, $query);
    if (!$stmt) {
        throw new Exception("Error en la preparación de la consulta: " . mysqli_error($conexion));
    }

    if ($tipos && $parametros) {
        if (!mysqli_stmt_bind_param($stmt, $tipos, ...$parametros)) {
            throw new Exception("Error en el bind de parámetros: " . mysqli_stmt_error($stmt));
        }
    }

    if (!mysqli_stmt_execute($stmt)) {
        throw new Exception("Error en la ejecución de la consulta: " . mysqli_stmt_error($stmt));
    }

    return $stmt;
}

/**
 * Verifica si un dato existe en la base de datos
 *
 * @param mysqli $conexion Conexión a la base de datos.
 * @param string $query Consulta SQL con marcadores de posición (?).
 * @param string $tipos Tipos de los parámetros para bind_param.
 * @param array $parametros Parámetros para la consulta.
 * @return bool Verdadero si existe, falso en caso contrario.
 * @throws Exception Si ocurre un error en la consulta.
 */
function existeDato($conexion, $query, $tipos = '', $parametros = []) {
    $stmt = ejecutarConsulta($conexion, $query, $tipos, $parametros);
    mysqli_stmt_store_result($stmt);
    $existe = mysqli_stmt_num_rows($stmt) > 0;
    mysqli_stmt_close($stmt);
    return $existe;
}

/**
 * Inserta datos en la base de datos.
 *
 * @param mysqli $conexion Conexión a la base de datos.
 * @param string $query Consulta SQL con marcadores de posición (?).
 * @param string $tipos Tipos de los parámetros para bind_param.
 * @param array $parametros Parámetros para la consulta.
 * @return bool Verdadero si se insertó al menos una fila, falso en caso contrario.
 * @throws Exception Si ocurre un error en la inserción.
 */
function insertarDatos($conexion, $query, $tipos = '', $parametros = []) {
    $stmt = ejecutarConsulta($conexion, $query, $tipos, $parametros);
    $affectedRows = mysqli_stmt_affected_rows($stmt);
    mysqli_stmt_close($stmt);
    return $affectedRows > 0;
}

/**
 * Extrae un registro de la base de datos.
 *
 * @param mysqli $conexion Conexión a la base de datos.
 * @param string $query Consulta SQL con marcadores de posición (?).
 * @param string $tipos Tipos de los parámetros para bind_param.
 * @param array $parametros Parámetros para la consulta.
 * @return array Registro extraído como un array asociativo.
 * @throws Exception Si ocurre un error en la consulta.
 */
function extraerRegistro($conexion, $query, $tipos = '', $parametros = []) {
    $stmt = ejecutarConsulta($conexion, $query, $tipos, $parametros);
    $resultado = mysqli_stmt_get_result($stmt);

    if ($resultado === false) {
        throw new Exception("Error al obtener el resultado: " . mysqli_stmt_error($stmt));
    }

    $registro = mysqli_fetch_assoc($resultado) ?: [];
    mysqli_stmt_close($stmt);
    return $registro;
}

/**
 * Actualiza datos en la base de datos.
 *
 * @param mysqli $conexion Conexión a la base de datos.
 * @param string $query Consulta SQL con marcadores de posición (?).
 * @param string $tipos Tipos de los parámetros para bind_param.
 * @param array $parametros Parámetros para la consulta.
 * @return bool Verdadero si se actualizó al menos una fila, falso en caso contrario.
 * @throws Exception Si ocurre un error en la actualización.
 */
function editarDatos($conexion, $query, $tipos = '', $parametros = []) {
    return insertarDatos($conexion, $query, $tipos, $parametros);
}

/**
 * Elimina datos de la base de datos.
 *
 * @param mysqli $conexion Conexión a la base de datos.
 * @param string $query Consulta SQL con marcadores de posición (?).
 * @param string $tipos Tipos de los parámetros para bind_param.
 * @param array $parametros Parámetros para la consulta.
 * @return bool Verdadero si se eliminó al menos una fila, falso en caso contrario.
 * @throws Exception Si ocurre un error en la eliminación.
 */
function borrarDatos($conexion, $query, $tipos = '', $parametros = []) {
    return insertarDatos($conexion, $query, $tipos, $parametros);
}
?>
