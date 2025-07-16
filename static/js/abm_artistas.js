document.addEventListener('DOMContentLoaded', () => {

    // --- ELEMENTOS DEL DOM ---
    const form = document.getElementById('form-artista');
    const tablaBody = document.getElementById('tabla-artistas');
    const estadoSelect = document.getElementById('estado');
    const datosFallecidoDiv = document.getElementById('datosFallecido');

    // La variable 'initialArtists' viene del script PHP incrustado en el HTML
    let listaDeArtistas = initialArtists; 

    // --- FUNCIONES ---

    /**
     * Dibuja la tabla en el HTML a partir de un array de artistas.
     * @param {Array} artistas - El array de artistas a mostrar.
     */
    const renderizarTabla = (artistas) => {
        tablaBody.innerHTML = ''; // Limpiar tabla
        if (artistas.length === 0) {
            tablaBody.innerHTML = '<tr><td colspan="6">No hay artistas para mostrar.</td></tr>';
            return;
        }
        artistas.forEach(artista => {
            const fila = document.createElement('tr');
            fila.dataset.id = artista.id; // Guardamos el ID en el elemento
            fila.innerHTML = `
                <td>${escapeHtml(artista.nombreCompleto)}</td>
                <td>${escapeHtml(artista.nombreArtistico)}</td>
                <td>${escapeHtml(artista.disciplina)}</td>
                <td><span class="estado-badge estado-${artista.estado === 'vivo' ? 'aprobado' : 'neutro'}">${escapeHtml(artista.estado)}</span></td>
                <td>${escapeHtml(artista.estado === 'vivo' ? artista.correo : artista.informante)}</td>
                <td class="acciones">
                    <button class="btn-editar" data-id="${artista.id}">Editar</button>
                    <button class="btn-eliminar" data-id="${artista.id}">Eliminar</button>
                </td>
            `;
            tablaBody.appendChild(fila);
        });
    };

    /**
     * Maneja el envío del formulario (para crear o actualizar artistas).
     */
    const manejarSubmit = async (e) => {
        e.preventDefault();
        // Aquí iría la lógica para enviar los datos con fetch a un script PHP
        // Por ejemplo: /backend/controllers/crear_artista.php
        alert('Funcionalidad de "Registrar Artista" conectada. Falta el backend.');
        // const formData = new FormData(form);
        // const response = await fetch('URL_DEL_BACKEND', { method: 'POST', body: formData });
        // const resultado = await response.json();
        // if (resultado.status === 'ok') { ... }
    };

    /**
     * Maneja los clics en los botones de la tabla (usando delegación de eventos).
     */
    const manejarAcciones = async (e) => {
        if (e.target.classList.contains('btn-eliminar')) {
            const id = e.target.dataset.id;
            if (!confirm(`¿Estás seguro de que quieres eliminar al artista con ID ${id}?`)) return;

            // Lógica para llamar al backend para eliminar
            alert(`Eliminando artista con ID: ${id}. Falta el backend.`);
            // const formData = new FormData();
            // formData.append('id', id);
            // const response = await fetch('URL_ELIMINAR_BACKEND', { method: 'POST', body: formData });
            // const resultado = await response.json();
            // if (resultado.status === 'ok') { ... }
        }

        if (e.target.classList.contains('btn-editar')) {
            const id = e.target.dataset.id;
            alert(`Cargando datos del artista con ID: ${id} en el formulario. Falta el backend.`);
            // Lógica para cargar los datos del artista en el formulario para editarlo.
        }
    };

    /**
     * Muestra u oculta los campos para artistas fallecidos.
     */
    const toggleCamposFallecido = () => {
        if (estadoSelect.value === 'fallecido') {
            datosFallecidoDiv.style.display = 'grid'; // Usamos grid para que se alinee con el resto
            datosFallecidoDiv.classList.add('animate__animated', 'animate__fadeIn');
        } else {
            datosFallecidoDiv.style.display = 'none';
        }
    };
    
    // Función de seguridad para evitar inyección de HTML
    const escapeHtml = (text) => {
        if (!text) return '';
        const div = document.createElement('div');
        div.textContent = text;
        return div.innerHTML;
    };


    // --- ASIGNACIÓN DE EVENTOS ---
    form.addEventListener('submit', manejarSubmit);
    tablaBody.addEventListener('click', manejarAcciones);
    estadoSelect.addEventListener('change', toggleCamposFallecido);


    // --- INICIALIZACIÓN ---
    renderizarTabla(listaDeArtistas); // Dibuja la tabla inicial con los datos de PHP
});