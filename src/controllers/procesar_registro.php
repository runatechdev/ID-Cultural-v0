<?php
// 🛡️ Encabezados HTTP seguros
require_once __DIR__ . '/../security/headers.php';

// 🔐 Funciones de sanitización, validación y CSRF
require_once __DIR__ . '/../security/funciones.php';
require_once __DIR__ . '/../security/csrf.php';

// 📦 Base de datos y modelo de usuario
require_once __DIR__ . '/../database/db.php';
require_once __DIR__ . '/../models/Usuario.php';

// 📝 Auditoría para registrar eventos de seguridad
require_once __DIR__ . '/../security/auditoria.php';

// 🟡 Inicio del proceso (depuración)
echo "🟡 Iniciando registro...<br>";

// 🧠 Crear instancia del modelo
$usuario = new Usuario($db);

// ✅ Verificar si el método es POST
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    echo "📩 Datos recibidos por POST.<br>";

    // 🛡️ Verificar token CSRF
    if (!verificar_token_csrf($_POST['token'] ?? '')) {
        echo "❌ Token CSRF inválido.<br>";
        exit;
    }

    // 🧼 Sanitizar entradas
    $nombre            = limpiar_entrada($_POST["nombre"] ?? '');
    $apellido          = limpiar_entrada($_POST["apellido"] ?? '');
    $fechaNacimiento   = limpiar_entrada($_POST["fechaNacimiento"] ?? '');
    $genero            = limpiar_entrada($_POST["genero"] ?? '');
    $pais              = limpiar_entrada($_POST["pais"] ?? '');
    $provincia         = limpiar_entrada($_POST["provincia"] ?? '');
    $municipio         = limpiar_entrada($_POST["municipio"] ?? '');
    $email             = limpiar_entrada($_POST["email"] ?? '');
    $confirmarEmail    = limpiar_entrada($_POST["confirmarEmail"] ?? '');
    $password          = $_POST["password"] ?? '';
    $confirmarPassword = $_POST["confirmarPassword"] ?? '';

    // 🔎 Validación de email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "❌ Email inválido.<br>";
        exit;
    }

    // ⚠️ Comparación de email y contraseña
    if ($email !== $confirmarEmail || $password !== $confirmarPassword) {
        echo "❌ El correo o la contraseña no coinciden.<br>";
        exit;
    }

    // 🔐 Validación de longitud de contraseña
    if (strlen($password) < 8) {
        echo "❌ La contraseña debe tener al menos 8 caracteres.<br>";
        exit;
    }

    // 📧 Verificar existencia del email
    if ($usuario->emailExiste($email)) {
        echo "⚠️ El correo ya está registrado.<br>";
        exit;
    }

    // 🧠 Hasheo seguro de la contraseña
    $passwordHash = password_hash($password, PASSWORD_DEFAULT);

    // 🧩 Preparar datos sanitizados
    $datos = [
        'nombre'           => $nombre,
        'apellido'         => $apellido,
        'fecha_nacimiento' => $fechaNacimiento,
        'genero'           => $genero,
        'pais'             => $pais,
        'provincia'        => $provincia,
        'municipio'        => $municipio,
        'email'            => $email,
        'password'         => $passwordHash
    ];

    echo "🧩 Datos preparados. Intentando registrar usuario...<br>";

    // 🚀 Intentar registrar usuario
    if ($usuario->registrar($datos)) {
        echo "✅ Registro exitoso<br>";

        // 📝 Registrar auditoría
        $conn_auditoria = conectarAuditoria();
        registrarAuditoria(
            $conn_auditoria,
            null,
            'Registro',
            'Registro Exitoso',
            'Todos los pasos completados para el email: ' . $email
        );

        echo "📝 Auditoría registrada.<br>";
    } else {
        echo "❌ Hubo un error al registrar el usuario.<br>";
    }

} else {
    echo "🚫 No se recibió POST.<br>";
}
?>
