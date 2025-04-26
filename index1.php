<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Lista de Alertas</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 p-6">

<div class="max-w-6xl mx-auto">
    <h1 class="text-3xl font-bold mb-6">Lista de Alertas</h1>

    <!-- Botón para mostrar/ocultar formulario -->
    <div class="mb-4">
        <button id="btnAgregar" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700 transition">
            Agregar Nueva Alerta
        </button>
    </div>

    <!-- Formulario oculto para nueva alerta -->
    <form id="formAlerta" class="bg-white p-6 rounded-lg shadow-md mb-6 hidden">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
            <input type="text" id="matricula" placeholder="Matrícula" required class="border p-2 rounded">
            <input type="text" id="departamento" placeholder="Departamento" required class="border p-2 rounded">
            <input type="text" id="semestre" placeholder="Semestre" required class="border p-2 rounded">
            <input type="text" id="alerta" placeholder="Alerta" required class="border p-2 rounded">
            <input type="text" id="estatus" placeholder="Estatus" required class="border p-2 rounded">
        </div>
        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition">
            Guardar Alerta
        </button>
    </form>

    <!-- Tabla de alertas -->
    <div class="overflow-x-auto">
        <table class="min-w-full bg-white border border-gray-300 rounded-xl">
            <thead class="bg-gray-800 text-white">
                <tr>
                    <th class="px-4 py-2 text-left">Matrícula</th>
                    <th class="px-4 py-2 text-left">Departamento</th>
                    <th class="px-4 py-2 text-left">Semestre</th>
                    <th class="px-4 py-2 text-left">Alerta</th>
                    <th class="px-4 py-2 text-left">Estatus</th>
                    <th class="px-4 py-2 text-center">Acciones</th>
                </tr>
            </thead>
            <tbody id="tablaAlertas" class="text-gray-700">
                <!-- Aquí se insertarán dinámicamente los datos -->
            </tbody>
        </table>
    </div>
</div>

<script>
    let alertas = [];
    let editando = false;
    let editIndex = null;

    const tabla = document.getElementById('tablaAlertas');
    const form = document.getElementById('formAlerta');
    const btnAgregar = document.getElementById('btnAgregar');

    // Mostrar/ocultar formulario
    btnAgregar.addEventListener('click', () => {
        form.classList.toggle('hidden');
        form.reset();
        editando = false;
    });

    // Función para renderizar alertas
    function renderizarTabla() {
        tabla.innerHTML = '';
        if (alertas.length === 0) {
            tabla.innerHTML = `<tr><td colspan="6" class="text-center p-4">No hay alertas registradas.</td></tr>`;
            return;
        }

        alertas.forEach((a, i) => {
            const fila = `
                <tr class="border-t">
                    <td class="px-4 py-2">${a.matricula}</td>
                    <td class="px-4 py-2">${a.departamento}</td>
                    <td class="px-4 py-2">${a.semestre}</td>
                    <td class="px-4 py-2">${a.alerta}</td>
                    <td class="px-4 py-2">${a.estatus}</td>
                    <td class="px-4 py-2 text-center">
                        <button onclick="editarAlerta(${i})" class="text-blue-600 hover:underline mr-2">Editar</button>
                        <button onclick="eliminarAlerta(${i})" class="text-red-600 hover:underline">Eliminar</button>
                    </td>
                </tr>`;
            tabla.insertAdjacentHTML('beforeend', fila);
        });
    }

    // Guardar alerta
    form.addEventListener('submit', e => {
        e.preventDefault();
        const nuevaAlerta = {
            matricula: document.getElementById('matricula').value,
            departamento: document.getElementById('departamento').value,
            semestre: document.getElementById('semestre').value,
            alerta: document.getElementById('alerta').value,
            estatus: document.getElementById('estatus').value
        };

        if (editando) {
            alertas[editIndex] = nuevaAlerta;
            editando = false;
        } else {
            alertas.push(nuevaAlerta);
        }

        form.reset();
        form.classList.add('hidden');
        renderizarTabla();
    });

    // Eliminar alerta
    function eliminarAlerta(index) {
        if (confirm('¿Estás seguro de que deseas eliminar esta alerta?')) {
            alertas.splice(index, 1);
            renderizarTabla();
        }
    }

    // Editar alerta
    function editarAlerta(index) {
        const alerta = alertas[index];
        document.getElementById('matricula').value = alerta.matricula;
        document.getElementById('departamento').value = alerta.departamento;
        document.getElementById('semestre').value = alerta.semestre;
        document.getElementById('alerta').value = alerta.alerta;
        document.getElementById('estatus').value = alerta.estatus;

        form.classList.remove('hidden');
        editando = true;
        editIndex = index;
    }

    // Cargar datos iniciales (opcional si los quieres precargar)
    document.addEventListener('DOMContentLoaded', () => {
        renderizarTabla();
    });
</script>

</body>
</html>
