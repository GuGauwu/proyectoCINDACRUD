<?php
// URL de la API de alertas
$url = "https://sysweb.unach.mx/Siae/api/Alertas/Obtener";

// Opciones para mejorar la seguridad y manejo de errores
$options = [
    "http" => [
        "method" => "GET",
        "header" => "Content-Type: application/json"
    ]
];
$context = stream_context_create($options);

// Realizamos la solicitud GET
$response = @file_get_contents($url, false, $context);

// Verificamos si la solicitud fue exitosa
if ($response === FALSE) {
    http_response_code(500);
    echo json_encode(["error" => "No se pudo obtener los datos de la API"]);
    exit;
}

// Decodificamos el JSON
$datos = json_decode($response, true);

// Validamos la decodificación
if ($datos === null) {
    http_response_code(500);
    echo json_encode(["error" => "Error al decodificar JSON"]);
    exit;
}

// Enviamos los datos como JSON al frontend
header("Content-Type: application/json");
echo json_encode($datos);
?>
