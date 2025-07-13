
<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

session_start();
require_once __DIR__ . '/../database/db.php';

// Verificamos que sea una petición POST
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = trim($_POST['usuario'] ?? '');
    $password = $_POST['clave'] ?? '';

    // Validación básica
    if (empty($email) || empty($password)) {
        echo "❌ Faltan datos.";
        exit;
    }

    // Buscar usuario por email, incluyendo el campo 'rol'
    $stmt = $db->prepare("SELECT id, nombre, password, rol FROM usuarios WHERE email = ?");
    $stmt->execute([$email]);
    $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

    // Validar existencia y contraseña
    if ($usuario && password_verify($password, $usuario['password'])) {
        // Guardamos datos en sesión
        $_SESSION['usuario_id'] = $usuario['id'];
        $_SESSION['nombre'] = $usuario['nombre'];
        $_SESSION['rol'] = $usuario['rol']; // ahora también tenés el rol

        echo "✅ Login correcto como {$usuario['rol']}";
    } else {
        echo "❌ Usuario o contraseña incorrectos.";
    }
}
?>
