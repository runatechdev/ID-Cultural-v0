<?php
//session_start();

require_once(__DIR__ . '/../../../../security/auditoria.php');
echo "✅ Conexión OK: " . (conectarAuditoria() instanceof PDO ? "Sí" : "No");
require_once(__DIR__ . '/../../../../security/funciones.php');
require_once(__DIR__ . '/../../../../security/csrf.php');

//------
require_once(__DIR__ . '/../../../../security/detectar_sql.php');

$conn_auditoria = conectarAuditoria();
escanear_inyecciones($conn_auditoria);

//-----

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // 1. Validar CSRF
    if (!verificar_token_csrf($_POST['token'] ?? '')) {
        die("Token CSRF inválido");
    }

    // 2. Sanitizar entradas
    $usuario = limpiar_entrada($_POST['usuario'] ?? '');
    $clave = limpiar_entrada($_POST['clave'] ?? '');

    // 3. Validar posibles inyecciones
    if (contiene_inyeccion($usuario) || contiene_inyeccion($clave)) {
        registrarAuditoria($conn_auditoria, null, 'Inyección SQL', 'Intento de inyección en login', "Usuario: '$usuario'");
        die("Parámetros inválidos detectados");
    }

    // 4. Verificar credenciales
    $stmt = $conn->prepare('SELECT id, usuario, clave FROM users WHERE usuario = :usuario');
    $stmt->bindParam(':usuario', $usuario);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($clave, $user['clave'])) {
        $_SESSION['user_id'] = $user['id'];
        registrarAuditoria($conn_auditoria, $user['id'], 'Login', 'Login exitoso', 'Usuario inició sesión correctamente');
        echo json_encode(['success' => true]);
    } else {
        registrarAuditoria($conn_auditoria, null, 'Login', 'Login fallido', "Usuario: $usuario / Clave incorrecta");
        echo json_encode(['success' => false, 'message' => 'Credenciales incorrectas']);
    }
    exit;
}
?>
