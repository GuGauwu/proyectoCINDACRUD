<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Gestión de Alertas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container py-5">
    <h1 class="mb-4">📋 Lista de Alertas</h1>
    <table class="table table-bordered table-hover">
        <thead class="table-dark text-center">
            <tr>
                <th>Matrícula</th>
                <th>Departamento</th>
                <th>Semestre</th>
                <th>Alerta</th>
                <th>Estatus</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody id="alertaTableBody" class="text-center">
            <!-- Las filas serán insertadas aquí por JavaScript -->
        </tbody>
    </table>
</div>

<!-- Modal Editar -->
<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form id="editForm" class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Editar Alerta</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
      </div>
      <div class="modal-body">
        <input type="hidden" id="editId" name="matricula">
        <div class="mb-3">
          <label for="editDepartamento" class="form-label">Departamento</label>
          <input type="text" class="form-control" id="editDepartamento" required>
        </div>
        <div class="mb-3">
          <label for="editSemestre" class="form-label">Semestre</label>
          <input type="text" class="form-control" id="editSemestre" required>
        </div>
        <div class="mb-3">
          <label for="editAlerta" class="form-label">Alerta</label>
          <input type="text" class="form-control" id="editAlerta" required>
        </div>
        <div class="mb-3">
          <label for="editEstatus" class="form-label">Estatus</label>
          <select class="form-control" id="editEstatus" required>
            <option value="Activo">Activo</option>
            <option value="Inactivo">Inactivo</option>
          </select>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
        <button type="submit" class="btn btn-primary">Guardar Cambios</button>
      </div>
    </form>
  </div>
</div>

<!-- Modal Eliminar -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Eliminar Alerta</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
      </div>
      <div class="modal-body">
        ¿Estás seguro que deseas eliminar esta alerta?
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-danger" id="confirmDelete">Eliminar</button>
      </div>
    </div>
  </div>
</div>

<script>
    const tablaBody = document.getElementById('alertaTableBody');
    let deleteId = null;

    function cargarAlertas() {
        fetch('http://localhost/api/api.php')
            .then(res => res.json())
            .then(data => {
                tablaBody.innerHTML = '';
                data.forEach(fila => {
                    const tr = document.createElement('tr');
                    tr.innerHTML = `
                        <td>${fila.matricula}</td>
                        <td>${fila.departamento}</td>
                        <td>${fila.semestre}</td>
                        <td>${fila.alerta}</td>
                        <td>${fila.estatus}</td>
                        <td>
                            <button class="btn btn-warning btn-sm" 
                                data-bs-toggle="modal" 
                                data-bs-target="#editModal"
                                data-id="${fila.matricula}"
                                data-departamento="${fila.departamento}"
                                data-semestre="${fila.semestre}"
                                data-alerta="${fila.alerta}"
                                data-estatus="${fila.estatus}">
                                ✏️ Editar
                            </button>
                            <button class="btn btn-danger btn-sm" 
                                data-bs-toggle="modal" 
                                data-bs-target="#deleteModal"
                                data-id="${fila.matricula}">
                                🗑️ Eliminar
                            </button>
                        </td>
                    `;
                    tablaBody.appendChild(tr);
                });
            })
            .catch(err => console.error("Error al cargar alertas:", err));
    }

    // Modal eliminar
    const deleteModal = document.getElementById('deleteModal');
    deleteModal.addEventListener('show.bs.modal', function (event) {
        const button = event.relatedTarget;
        deleteId = button.getAttribute('data-id');
    });

    document.getElementById('confirmDelete').addEventListener('click', function () {
        fetch('http://localhost/api/eliminar.php', {
            method: 'DELETE',
            headers: {'Content-Type': 'application/json'},
            body: JSON.stringify({ matricula: deleteId })
        })
        .then(res => res.ok ? location.reload() : alert("Error al eliminar"))
        .catch(err => console.error("Error en delete:", err));
    });

    // Modal editar
    const editModal = document.getElementById('editModal');
    editModal.addEventListener('show.bs.modal', function (event) {
        const button = event.relatedTarget;

        document.getElementById('editId').value = button.getAttribute('data-id');
        document.getElementById('editDepartamento').value = button.getAttribute('data-departamento');
        document.getElementById('editSemestre').value = button.getAttribute('data-semestre');
        document.getElementById('editAlerta').value = button.getAttribute('data-alerta');
        document.getElementById('editEstatus').value = button.getAttribute('data-estatus');
    });

    document.getElementById('editForm').addEventListener('submit', function (e) {
        e.preventDefault();

        const data = {
            matricula: document.getElementById('editId').value,
            departamento: document.getElementById('editDepartamento').value,
            semestre: document.getElementById('editSemestre').value,
            alerta: document.getElementById('editAlerta').value,
            estatus: document.getElementById('editEstatus').value
        };

        fetch('http://localhost/api/modificar.php', {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(data)
        })
        .then(res => res.ok ? location.reload() : alert("Error al actualizar"))
        .catch(err => console.error("Error en fetch:", err));
    });

    // Cargar datos al inicio
    document.addEventListener('DOMContentLoaded', cargarAlertas);
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
