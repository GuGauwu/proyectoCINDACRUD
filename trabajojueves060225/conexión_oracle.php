<?php
// Datos de conexión 
$usuario = "siae_pruebas";
$contrasena = "xxxx";
$conexion_string = "(DESCRIPTION =
    (ADDRESS = (PROTOCOL = TCP)(HOST = orcdb.unach.mx)(PORT = 1521))
    (CONNECT_DATA =
        (SERVICE_NAME = pdbsaucetux)
    )
)";

// Conectar a Oracle
$conn = oci_connect($usuario, $contrasena, $conexion_string, 'AL32UTF8');

if (!$conn) {
    $e = oci_error();
    die("Error de conexión: " . $e['message']);
} else {
    echo "Conexión exitosa a Oracle.";
}
?>
