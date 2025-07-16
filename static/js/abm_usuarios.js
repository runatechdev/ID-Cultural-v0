document.addEventListener('DOMContentLoaded', () => {
  // --- VARIABLES Y ELEMENTOS DEL DOM ---
  const form = document.getElementById('form-usuario');
  const tablaBody = document.getElementById('tabla-usuarios-body');
  const buscador = document.getElementById('buscador');
  // El 'initialUsers' viene del script PHP que incrustamos en el HTML
  let todosLosUsuarios = initialUsers;

  // --- FUNCIONES ---

  /**
   * Dibuja la tabla en el HTML a partir de un array de usuarios.
   * @param {Array} usuariosParaRenderizar El array de objetos de usuario a mostrar.
   */
  function renderizarTabla(usuariosParaRenderizar) {
      tablaBody.innerHTML = ''; // Limpiamos la tabla antes de redibujar

      if (usuariosParaRenderizar.length === 0) {
          tablaBody.innerHTML = '<tr><td colspan="4">No se encontraron usuarios.</td></tr>';
          return;
      }

      usuariosParaRenderizar.forEach(usuario => {
          const fila = document.createElement('tr');
          // Usamos data-id para poder identificar qué usuario borrar/editar
          fila.setAttribute('data-id', usuario.id); 
          fila.innerHTML = `
              <td>${escapeHtml(usuario.nombre)}</td>
              <td>${escapeHtml(usuario.email)}</td>
              <td>${escapeHtml(usuario.role)}</td>
              <td>
                  <button class="btn-editar" data-id="${usuario.id}">Editar</button>
                  <button class="btn-eliminar" data-id="${usuario.id}">Eliminar</button>
              </td>
          `;
          tablaBody.appendChild(fila);
      });
  }

  /**
   * Filtra y busca en la lista de usuarios y luego renderiza la tabla.
   */
  function filtrarYRenderizar() {
      const busqueda = buscador.value.toLowerCase().trim();
      const usuariosFiltrados = todosLosUsuarios.filter(u => {
          return u.nombre.toLowerCase().includes(busqueda) || u.email.toLowerCase().includes(busqueda);
      });
      renderizarTabla(usuariosFiltrados);
  }

  /**
   * Maneja el envío del formulario para crear un nuevo usuario.
   */
  async function agregarUsuario(e) {
      e.preventDefault();
      
      const formData = new FormData(form);
      
      try {
          const response = await fetch('/ID-Cultural/backend/controllers/crear_usuario.php', {
              method: 'POST',
              body: formData
          });

          const resultado = await response.json();

          if (resultado.status === 'ok') {
              // Si el backend confirma, agregamos el nuevo usuario a nuestra lista local
              todosLosUsuarios.push(resultado.nuevoUsuario);
              filtrarYRenderizar(); // Redibujamos la tabla
              form.reset();
              alert('¡Usuario creado con éxito!');
          } else {
              alert(`Error: ${resultado.message}`);
          }
      } catch (error) {
          console.error('Error al agregar usuario:', error);
          alert('Error de conexión al crear el usuario.');
      }
  }

  /**
   * Maneja el clic en los botones de la tabla (Editar/Eliminar).
   */
  async function manejarAccionesTabla(e) {
      if (e.target.classList.contains('btn-eliminar')) {
          const userId = e.target.dataset.id;
          
          if (!confirm(`¿Estás seguro de que quieres eliminar al usuario con ID ${userId}?`)) {
              return;
          }

          try {
              const formData = new FormData();
              formData.append('id', userId);

              const response = await fetch('/ID-Cultural/backend/controllers/eliminar_usuario.php', {
                  method: 'POST',
                  body: formData
              });

              const resultado = await response.json();

              if (resultado.status === 'ok') {
                  // Si el backend confirma, lo quitamos de nuestra lista local y redibujamos
                  todosLosUsuarios = todosLosUsuarios.filter(u => u.id != userId);
                  filtrarYRenderizar();
                  alert('Usuario eliminado con éxito.');
              } else {
                  alert(`Error: ${resultado.message}`);
              }
          } catch (error) {
              console.error('Error al eliminar usuario:', error);
              alert('Error de conexión al eliminar el usuario.');
          }
      }

      if (e.target.classList.contains('btn-editar')) {
          alert('La funcionalidad de editar aún no está implementada.');
      }
  }

  // Función de seguridad para evitar ataques XSS
  function escapeHtml(text) {
      const div = document.createElement('div');
      div.textContent = text;
      return div.innerHTML;
  }


  // --- EVENT LISTENERS ---
  form.addEventListener('submit', agregarUsuario);
  buscador.addEventListener('input', filtrarYRenderizar);
  tablaBody.addEventListener('click', manejarAccionesTabla);

  // --- INICIALIZACIÓN ---
  renderizarTabla(todosLosUsuarios); // Renderiza la tabla inicial con los datos de PHP
});