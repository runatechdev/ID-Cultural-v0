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
        window.location.href = "/ID-Cultural/src/views/pages/editor/dashboard-editor.html";

      } else {
        errorMsg.style.display = "block";
      }
    });
<<<<<<< Updated upstream
  };
=======
  }
>>>>>>> Stashed changes
});
