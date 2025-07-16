document.addEventListener('DOMContentLoaded', () => {
  const form = document.getElementById("form-borrador");
  const categoriaSelect = document.getElementById('categoria');
  const camposExtraContainer = document.querySelectorAll('.campos-extra');
  const multimediaContainer = document.getElementById("multimedia-container");

  // 1. Mostrar campos condicionales por categoría
  categoriaSelect.addEventListener('change', function () {
    camposExtraContainer.forEach((div) => {
      div.style.display = 'none';
    });

    const categoriaSeleccionada = this.value;
    const idCampo = 'campos-' + categoriaSeleccionada;
    const divMostrar = document.getElementById(idCampo);

    if (divMostrar) {
      divMostrar.style.display = 'block';
    }
  });

  // 2. Agregar al menos un input multimedia si no hay ninguno
  if (multimediaContainer.children.length === 0) {
    const multimediaInput = document.createElement("input");
    multimediaInput.type = "text";
    multimediaInput.name = "multimedia";
    multimediaInput.placeholder = "Ej: https://youtu.be/...";
    multimediaContainer.appendChild(multimediaInput);
  }

  // 3. Envío del formulario
  form.addEventListener("submit", async function (e) {
    e.preventDefault();

    const saveIcon = form.querySelector(".fa-save");
    saveIcon.classList.add('animate__animated', 'animate__rotateIn');

    const formData = new FormData(form);

    try {
      const res = await fetch("/ID-Cultural/backend/controllers/guardar_borrador.php", {
        method: "POST",
        body: formData
      });

      const resultado = await res.json();
      console.log("📥 Respuesta del servidor:", resultado);

      if (resultado.status === "ok") {
        setTimeout(() => {
          alert("✅ Borrador guardado correctamente.");
          form.reset();
          camposExtraContainer.forEach((div) => {
            div.style.display = 'none';
          });

          // Reiniciar multimedia con un solo input
          multimediaContainer.innerHTML = '';
          const nuevoInput = document.createElement("input");
          nuevoInput.type = "text";
          nuevoInput.name = "multimedia";
          nuevoInput.placeholder = "Ej: https://youtu.be/...";
          multimediaContainer.appendChild(nuevoInput);
        }, 500);
      } else {
        alert("⚠️ Error al guardar:\n" + resultado.message);
      }

    } catch (error) {
      console.error("❌ Error de conexión:", error);
      alert("No se pudo guardar el borrador.\nVer consola para detalles.");
    }

    saveIcon.addEventListener('animationend', () => {
      saveIcon.classList.remove('animate__animated', 'animate__rotateIn');
    });
  });

  // 4. (Opcional) Lógica futura para btn-enviar-validacion
  const validarBtn = document.getElementById("btn-enviar-validacion");
  if (validarBtn) {
    validarBtn.addEventListener("click", () => {
      alert("🔒 Función 'Enviar para Validación' todavía en desarrollo.");
      // Podés agregar lógica cuando tengas un archivo enviar_validacion.php
    });
  }
});
