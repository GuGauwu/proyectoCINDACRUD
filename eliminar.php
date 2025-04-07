<a href="eliminar.php?id=<?php echo $fila['id']; ?>" onclick="return confirm('¿Estás seguro?')">Eliminar</a>
<?
// Conexión
$conexion = new mysqli('localhost', 'root', '', 'bd_uni');

// Verificar
if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

// Verificar si se recibió el ID
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = $_GET['id'];

    // Preparar la consulta SQL para eliminar por ID
    $query = "DELETE FROM matriculas WHERE id = ?";
    $stmt = $conexion->prepare($query);
    $stmt->bind_param("i", $id);

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
    // Si no se recibió un ID válido, redireccionar con un error
    header("Location: index1.php?delete_error=1");
}

$conexion->close();
?>
