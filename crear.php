<?php
// Encabezados
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Content-Type: application/json");

// Conexión a la base de datos
$conn = new mysqli("localhost", "root", "", "bd_uni");

// Verificar conexión
if ($conn->connect_error) {
    http_response_code(500);
    echo json_encode(["mensaje" => "Error en la conexión"]);
    exit();
}

// Obtener los datos JSON del cuerpo de la solicitud
$input = json_decode(file_get_contents("php://input"), true);

// Validar que todos los campos estén presentes
if (
    isset($input["departamento"]) && isset($input["matricula"]) &&
    isset($input["semestre"]) && isset($input["alerta"]) &&
    isset($input["estatus"])
) {
    $departamento = $conn->real_escape_string($input["departamento"]);
    $matricula = $conn->real_escape_string($input["matricula"]);
    $semestre = $conn->real_escape_string($input["semestre"]);
    $alerta = $conn->real_escape_string($input["alerta"]);
    $estatus = $conn->real_escape_string($input["estatus"]);

    $stmt = $conn->prepare("INSERT INTO matriculas (departamento, matricula, semestre, alerta, estatus) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $departamento, $matricula, $semestre, $alerta, $estatus);

    if ($stmt->execute()) {
        echo json_encode(["mensaje" => "Registro agregado correctamente"]);
    } else {
        http_response_code(500);
        echo json_encode(["mensaje" => "Error al agregar"]);
    }

    $stmt->close();
} else {
    http_response_code(400);
    echo json_encode(["mensaje" => "Faltan campos requeridos"]);
}

$conn->close();
