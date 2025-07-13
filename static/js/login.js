// Lógica del formulario de login
document.addEventListener("DOMContentLoaded", () => {
  const form = document.getElementById("loginForm");
  const errorMsg = document.getElementById("mensaje-error");

  if (loginForm) {
    form.addEventListener("submit", function (e) {
      e.preventDefault(); // Evita que recargue la página

      const usuario = document.getElementById("usuario").value.trim().toLowerCase();
      const clave = document.getElementById("clave").value.trim();

      // Validación de usuarios
      if (usuario === "admin" && clave === "1234") {
        localStorage.setItem("usuarioActivo", "admin");
        window.location.href = "/ID-Cultural/src/views/pages/user/dashboard-adm.html";

      } else if (usuario === "artista" && clave === "1234") {
        localStorage.setItem("usuarioActivo", "artista");
        window.location.href = "/ID-Cultural/src/views/pages/user/dashboard-user.html";

      } else if (usuario === "editor" && clave === "1234") {
        localStorage.setItem("usuarioActivo", "editor");
        window.location.href = "/ID-Cultural/src/views/pages/user/dashboard-editor.html";

      } else {
        errorMsg.style.display = "block";
      }
    });
  }

  // Cargar dinámicamente el navbar
  fetch("/componentes/navbar.html")
    .then((response) => response.text())
    .then((data) => {
      document.getElementById("navbar").innerHTML = data;
    })
    .catch((err) => {
      console.error("Error al cargar el navbar:", err);
    });

  // Cargar dinámicamente el footer
  fetch("/componentes/footer.html")
    .then((response) => response.text())
    .then((data) => {
      document.getElementById("footer").innerHTML = data;
    })
    .catch((err) => {
      console.error("Error al cargar el footer:", err);
    });
});
