<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Búsqueda de Alumnos</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
        .modal {
            animation: fadeIn 0.3s ease-in-out;
        }
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        .modal-bg {
            background: rgba(0, 0, 0, 0.5);
        }
        .btn-close {
            transition: transform 0.2s ease, background-color 0.2s ease;
        }
        .btn-close:hover {
            transform: rotate(90deg);
            background-color: #ef4444;
            color: white;
        }
    </style>
</head>
<body class="bg-gray-100">

    <div class="p-6">
        <button onclick="openSearchModal()" class="px-5 py-2 text-sm font-medium text-white bg-indigo-600 rounded-lg hover:bg-indigo-700 transition duration-200">Buscar Alumno</button>
    </div>

    <div id="searchModal" class="fixed inset-0 hidden modal-bg flex justify-center items-center">
        <div class="bg-white p-8 rounded-2xl shadow-2xl w-96 modal relative">
            <button type="button" onclick="confirmCloseSearchModal()" class="absolute top-3 right-3 btn-close text-gray-600 p-1 rounded-full transition duration-200">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>

            <h2 class="text-3xl font-semibold mb-6 text-gray-800">Buscar Alumno</h2>
            <form method="POST">
                <div class="mb-5">
                    <label for="nivel" class="block text-sm font-medium text-gray-600">Nivel</label>
                    <select id="nivel" name="nivel" class="mt-2 block w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                        <option value="">Selecciona una opción</option>
                        <option value="1">Licenciatura</option>
                        <option value="2">Maestría</option>
                        <option value="3">Especialidad</option>
                        <option value="4">Doctorado</option>
                    </select>
                </div>
                <div class="mb-5">
                    <label for="matricula" class="block text-sm font-medium text-gray-600">Matrícula</label>
                    <div class="flex mt-2">
                        <input type="text" id="matricula" placeholder="Escribe la matrícula" 
                               class="flex-grow px-4 py-2 border border-gray-300 rounded-l-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                        <button type="button" class="px-4 py-2 bg-indigo-600 text-white rounded-r-lg hover:bg-indigo-700 transition duration-200">
                            Buscar
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script>
        function openSearchModal() {
            document.getElementById('searchModal').classList.remove('hidden');
        }

        function confirmCloseSearchModal() {
            if (confirm("¿Estás seguro de que deseas cerrar? Los datos introducidos se perderán.")) {
                closeSearchModal();
            }
        }

        function closeSearchModal() {
            document.getElementById('searchModal').classList.add('hidden');
        }
    </script>
</body>
</html>