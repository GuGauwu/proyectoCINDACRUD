// fetch_alertas.js
document.addEventListener("DOMContentLoaded", function () {
    const buscarBtn = document.getElementById("btnBuscar");
    const matriculaInput = document.getElementById("matricula");
    const nivelSelect = document.getElementById("nivel");
    const resultadoDiv = document.getElementById("resultadoAlertas");

    buscarBtn.addEventListener("click", () => {
        const matricula = matriculaInput.value.trim();
        const nivel = nivelSelect.value;

        if (!matricula || !nivel) {
            resultadoDiv.innerHTML = `<p class="text-red-600 font-medium">Por favor, completa ambos campos.</p>`;
            return;
        }

        fetch("obtener_alertas.php")
            .then(res => res.json())
            .then(data => {
                const encontrados = data.filter(alumno =>
                    alumno.Matricula.toLowerCase() === matricula.toLowerCase() &&
                    alumno.Nivel.toString() === nivel
                );

                if (encontrados.length > 0) {
                    resultadoDiv.innerHTML = encontrados.map(alumno => `
                        <div class="bg-green-100 text-green-800 px-4 py-2 my-2 rounded-lg shadow">
                            <p><strong>Matrícula:</strong> ${alumno.Matricula}</p>
                            <p><strong>Nombre:</strong> ${alumno.Nombre}</p>
                            <p><strong>Alerta:</strong> ${alumno.Alerta}</p>
                        </div>
                    `).join("");
                } else {
                    resultadoDiv.innerHTML = `<p class="text-yellow-600 font-medium">No se encontraron alertas para esa matrícula y nivel.</p>`;
                }
            })
            .catch(error => {
                console.error("Error al obtener alertas:", error);
                resultadoDiv.innerHTML = `<p class="text-red-600 font-medium">Error al consultar la API.</p>`;
            });
    });
});
