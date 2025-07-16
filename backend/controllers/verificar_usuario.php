<?php
session_start();
require_once __DIR__ . '/../config/connection.php';

header('Content-Type: application/json');

$email = strtolower(trim($_POST['email'] ?? ''));
$password = trim($_POST['password'] ?? '');

$stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
$stmt->execute([$email]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

// Opcional: log temporal
// error_log("Usuario: " . json_encode($user));

if ($user && password_verify($password, $user['password'])) {
    $_SESSION['user'] = $user;

    echo json_encode([
        "status" => "ok",
        "role" => $user['role']
    ]);
} else {
    echo json_encode([
        "status" => "error",
        "message" => "Usuario o contraseña incorrectos."
    ]);
}
?>
