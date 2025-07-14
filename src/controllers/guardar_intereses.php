<?php
require_once __DIR__ . '/../database/db.php';
require_once __DIR__ . '/../security/auditoria.php';

$conn_auditoria = conectarAuditoria();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = trim($_POST['email'] ?? '');
    $intereses = $_POST['intereses'] ?? [];

    if (!$email || empty($intereses)) {
        echo "Faltan datos para guardar los intereses.";
        registrarAuditoria($conn_auditoria, null, 'Intereses', 'No Guardado', 'Faltan datos para ser guardado');
        exit;
    }

    $stmt = $db->prepare("SELECT id FROM usuarios WHERE email = ?");
    $stmt->execute([$email]);
    $usuario = $stmt->fetch();

    if (!$usuario) {
        echo "Usuario no encontrado.";
        registrarAuditoria($conn_auditoria, null, 'Intereses', 'No Guardado', 'No se encuentra el usuario');
        exit;
    }

    $usuarioId = $usuario["id"];

    // Limpiar intereses anteriores si el usuario repite el paso
    $db->prepare("DELETE FROM intereses_usuario WHERE usuario_id = ?")->execute([$usuarioId]);

    $stmt = $db->prepare("INSERT INTO intereses_usuario (usuario_id, interes) VALUES (?, ?)");

    foreach ($intereses as $interes) {
        $stmt->execute([$usuarioId, $interes]);
    }

    echo "✅ Intereses guardados correctamente";
    registrarAuditoria($conn_auditoria, $usuarioId, 'Intereses', 'Guardado', 'Todos los pasos completados');
}
?>
