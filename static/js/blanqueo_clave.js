document.getElementById('blanqueoForm').addEventListener('submit', async function(e) {
    e.preventDefault();

    const email = document.getElementById('email').value;
    const mensajeDiv = document.getElementById('mensaje');
    const formData = new FormData();
    formData.append('email', email);

    mensajeDiv.hidden = true; // Ocultar mensaje previo

    try {
        const response = await fetch('/ID-Cultural/backend/controllers/blanquear_clave.php', {
            method: 'POST',
            body: formData
        });

        const resultado = await response.json();

        if (resultado.status === 'ok') {
            mensajeDiv.textContent = `✅ ${resultado.message}`;
            mensajeDiv.className = 'mensaje exito';
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