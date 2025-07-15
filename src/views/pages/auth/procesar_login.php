<?php
//require_once(__DIR__ . '/../security/headers.php');

require_once(__DIR__ . '/../../../../security/headers.php');
require_once(__DIR__ . '/../../../../security/auditoria.php');
require_once(__DIR__ . '/../../../../security/funciones.php');
require_once(__DIR__ . '/../../../../security/csrf.php');

require_once(__DIR__ . '/validaciones.php');
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$conn = require_once(__DIR__ . '/../config/conexion.php');
$conn_auditoria = conectarAuditoria();

$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!verificar_token_csrf($_POST['token'] ?? '')) {
        die("Token CSRF inválido");
    }

    $email = limpiarEntrada($_POST['email'] ?? '');
    $password = $_POST['password'] ?? ''; // Solo se limpia cuando se muestra

    if (!validarEmail($email)) {
        die("Email inválido");
    }

    escanear_inyecciones($conn_auditoria);

    $stmt = $conn->prepare('SELECT id, email, password FROM usuarios WHERE email = :email');
    $stmt->bindParam(':email', $email);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        registrarAuditoria($conn_auditoria, $user['id'], 'Login', 'Login exitoso', 'Usuario inició sesión');
        header("Location: ../../panel.php");
        exit;
    } else {
        registrarAuditoria($conn_auditoria, null, 'Login', 'Login fallido', "Email: $email / clave incorrecta");
        $message = 'Usuario o contraseña incorrectos.';
    }
}
?>
