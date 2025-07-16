<?php
session_start();
// Asegúrate de que la ruta a tu conexión sea la correcta
require_once __DIR__ . '/../config/connection.php'; 

header('Content-Type: application/json');

$email = strtolower(trim($_POST['email'] ?? ''));
$password = trim($_POST['password'] ?? '');


// Verificamos que no vengan vacíos (de la versión de arriba)
if (!$email || !$password) {
    echo json_encode([
        "status" => "error",
        "message" => "Faltan datos de acceso"
    ]);
    exit;
}

$user = null;

// --- LÓGICA COMBINADA ---
// Primero, buscamos en la tabla 'usuarios' (nombre corregido)
$stmt = $pdo->prepare("SELECT id, email, password, role FROM users WHERE email = ?");
$stmt->execute([$email]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if ($user && password_verify($password, $user['password'])) {
    
    // ----- CAMBIO 2: Guardamos los datos de sesión como los espera el navbar -----
    $_SESSION['user_id'] = $user['id'];
    $_SESSION['user_role'] = $user['role']; // Asegúrate de que la columna se llame 'role' en tu tabla

    // Enviamos la respuesta JSON de éxito
    echo json_encode([
        "status" => "ok",
        "role" => $user['role']
    ]);
} else {
    // Usuario o contraseña incorrectos
    echo json_encode([
        "status" => "error",
        "message" => "Usuario o contraseña incorrectos."
    ]);
}
?>