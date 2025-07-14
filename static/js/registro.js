// =======================
// CONFIGURACIÓN INICIAL
// =======================
document.addEventListener("DOMContentLoaded", function () {
    mostrarPaso1();
    inicializarUbicacion();
    inicializarFechaNacimiento();
    inicializarValidacionIntereses();
    inicializarEventosFormularios();
    inicializarNavegacionPasos();
});

// =======================
// UBICACIÓN DINÁMICA
// =======================
function inicializarUbicacion() {
    const provinciasPorPais = {
        Argentina: {
            "Buenos Aires": ["La Plata", "Mar del Plata", "Bahía Blanca"],
            "Córdoba": ["Córdoba Capital", "Villa Carlos Paz", "Río Cuarto"],
            "Santiago del Estero": ["Santiago Capital", "La Banda", "Termas de Río Hondo"]
        }
    };

    const paisSelect = document.getElementById("pais");
    const provinciaSelect = document.getElementById("provincia");
    const municipioSelect = document.getElementById("municipio");

    paisSelect.addEventListener("change", function () {
        const pais = this.value;
        provinciaSelect.innerHTML = '<option value="" disabled selected>Seleccioná una provincia</option>';
        municipioSelect.innerHTML = '<option value="" disabled selected>Seleccioná un municipio</option>';
        municipioSelect.disabled = true;

        if (provinciasPorPais[pais]) {
            provinciaSelect.disabled = false;
            Object.keys(provinciasPorPais[pais]).forEach(function (provincia) {
                const option = document.createElement("option");
                option.value = provincia;
                option.textContent = provincia;
                provinciaSelect.appendChild(option);
            });
        } else {
            provinciaSelect.disabled = true;
        }
    });

    provinciaSelect.addEventListener("change", function () {
        const pais = paisSelect.value;
        const provincia = this.value;

        municipioSelect.innerHTML = '<option value="" disabled selected>Seleccioná un municipio</option>';

        if (provinciasPorPais[pais] && provinciasPorPais[pais][provincia]) {
            municipioSelect.disabled = false;
            provinciasPorPais[pais][provincia].forEach(function (municipio) {
                const option = document.createElement("option");
                option.value = municipio;
                option.textContent = municipio;
                municipioSelect.appendChild(option);
            });
        } else {
            municipioSelect.disabled = true;
        }
    });
}

// =======================
// VALIDACIÓN DE FECHA
// =======================
function inicializarFechaNacimiento() {
    const fechaInput = document.getElementById("fechaNacimiento");
    const hoy = new Date().toISOString().split("T")[0];
    const min = "1970-01-01";
    fechaInput.setAttribute("min", min);
    fechaInput.setAttribute("max", hoy);
}

// =======================
// VALIDACIÓN DE INTERESES
// =======================
function inicializarValidacionIntereses() {
    const checkboxes = document.querySelectorAll('input[name="intereses"]');
    const btnSiguienteIntereses = document.getElementById("btn-siguiente"); // 👈 corregido ID

    if (checkboxes.length && btnSiguienteIntereses) {
        checkboxes.forEach((checkbox) => {
            checkbox.addEventListener("change", () => {
                const algunoMarcado = Array.from(checkboxes).some((c) => c.checked);
                btnSiguienteIntereses.disabled = !algunoMarcado;
            });
        });
    }
}

// =======================
// EVENTOS DE FORMULARIOS
// =======================
function inicializarEventosFormularios() {
    const registroForm = document.getElementById("registroForm");
    const interesesForm = document.getElementById("interesesForm");

    if (registroForm) {
        registroForm.addEventListener("submit", async (e) => {
            e.preventDefault();

            if (!registroForm.checkValidity()) {
                registroForm.reportValidity();
                return;
            }

            const email = document.getElementById("email").value.trim();
            const confirmarEmail = document.getElementById("confirmarEmail").value.trim();
            const password = document.getElementById("password").value;
            const confirmarPassword = document.getElementById("confirmarPassword").value;

            if (email !== confirmarEmail) {
                alert("Los correos electrónicos no coinciden.");
                return;
            }

            if (password !== confirmarPassword) {
                alert("Las contraseñas no coinciden.");
                return;
            }

            const formData = new FormData(registroForm);

            try {
    const res = await fetch("/ID-Cultural/src/controllers/procesar_registro.php", {
        method: "POST",
        body: formData
    });

    const resultado = await res.text();

    if (resultado.includes("✅")) {
        mostrarPaso2();
    } else {
        alert("Error al registrar tu cuenta. Verificá los datos ingresados.");
    }
} catch (error) {
    alert("No se pudo enviar el formulario de registro.");
}

        });
    }

    if (interesesForm) {
        interesesForm.addEventListener("submit", async (e) => {
            e.preventDefault();

            const formData = new FormData(interesesForm);

            try {
                const res = await fetch("/ID-Cultural/controllers/guardar_intereses.php", {
                    method: "POST",
                    body: formData
                });

                const resultado = await res.text();

                if (resultado.includes("✅")) {
                    window.location.href = "registro-completado.html";
                } else {
                    alert("Error al guardar intereses:\n" + resultado);
                }
            } catch (error) {
                console.error("Error al guardar intereses:", error);
                alert("No se pudieron guardar los intereses.");
            }
        });
    }
}

// =======================
// NAVEGACIÓN DE PASOS
// =======================
function inicializarNavegacionPasos() {
    const btnAnterior = document.getElementById("btn-anterior");

    if (btnAnterior) {
        btnAnterior.addEventListener("click", mostrarPaso1);
    }
}

// =======================
// MOSTRAR PASO 2
// =======================
function mostrarPaso2() {
    const paso1 = document.getElementById("paso1");
    const paso2 = document.getElementById("paso2");
    const pasos = document.querySelectorAll(".wizard-pasos .paso");

    paso1.classList.remove("active");
    paso2.classList.add("active");

    pasos[0].classList.remove("activo");
    pasos[1].classList.add("activo");

    const emailVisible = document.getElementById("email");
    const emailOculto = document.getElementById("email_oculto");

    if (emailVisible && emailOculto) {
        emailOculto.value = emailVisible.value.trim();
    }
}

// =======================
// MOSTRAR PASO 1
// =======================
function mostrarPaso1() {
    const paso1 = document.getElementById("paso1");
    const paso2 = document.getElementById("paso2");
    const pasos = document.querySelectorAll(".wizard-pasos .paso");

    paso2.classList.remove("active");
    paso1.classList.add("active");

    pasos[1].classList.remove("activo");
    pasos[0].classList.add("activo");
}
