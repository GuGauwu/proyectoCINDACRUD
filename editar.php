<?php
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");

// Conexión
$conn = new mysqli("localhost", "root", "", "bd_uni");
if ($conn->connect_error) {
    http_response_code(500);
    echo json_encode(["error" => "Error de conexión"]);
    exit;
}

// Obtener datos JSON desde el cuerpo de la petición
$data = json_decode(file_get_contents("php://input"), true);

// Verificar si están todos los campos
if (
    isset($data["id"]) && isset($data["descripcion"]) &&
    isset($data["departamento"]) && isset($data["matricula"]) &&
    isset($data["semestre"]) && isset($data["alerta"]) &&
    isset($data["estatus"])
) {
    $stmt = $conn->prepare("UPDATE matriculas SET descripcion = ?, departamento = ?, matricula = ?, semestre = ?, alerta = ?, estatus = ? WHERE id = ?");
    $stmt->bind_param("sssssssi", 
        $data["descripcion"], 
        $data["departamento"], 
        $data["matricula"], 
        $data["semestre"], 
        $data["alerta"], 
        $data["estatus"], 
        $data["id"]
    );

    if ($stmt->execute()) {
        echo json_encode(["success" => true, "message" => "Registro actualizado correctamente"]);
    } else {
        http_response_code(500);
        echo json_encode(["success" => false, "message" => "Error al actualizar"]);
    }

    $stmt->close();
} else {
    http_response_code(400);
    echo json_encode(["error" => "Faltan datos"]);
}

$conn->close();
?>
