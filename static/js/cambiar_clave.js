document.getElementById('cambiarClaveForm').addEventListener('submit', async function(e) {
    e.preventDefault();

    const clave_actual = document.getElementById('clave_actual').value;
    const nueva_clave = document.getElementById('nueva_clave').value;
    const confirmar_clave = document.getElementById('confirmar_clave').value;
    const mensajeDiv = document.getElementById('mensaje');

    mensajeDiv.hidden = true;

    // Validación en el cliente antes de enviar
    if (nueva_clave !== confirmar_clave) {
        mensajeDiv.textContent = '❌ Las nuevas contraseñas no coinciden.';
        mensajeDiv.className = 'mensaje error';
        mensajeDiv.hidden = false;
        return;
    }

    if (nueva_clave.length < 6) { // Ejemplo de otra validación
        mensajeDiv.textContent = '❌ La nueva contraseña debe tener al menos 6 caracteres.';
        mensajeDiv.className = 'mensaje error';
        mensajeDiv.hidden = false;
        return;
    }

    const formData = new FormData();
    formData.append('clave_actual', clave_actual);
    formData.append('nueva_clave', nueva_clave);

    try {
        const response = await fetch('/ID-Cultural/backend/controllers/cambiar_clave.php', {
            method: 'POST',
            body: formData
        });

        const resultado = await response.json();

        if (resultado.status === 'ok') {
            mensajeDiv.textContent = `✅ ${resultado.message}`;
            mensajeDiv.className = 'mensaje exito';
            document.getElementById('cambiarClaveForm').reset();
        } else {
            mensajeDiv.textContent = `❌ ${resultado.message}`;
            mensajeDiv.className = 'mensaje error';
        }
        mensajeDiv.hidden = false;

    } catch (error) {
        console.error('Error de fetch:', error);
        mensajeDiv.textContent = '❌ Error de conexión con el servidor.';
        mensajeDiv.className = 'mensaje error';
        mensajeDiv.hidden = false;
    }
});