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

        <div class="mb-4">
            <a href="formulario.html" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700 transition">Agregar Alerta</a>
        </div>

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
        async function cargarAlertas() {
            try {
                const response = await fetch('obtener_alertas.php');
                const data = await response.json();

                const tabla = document.getElementById('tablaAlertas');
                tabla.innerHTML = ''; // Limpiar contenido actual

                if (data.length === 0) {
                    tabla.innerHTML = `<tr><td colspan="6" class="text-center p-4">No hay alertas registradas.</td></tr>`;
                    return;
                }

                data.forEach(alerta => {
                    const fila = `
                        <tr class="border-t">
                            <td class="px-4 py-2">${alerta.matricula}</td>
                            <td class="px-4 py-2">${alerta.departamento}</td>
                            <td class="px-4 py-2">${alerta.semestre}</td>
                            <td class="px-4 py-2">${alerta.alerta}</td>
                            <td class="px-4 py-2">${alerta.estatus}</td>
                            <td class="px-4 py-2 text-center">
                                <a href="editar.html?id=${alerta.id}" class="text-blue-600 hover:underline mr-2">Editar</a>
                                <button onclick="eliminarAlerta(${alerta.id})" class="text-red-600 hover:underline">Eliminar</button>
                            </td>
                        </tr>`;
                    tabla.insertAdjacentHTML('beforeend', fila);
                });

            } catch (error) {
                console.error('Error al cargar las alertas:', error);
            }
        }

        async function eliminarAlerta(id) {
            if (!confirm('¿Estás seguro de que deseas eliminar esta alerta?')) return;

            try {
                const response = await fetch(`eliminar_alerta.php?id=${id}`, {
                    method: 'DELETE'
                });

                if (response.ok) {
                    alert('Alerta eliminada con éxito.');
                    cargarAlertas(); // Recargar tabla
                } else {
                    alert('Hubo un error al eliminar la alerta.');
                }
            } catch (error) {
                console.error('Error al eliminar la alerta:', error);
            }
        }

        // Cargar alertas al cargar la página
        document.addEventListener('DOMContentLoaded', cargarAlertas);
    </script>

</body>
</html>
