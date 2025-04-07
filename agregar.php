<?php
// Conectar a la BD
$conn = new mysqli("localhost", "root", "", "bd_uni");

// Verificar conexión
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// Verificar si los datos fueron enviados por POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitizar entradas para evitar problemas al mostrarlas
    $departamento = htmlspecialchars($_POST["departamento"]);
    $matricula = htmlspecialchars($_POST["matricula"]);
    $semestre = htmlspecialchars($_POST["semestre"]);
    $alerta = htmlspecialchars($_POST["alerta"]);
    $estatus = htmlspecialchars($_POST["estatus"]);

    // Validar que ningún campo esté vacío
    if (empty($departamento) || empty($matricula) || empty($semestre) || empty($alerta) || empty($estatus)) {
        echo "<script>alert('Todos los campos son obligatorios'); window.location.href='index1.php';</script>";
        exit();
    }

    // Preparar la consulta SQL para evitar SQL Injection
    $stmt = $conn->prepare("INSERT INTO matriculas (departamento, matricula, semestre, alerta, estatus) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $departamento, $matricula, $semestre, $alerta, $estatus);

    if ($stmt->execute()) {
        // Redirigir al index 
        header("Location: index1.php?success=1");
        exit();
    } else {
        echo "<script>alert('Error al agregar el registro'); window.location.href='index1.php';</script>";
    }

    $stmt->close();
}

$conn->close();
?>
