<?php
include 'conexion.php'; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $departamento = $_POST["departamento"];
    $matricula = $_POST["matricula"];
    $semestre = $_POST["semestre"];
    $alerta = $_POST["alerta"];
    $estatus = $_POST["estatus"];

    $sql = "INSERT INTO usuarios (departamento, matricula, semestre, alerta, estatus) VALUES ('$departamento', '$matricula', '$semestre', '$alerta', '$estatus')";
    $query = mysqli_query($conexion, $sql);

    if ($query) {
        header("Location: index1.php?add_success=1"); 
        exit();
    } else {
        echo "Error al agregar el registro: " . mysqli_error($conexion);
    }
}
?>
