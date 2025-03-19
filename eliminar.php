<?php
// Conexión
$conexion = new mysqli('localhost', 'root', '', 'bd_uni');

// Verificar
if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

// Verificar si se recibió 
if (isset($_GET['matricula'])) {
    $matricula = $_GET['matricula'];

    // Preparar la consulta SQL para eliminar 
    $query = "DELETE FROM matriculas WHERE matricula = ?";
    $stmt = $conexion->prepare($query);
    $stmt->bind_param("s", $matricula);

    // Ejecutar la consulta
    if ($stmt->execute()) {
        // Redirecciona con un mensaje de éxito
        header("Location: index1.php?delete_success=1");
    } else {
        // Redirecciona con un mensaje de error
        header("Location: index1.php?delete_error=1");
    }

    $stmt->close();
} else {
    // Si no se recibió una matrícula válida, redireccionar con un error
    header("Location: index1.php?delete_error=1");
}

$conexion->close();
?>
