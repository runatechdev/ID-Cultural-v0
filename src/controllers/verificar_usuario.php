<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

session_start();
require_once __DIR__ . '/../database/db.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = trim($_POST['usuario'] ?? '');
    $password = $_POST['clave'] ?? '';

    if (empty($email) || empty($password)) {
        echo "❌ Faltan datos.";
        exit;
    }

    // 👇 Acá va tu bloque para buscar el usuario con rol
    $stmt = $db->prepare("SELECT id, nombre, password, rol FROM usuarios WHERE email = ?");
    $stmt->execute([$email]);
    $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($usuario && password_verify($password, $usuario['password'])) {
        $_SESSION['usuario_id'] = $usuario['id'];
        $_SESSION['nombre'] = $usuario['nombre'];
        $_SESSION['rol'] = $usuario['rol'];

        // 🔁 Respuesta según rol
        if ($usuario['rol'] === 'admin') {
            echo "✅admin";
        } elseif ($usuario['rol'] === 'user') {
            echo "✅user";
        } else {
            echo "✅otro";
        }
    } else {
        echo "❌ Usuario o contraseña incorrectos.";
    }
}
