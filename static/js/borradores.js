document.addEventListener('DOMContentLoaded', () => {
    const form = document.getElementById('form-borrador');
    const guardarBtn = document.getElementById('btn-guardar');
    const enviarBtn = document.getElementById('btn-enviar');
    const messageDiv = document.getElementById('form-message');

    if (!form) return;

    // Función para mostrar mensajes al usuario sin usar alert()
    const showMessage = (message, isError = false) => {
        messageDiv.textContent = message;
        messageDiv.className = isError ? 'form-message error' : 'form-message success';
        messageDiv.hidden = false;
        setTimeout(() => { messageDiv.hidden = true; }, 4000);
    };

    // Evento para el botón "Guardar Borrador"
    guardarBtn.addEventListener('click', async (e) => {
        e.preventDefault(); // Evita que el formulario se envíe de la forma tradicional
        
        const formData = new FormData(form);
        
        try {
            const response = await fetch('/ID-Cultural/backend/controllers/guardar_borrador.php', {
                method: 'POST',
                body: formData
            });

            const result = await response.json();

            if (result.status === 'ok') {
                showMessage('✅ Borrador guardado correctamente.');
            } else {
                showMessage(`Error: ${result.message}`, true);
            }
        } catch (error) {
            console.error('Error al guardar:', error);
            showMessage('Error de conexión al guardar el borrador.', true);
        }
    });

    // Evento para el botón "Enviar a Validación"
    enviarBtn.addEventListener('click', async () => {
        // Aquí puedes agregar una confirmación si quieres
        if (!confirm('¿Estás seguro de que quieres enviar este perfil a validación? No podrás editarlo después.')) {
            return;
        }

        const formData = new FormData(form);

        try {
            const response = await fetch('/ID-Cultural/backend/controllers/enviar_validacion.php', {
                method: 'POST',
                body: formData
            });

            const result = await response.json();

            if (result.status === 'ok') {
                showMessage('✅ Perfil enviado a validación. Serás redirigido...');
                // Redirigir a la página de "enviados" después de unos segundos
                setTimeout(() => {
                    window.location.href = '/ID-Cultural/src/views/pages/editor/enviados.php';
                }, 2000);
            } else {
                showMessage(`Error: ${result.message}`, true);
            }
        } catch (error) {
            console.error('Error al enviar:', error);
            showMessage('Error de conexión al enviar a validación.', true);
        }
    });

    // Aquí iría el resto de tu lógica JS (campos condicionales, añadir enlaces, etc.)
    // ...
});