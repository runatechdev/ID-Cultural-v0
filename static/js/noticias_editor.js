document.addEventListener("DOMContentLoaded", () => {
  const form = document.getElementById("form-noticia");
  const mensaje = document.getElementById("mensaje-confirmacion");
  const tabla = document.getElementById("tabla-noticias").querySelector("tbody");

  function cargarNoticias() {
    fetch("/ID-Cultural-noticias/ID-Cultural-noticias/backend/api/listar_noticias.php")
     
    .then(res => res.json())
      .then(lista => {
        
        console.log("Noticias recibidas:", lista); // 👈 Ver en consola
         tabla.innerHTML = "";


        tabla.innerHTML = "";
        lista.forEach(noticia => {
          const fila = document.createElement("tr");
          fila.innerHTML = `
            <td>${noticia.titulo}</td>
            <td>${noticia.contenido}</td>
            <td>${noticia.fecha}</td>
            <td>
              ${noticia.imagen ? `<img src="/ID-Cultural-noticias/ID-Cultural-noticias/backend/${noticia.imagen}" width="100">` : "Sin imagen"}
            </td>
            <td>
              <button class="editar-btn" data-id="${noticia.id}">Editar</button>
              <button class="eliminar-btn" data-id="${noticia.id}">Eliminar</button>
            </td>
          `;
          tabla.appendChild(fila);
        });
      });
  }

  form.addEventListener("submit", function (e) {
    e.preventDefault();

    const formData = new FormData();
    formData.append("titulo", document.getElementById("titulo").value);
    formData.append("contenido", document.getElementById("contenido").value);
    formData.append("autor", "Editor");
    const imagenInput = document.getElementById("imagen");
    if (imagenInput.files.length > 0) {
      formData.append("imagen", imagenInput.files[0]);
    }
    const noticiaId = document.getElementById("noticia-id").value;
if (noticiaId) {
  formData.append("id", noticiaId); // 👈 Esto le dice al backend que debe actualizar
}

    fetch("/ID-Cultural-noticias/ID-Cultural-noticias/backend/api/guardar_noticia.php", {
      
      method: "POST",
      body: formData
    })
      .then(res => res.json())
      .then(data => {
        if (data.status === "success") {
          mensaje.hidden = false;
          form.reset();
          document.getElementById("noticia-id").value = "";
          cargarNoticias();
        } else {
          alert(data.message || "Error al guardar la noticia");
        }
      });
  });

  tabla.addEventListener("click", function (e) {
    const id = e.target.dataset.id;

    if (e.target.classList.contains("editar-btn")) {
      fetch("/ID-Cultural-noticias/ID-Cultural-noticias/backend/api/obtener_noticia.php", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({ id })
      })
        .then(res => res.json())
        .then(data => {
          if (data.status === "success" && data.noticia) {
            const noticia = data.noticia;
            document.getElementById("noticia-id").value = noticia.id;
            document.getElementById("titulo").value = noticia.titulo;
            document.getElementById("contenido").value = noticia.contenido;
            window.scrollTo(0, 0);
          }
        });
    }

    else if (e.target.classList.contains("eliminar-btn")) {
      fetch("/ID-Cultural-noticias/ID-Cultural-noticias/backend/api/eliminar_noticia.php", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({ id })
      })
        .then(res => res.json())
        .then(data => {
          if (data.status === "success") {
            cargarNoticias();
          } else {
            alert(data.message || "No se pudo eliminar la noticia");
          }
        });
    }
  });

  cargarNoticias();
});
