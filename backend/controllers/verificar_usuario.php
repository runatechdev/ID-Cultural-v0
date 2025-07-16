<?php
session_start();
// Asegúrate de que la ruta a tu conexión sea la correcta
require_once __DIR__ . '/../config/connection.php'; 

header('Content-Type: application/json');

// Obtenemos los datos del formulario (de la versión de arriba)
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

// Si no se encontró, buscamos en la tabla 'artistas' (lógica de la versión de arriba)
if (!$user) {
    $stmt = $pdo->prepare("SELECT id, email, password FROM artistas WHERE email = ?");
    $stmt->execute([$email]);
    $artista = $stmt->fetch(PDO::FETCH_ASSOC);

    // Si lo encontramos como artista, le asignamos el rol manualmente
    if ($artista) {
        $artista['role'] = 'artista';
        $user = $artista;
    }
}

// Ahora, verificamos la contraseña y gestionamos la sesión
if ($user && password_verify($password, $user['password'])) {
    
    // Guardamos los datos de sesión como los espera el navbar (de la versión de abajo)
    $_SESSION['user_id'] = $user['id'];
    $_SESSION['user_role'] = $user['role'];

    // Creamos la respuesta JSON con redirección (de la versión de arriba)
    switch ($user['role']) {
        case 'admin':
            $redirect = '/ID-Cultural/src/views/pages/user/dashboard-adm.php';
            break;
        case 'editor':
            $redirect = '/ID-Cultural/src/views/pages/editor/panel_editor.php';
            break;
        case 'validador':
            $redirect = '/ID-Cultural/src/views/pages/auth/validador.php';
            break;
        case 'artista':
            $redirect = '/ID-Cultural/src/views/pages/user/dashboard-user.php';
            break;
        default:
            $redirect = '/ID-Cultural/index.php';
            break;
    }

    echo json_encode([
        "status" => "ok",
        "role" => $user['role'],
        "redirect" => $redirect
    ]);

} else {
    // Usuario o contraseña incorrectos
    echo json_encode([
        "status" => "error",
        "message" => "Usuario o contraseña incorrectos"
    ]);
}
?>