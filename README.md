## 🎭 ID Cultural - Prueba Webhook 16:04

Proyecto desarrollado para la Subsecretaría de Cultura de Santiago del Estero como parte de las Prácticas Profesionalizantes del ITSE.

---

## 📚 Descripción

**ID Cultural** es una plataforma web tipo "Wikipedia local", destinada a registrar, validar y consultar información sobre artistas de Santiago del Estero. El sistema permite cargar obras, gestionar solicitudes de validación y navegar una biblioteca digital de contenido artístico.

---

## 🗂️ Estructura del Proyecto
```
ID_Cultural/
│
├── src/
│ ├── controllers/ # Lógica del sistema y gestión de rutas
│ ├── models/ # Representación de datos
│ └── views/ # Interfaz HTML
│ ├── components/ # Navbar, footer, etc.
│ └── pages/
│ ├── public/ # Inicio, búsqueda, eventos
│ ├── auth/ # Login, registro
│ ├── user/ # Panel de artistas
│ └── admin/ # Administración del sistema
│
├── static/
│ ├── css/
│ │ ├── main.css # Estilos generales
│ │ ├── login.css # Estilos por página
│ │ ├── admin.css
│ │ └── wiki.css
│ ├── js/
│ │ ├── login.js
│ │ └── admin.js
│ └── img/
│ └── logo.png
│
├── database/
│ ├── esquema.sql
│ └── datos-ejemplo.sql
│
├── config/
│ ├── db.php # Conexión a base de datos
│ └── rutas.php
│
├── tests/
│ ├── test-usuarios.js
│ └── test-artistas.js
│
└── docs/
├── manual-usuario.pdf
└── informe-tecnico.docx
```

---

## ⚙️ Tecnologías Utilizadas

- HTML5
- CSS3
- JavaScript
- PHP
- MySQL/MariaDB

---

## ✅ Funcionalidades Clave

- Registro y autenticación de artistas
- Validación manual por parte de administradores
- Carga de obras, eventos, biografías y documentos
- Buscador avanzado con filtros por género, localidad, tipo y año
- Biblioteca digital con materiales de artistas
- Panel de usuario (artista)
- Panel administrativo para validaciones y gestión general

---

## 👥 Equipo de Desarrollo

**Runatech** – Estudiantes del ITSE Santiago del Estero

- Maximiliano Fabián Padilla
- Marcos Ariel Romano
- Mario Sebastián Ruiz
- Sandra Soledad Sánchez

Colaboración: Subsecretaría de Cultura de Santiago del Estero

---

## 📄 Licencia

Este proyecto fue realizado con fines educativos. Derechos reservados al equipo **Runatech** y a la **Subsecretaría de Cultura**.
