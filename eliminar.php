<?php
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: DELETE");
header("Access-Control-Allow-Headers: Content-Type");

// Verifica el método HTTP
if ($_SERVER["REQUEST_METHOD"] !== "DELETE") {
    http_response_code(405); // Método no permitido
    echo json_encode(["error" => "Método no permitido"]);
    exit();
}

// Leer datos JSON del cuerpo
$data = json_decode(file_get_contents("php://input"), true);

// Validar que se haya enviado el ID
if (!isset($data["id"]) || !is_numeric($data["id"])) {
    http_response_code(400); // Solicitud incorrecta
    echo json_encode(["error" => "ID inválido o faltante"]);
    exit();
}

// Conexión a la BD
$conn = new mysqli("localhost", "root", "", "bd_uni");
if ($conn->connect_error) {
    http_response_code(500);
    echo json_encode(["error" => "Error de conexión"]);
    exit();
}

// Preparar y ejecutar la consulta
$stmt = $conn->prepare("DELETE FROM matriculas WHERE id = ?");
$stmt->bind_param("i", $data["id"]);

if ($stmt->execute()) {
    echo json_encode(["success" => true, "message" => "Registro eliminado"]);
} else {
    http_response_code(500);
    echo json_encode(["success" => false, "message" => "No se pudo eliminar"]);
}

$stmt->close();
$conn->close();
?>
