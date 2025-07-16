document.addEventListener('DOMContentLoaded', () => {
    // La variable 'initialData' viene del script PHP incrustado en la página
    const tablaBody = document.getElementById('tabla-artistas-body'); // Asegúrate de que tu <tbody> tenga este id

    /**
     * Maneja el cambio de estado en el dropdown de una fila.
     * @param {Event} e - El objeto del evento 'change'.
     */
    const cambiarEstado = async (e) => {
        // Usamos delegación de eventos: solo actuamos si el cambio ocurrió en un <select>
        if (e.target.tagName !== 'SELECT' || e.target.dataset.action !== 'cambiar-estado') {
            return;
        }

        const selectElement = e.target;
        const nuevoEstado = selectElement.value;
        const artistaId = selectElement.dataset.id;
        const fila = selectElement.closest('tr'); // Encontramos la fila <tr> padre

        if (!nuevoEstado) return;

        // Preparamos los datos para enviar al servidor
        const formData = new FormData();
        formData.append('id', artistaId);
        formData.append('estado', nuevoEstado);

        try {
            // Llamada al backend para actualizar la base de datos
            const response = await fetch('/ID-Cultural/backend/controllers/actualizar_estado.php', {
                method: 'POST',
                body: formData
            });

            const resultado = await response.json();

            if (resultado.status === 'ok') {
                // Si el servidor confirma, actualizamos la vista
                const estadoCell = fila.querySelector('.estado-cell');
                const fechaCell = fila.querySelector('.fecha-cell');
                
                estadoCell.innerHTML = `<span class="estado-badge estado-${nuevoEstado.toLowerCase()}">${nuevoEstado}</span>`;
                fechaCell.textContent = resultado.fechaValidacion || '-';
                
                alert('¡Estado actualizado con éxito!');
            } else {
                alert(`Error: ${resultado.message}`);
                selectElement.value = resultado.estadoAnterior || ''; // Revertir el cambio visual si falla
            }
        } catch (error) {
            console.error('Error de conexión:', error);
            alert('Error de conexión con el servidor.');
        }
    };

    // --- ASIGNACIÓN DE EVENTOS ---
    // Un solo "escuchador" en la tabla para manejar todos los cambios (delegación de eventos)
    if (tablaBody) {
        tablaBody.addEventListener('change', cambiarEstado);
    }
});