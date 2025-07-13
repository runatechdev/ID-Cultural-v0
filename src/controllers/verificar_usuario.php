<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

session_start();
require_once __DIR__ . '/../src/models/db.php'; // Ajustado a tu estructura de carpetas

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = trim($_POST['usuario'] ?? '');
    $clave = $_POST['clave'] ?? '';

    if (empty($email) || empty($clave)) {
        echo "❌ Faltan datos.";
        exit;
    }

    try {
        $stmt = $db->prepare("SELECT id, nombre, password, rol FROM usuarios WHERE email = ?");
        $stmt->execute([$email]);
        $usuarioDB = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($usuarioDB) {
            if (password_verify($clave, $usuarioDB['password'])) {
                $_SESSION['usuario_id'] = $usuarioDB['id'];
                $_SESSION['nombre'] = $usuarioDB['nombre'];
                $_SESSION['rol'] = $usuarioDB['rol'];

                switch (strtolower($usuarioDB['rol'])) {
                    case 'administrador':
                        echo "✅admin";
                        break;
                    case 'usuario':
                        echo "✅user";
                        break;
                    case 'superusuario':
                        echo "✅otro";
                        break;
                    default:
                        echo "✅otro";
                        break;
                }
            } else {
                echo "❌ Usuario o contraseña incorrectos.";
            }
        } else {
            echo "❌ Usuario no encontrado.";
        }
    } catch (Exception $e) {
        error_log("Error: " . $e->getMessage());
        echo "❌ Error interno del servidor.";
    }
}
