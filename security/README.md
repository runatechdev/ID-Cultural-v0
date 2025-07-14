# Paquete Integrado de Seguridad y Auditoría para PHP (SQLite)

Este módulo completo incluye:
- Registro de eventos clave de seguridad
- Panel de visualización para administrador
- Protección contra XSS, CSRF, inyección SQL y más

## Estructura del módulo


- `auditoria.php`: función para registrar eventos, conexión a SQLite
,- `funciones.php`: sanitización, hashing de contraseñas
- `csrf.php`: generación y validación de tokens CSRF
- `panel_auditoria.php`: visor de auditoría
- `db/db.sqlite`: base de datos lista
- `sql/crear_tabla_auditoria.sql`: script para crearla

## Ejemplo de uso

```php
require_once('security/auditoria.php');
require_once('security/funciones.php');
require_once('security/csrf.php');

if (!verificar_token_csrf($_POST['token'])) {
    die("Token inválido");
}

$email = limpiar_entrada($_POST['email']);
registrarAuditoria(1, 'Login', 'Login exitoso', 'Acceso autorizado');
```
