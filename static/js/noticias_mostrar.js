document.addEventListener("DOMContentLoaded", () => {
  const contenedor = document.getElementById("contenedor-noticias");

  // ✅ Ruta corregida: acceder al backend real
  
  fetch("/ID-Cultural/src/views/pages/editor/listar_noticias.php")
    .then((res) => res.json())
    .then((noticias) => {
      contenedor.innerHTML = "";

      if (Array.isArray(noticias) && noticias.length > 0) {
        noticias.forEach((noticia) => {
          const card = document.createElement("div");
          card.classList.add("noticia-card");

          card.innerHTML = `
            ${noticia.imagen ? `<img src="/ID-Cultural/backend/${noticia.imagen}" alt="Imagen de la noticia">` : ""}
            <h3>${noticia.titulo}</h3>
            <p>${noticia.contenido}</p>
            <small>${new Date(noticia.fecha).toLocaleDateString()}</small>
          `;

          contenedor.appendChild(card);
        });
      } else {
        contenedor.innerHTML = "<p>No hay noticias disponibles aún.</p>";
        console.warn("Respuesta sin datos:", noticias);
      }
    })
    .catch((err) => {
      contenedor.innerHTML = "<p>Error de conexión al servidor</p>";
      console.error("Error:", err);
    });
});
