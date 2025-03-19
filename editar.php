<?php
// Conectar a la base de datos
$conn = new mysqli("localhost", "root", "", "bd_uni");

// Verificar conexión
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// Verificar si se ha recibido el ID del registro a editar
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Obtener los datos actuales del registro
    $query = "SELECT * FROM matriculas WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $resultado = $stmt->get_result();
    $registro = $resultado->fetch_assoc();
    
    // Si no existe el registro, redirigir al index
    if (!$registro) {
        echo "<script>alert('Registro no encontrado'); window.location.href='index1.php';</script>";
        exit;
    }

    $descripcion = $registro['descripcion'];
    $matricula = $registro['matricula'];
    $semestre = $registro['semestre'];
    $alerta = $registro['alerta'];
}

// Verificar si los datos fueron enviados por POST (al hacer el submit del formulario)
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST["id"];
    $descripcion = $_POST["descripcion"];
    $matricula = $_POST["matricula"];
    $semestre = $_POST["semestre"];
    $alerta = $_POST["alerta"];

    // Evitar SQL Injection
    $stmt = $conn->prepare("UPDATE matriculas SET descripcion = ?, matricula = ?, semestre = ?, alerta = ? WHERE id = ?");
    $stmt->bind_param("ssssi", $descripcion, $matricula, $semestre, $alerta, $id);

    if ($stmt->execute()) {
        echo "<script>alert('Registro actualizado con éxito'); window.location.href='index1.php';</script>";
    } else {
        echo "<script>alert('Error al actualizar'); window.location.href='index1.php';</script>";
    }

    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Registro</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-4">
        <h2 class="text-center">Editar Registro</h2>

        <form method="POST" action="editar.php">
            <input type="hidden" name="id" value="<?php echo $id; ?>">

            <div class="mb-3">
                <label for="descripcion" class="form-label">Descripción</label>
                <input type="text" class="form-control" id="descripcion" name="descripcion" value="<?php echo $descripcion; ?>" required>
            </div>

            <div class="mb-3">
                <label for="matricula" class="form-label">Matrícula</label>
                <input type="text" class="form-control" id="matricula" name="matricula" value="<?php echo $matricula; ?>" required>
            </div>

            <div class="mb-3">
                <label for="semestre" class="form-label">Semestre</label>
                <input type="text" class="form-control" id="semestre" name="semestre" value="<?php echo $semestre; ?>" required>
            </div>

            <div class="mb-3">
                <label for="alerta" class="form-label">Alerta</label>
                <input type="text" class="form-control" id="alerta" name="alerta" value="<?php echo $alerta; ?>" required>
            </div>

            <button type="submit" class="btn btn-primary">Actualizar</button>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
