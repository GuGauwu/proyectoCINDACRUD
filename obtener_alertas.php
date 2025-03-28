<?php
// link de la API
$url = "https://sysweb.unach.mx/Siae/api/Alertas/Obtener";

// Hacemos la solicitud GET a la API
$response = file_get_contents($url);

//validacion de la respuesta
if ($response === FALSE) {
    echo json_encode(["error" => "No se pudo obtener los datos de la API"]);
    exit;
}

// Convertir a JSON en un array PHP
$datos = json_decode($response, true);

// verificamos si los datos se decodificaron correctamente
if ($datos === null) {
    echo json_encode(["error" => "Error al decodificar JSON"]);
    exit;
}
// Enviar los datos a la tabla en formato JSON
header("Content-Type: application/json");
echo json_encode($datos);
?>
