<?php
// Configuración de conexión
$usuario = 'tu_usuario';
$contrasena = 'tu_contrasena';
$cadenaConexion = 'localhost/XE'; // recuerda cambiar el servicio

// Conectar a Oracle
$conexion = oci_connect($usuario, $contrasena, $cadenaConexion);

if (!$conexion) {
    $error = oci_error();
    die("Error de conexión: " . $error['message']);
} else {
    echo "Conexión exitosa a Oracle";
}

// Cerrar conexión
oci_close($conexion);
?>

