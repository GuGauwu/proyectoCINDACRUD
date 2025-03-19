<?php
// llamara conexión
require_once("conexión_oracle.php");

// Preparar la llamada
$stid = oci_parse($conn, "BEGIN PKG_ALERTAS.Obt_Grid_Alertas(:p_registros); END;");


// Definir el cursor como parámetro de salida
$cursor = oci_new_cursor($conn);
oci_bind_by_name($stid, ":p_registros", $cursor, -1, OCI_B_CURSOR);

// Ejecutar
oci_execute($stid);
oci_execute($cursor);

// Leer
$alertas = [];
while ($fila = oci_fetch_assoc($cursor)) {
    $alertas[] = $fila; 
}
// Cerrar conexiones
oci_free_statement($stid);
oci_free_statement($cursor);
oci_close($conn);

// Mostrar los resultados en pantalla (para pruebas)
echo "<pre>";
print_r($alertas);
echo "</pre>";
?>
