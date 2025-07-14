<?php
session_start();

require_once __DIR__ . '/../login_php/database.php'; // conexión SQLite
require_once __DIR__ . '/../security/detectarsql.php'; // detector y función de auditoría

// Validar datos recibidos
$usuario = $_POST['usuario'] ?? '';
$clave = $_POST['clave'] ?? '';

if (empty($usuario) || empty($clave)) {
    die("Faltan datos");
}

// Consultar en la base de datos (tabla usuarios)
try {
    $stmt = $conn->prepare("SELECT * FROM usuarios WHERE nombre = :usuario LIMIT 1");
    $stmt->execute([':usuario' => $usuario]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && $clave === '1234') { // ⚠️ reemplazar con clave real o verificación con hash
        $_SESSION['usuario_id'] = $user['id'];
        $_SESSION['nombre'] = $user['nombre'];

        registrarAuditoria($conn, $user['id'], 'Login', 'Inicio exitoso', "Usuario: $usuario");
        header("Location: /panel.php");
        exit;
    } else {
        registrarAuditoria($conn, null, 'Login', 'Fallo de inicio', "Intento fallido con usuario: $usuario");
        header("Location: login_error.html"); // mostrará error
        exit;
    }
} catch (PDOException $e) {
    die("Error: " . $e->getMessage());
}
