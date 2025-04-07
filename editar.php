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

    if (!$registro) {
        echo "<script>alert('Registro no encontrado'); window.location.href='index1.php';</script>";
        exit;
    }

    // Variables del formulario
    $descripcion = $registro['descripcion'];
    $departamento = $registro['departamento'];
    $matricula = $registro['matricula'];
    $semestre = $registro['semestre'];
    $alerta = $registro['alerta'];
    $estatus = $registro['estatus'];
}

// Si se envió el formulario (POST)
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST["id"];
    $descripcion = htmlspecialchars($_POST["descripcion"]);
    $departamento = htmlspecialchars($_POST["departamento"]);
    $matricula = htmlspecialchars($_POST["matricula"]);
    $semestre = htmlspecialchars($_POST["semestre"]);
    $alerta = htmlspecialchars($_POST["alerta"]);
    $estatus = htmlspecialchars($_POST["estatus"]);

    // Validar campos vacíos
    if (empty($descripcion) || empty($departamento) || empty($matricula) || empty($semestre) || empty($alerta) || empty($estatus)) {
        echo "<script>alert('Todos los campos son obligatorios'); window.location.href='index1.php';</script>";
        exit();
    }    

    // Actualizar en la base de datos
    $stmt = $conn->prepare("UPDATE matriculas SET descripcion = ?, departamento = ?, matricula = ?, semestre = ?, alerta = ?, estatus = ? WHERE id = ?");
    $stmt->bind_param("ssssssi", $descripcion, $departamento, $matricula, $semestre, $alerta, $estatus, $id);

    if ($stmt->execute()) {
        echo "<script>alert('Registro actualizado con éxito'); window.location.href='index1.php';</script>";
    } else {
        echo "<script>alert('Error al actualizar'); window.location.href='index1.php';</script>";
    }

    $stmt->close();
}

$conn->close();
?>
<form method="POST" action="editar.php">
    <input type="hidden" name="id" value="<?php echo $id; ?>">

    <div class="mb-3">
        <label for="descripcion" class="form-label">Descripción</label>
        <input type="text" class="form-control" id="descripcion" name="descripcion" value="<?php echo $descripcion; ?>" required>
    </div>

    <div class="mb-3">
        <label for="departamento" class="form-label">Departamento</label>
        <input type="text" class="form-control" id="departamento" name="departamento" value="<?php echo $departamento; ?>" required>
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

    <div class="mb-3">
        <label for="estatus" class="form-label">Estatus</label>
        <select class="form-control" id="estatus" name="estatus" required>
            <option value="Activo" <?php if ($estatus == 'Activo') echo 'selected'; ?>>Activo</option>
            <option value="Inactivo" <?php if ($estatus == 'Inactivo') echo 'selected'; ?>>Inactivo</option>
        </select>
    </div>

    <button type="submit" class="btn btn-primary">Actualizar</button>
</form>
