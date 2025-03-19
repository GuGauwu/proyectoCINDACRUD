<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tabla de Matrícula</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
<?php if (isset($_GET['delete_success']) && $_GET['delete_success'] == 1): ?>
    <div class="position-fixed top-0 end-0 p-3" style="z-index: 11">
        <div id="toastDelete" class="toast show align-items-center text-bg-danger border-0" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="d-flex">
                <div class="toast-body">
                    🗑️ ¡Registro eliminado con éxito!
                </div>
                <button type="button" class="btn-close me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
        </div>
    </div>
    <script>
        setTimeout(() => {
            let toast = document.getElementById('toastDelete');
            if (toast) {
                toast.classList.remove('show');
            }
        }, 4000); // 4 segundos
    </script>
<?php endif; ?>

<?php if (isset($_GET['add_success']) && $_GET['add_success'] == 1): ?>
    <!-- Modal de éxito para agregar -->
    <div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-success text-white">
                    <h5 class="modal-title" id="addModalLabel">Registro Exitoso</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center">
                    ✅ <br>
                    <h5 class="mt-2">¡Registro agregado con éxito!</h5>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Script para abrir el modal automáticamente -->
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var addModal = new bootstrap.Modal(document.getElementById('addModal'));
            addModal.show();
        });
    </script>
<?php endif; ?>


    <div class="container mt-4">
        <h2 class="text-center">Tabla de Matrícula</h2>
        
        <a href="modal.php" class="btn btn-primary mb-3">Buscar Alumno</a>
        
        <!-- Botón para abrir el modal -->
        <button class="btn btn-success mb-3" data-bs-toggle="modal" data-bs-target="#addModal">
            Agregar Nuevo Registro
        </button>

        <!-- Modal para agregar nuevo registro -->
        <div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addModalLabel">Agregar Nuevo Registro</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form method="POST" action="agregar.php">
                            <div class="mb-3">
                                <label for="departamento" class="form-label">Departamento</label>
                                <input type="text" class="form-control" id="departamento" name="departamento" required>
                            </div>
                            <div class="mb-3">
                                <label for="matricula" class="form-label">Matrícula</label>
                                <input type="text" class="form-control" id="matricula" name="matricula" required>
                            </div>
                            <div class="mb-3">
                                <label for="semestre" class="form-label">Semestre</label>
                                <input type="text" class="form-control" id="semestre" name="semestre" required>
                            </div>
                            <div class="mb-3">
                                <label for="alerta" class="form-label">Alerta</label>
                                <input type="text" class="form-control" id="alerta" name="alerta" required>
                            </div>
                            <div class="mb-3">
                                <label for="estatus" class="form-label">Estatus</label>
                                <select class="form-control" id="estatus" name="estatus" required>
                                    <option value="Activo">Activo</option>
                                    <option value="Inactivo">Inactivo</option>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-primary">Guardar</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tabla de datos -->
        <table class="table table-striped table-hover">
            <thead class="table-dark">
                <tr>
                    <th>Matrícula</th>
                    <th>Departamento</th>
                    <th>Semestre</th>
                    <th>Alerta</th>
                    <th>Estatus</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $conexion = new mysqli('localhost', 'root', '', 'bd_uni');
                $query = "SELECT * FROM matriculas";
                $resultado = $conexion->query($query);
                while ($fila = $resultado->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $fila['matricula'] . "</td>";
                    echo "<td>" . $fila['departamento'] . "</td>";
                    echo "<td>" . $fila['semestre'] . "</td>";
                    echo "<td>" . $fila['alerta'] . "</td>";
                    echo "<td>" . $fila['estatus'] . "</td>";
                    echo "<td>
                            <button class='btn btn-warning btn-sm'>Editar</button>
                            <button class='btn btn-danger btn-sm' data-bs-toggle='modal' data-bs-target='#deleteModal' data-id='" . $fila['matricula'] . "'>
                                🗑️
                            </button>
                          </td>";
                    echo "</tr>";
                }
                $conexion->close();
                ?>
            </tbody>
        </table>
    </div>

    <!-- Modal de Confirmación de Eliminación -->
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel">Confirmar Eliminación</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    ¿Seguro que quieres eliminar este registro permanentemente?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <a id="confirmDeleteBtn" href="#" class="btn btn-danger">Eliminar</a>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            let deleteModal = document.getElementById("deleteModal");
            deleteModal.addEventListener("show.bs.modal", function (event) {
                let button = event.relatedTarget;
                let matricula = button.getAttribute("data-id");
                let confirmDeleteBtn = document.getElementById("confirmDeleteBtn");
                confirmDeleteBtn.href = "eliminar.php?matricula=" + matricula;
            });
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
