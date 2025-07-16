document.addEventListener("DOMContentLoaded", () => {
  const contenedor = document.getElementById("contenedor-noticias");

  fetch("/ID-Cultural-noticias/ID-Cultural-noticias/backend/api/listar_noticias.php")
    .then(res => res.json())
    .then(noticias => {
      contenedor.innerHTML = ""; // Limpiar contenido previo

      noticias.forEach(noticia => {
        const card = document.createElement("div");
        card.className = "noticia-card";

        card.innerHTML = `
          <h3>${noticia.titulo}</h3>
          <p>${noticia.contenido}</p>
          <small><strong>Fecha:</strong> ${noticia.fecha}</small>
          ${noticia.imagen ? `<img src="/ID-Cultural-noticias/ID-Cultural-noticias/backend/${noticia.imagen}" alt="${noticia.titulo}" loading="lazy" width="200">` : ""}
        `;

        contenedor.appendChild(card);
      });
    })
    .catch(error => {
      contenedor.innerHTML = "<p>No se pudieron cargar las noticias. Intentalo más tarde.</p>";
      console.error("Error al cargar noticias:", error);
    });
});
