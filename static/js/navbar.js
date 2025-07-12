window.addEventListener('DOMContentLoaded', () => {
  const navbar = document.getElementById('navbar');
  const footer = document.getElementById('footer');

  // Detectar el path actual
  const path = window.location.pathname;

  // Calcular base path según en qué carpeta estés
  let basePath = "";

  if (path.includes("/auth/")) {
    basePath = "../../../../";
  } else if (path.includes("/public/")) {
    basePath = "../../../";
  } else if (path.includes("/pages/")) {
    basePath = "../../";
  } else {
    basePath = "./";
  }

  // Cargar el navbar
  if (navbar) {
    fetch(`${basePath}components/navbar.html`)
      .then(res => res.text())
      .then(html => navbar.innerHTML = html)
      .catch(err => console.error("🛑 Error cargando navbar:", err));
  }

  // Cargar el footer si existe
  if (footer) {
    fetch(`${basePath}components/footer.html`)
      .then(res => res.text())
      .then(html => footer.innerHTML = html)
      .catch(err => console.error("🛑 Error cargando footer:", err));
  }
});
