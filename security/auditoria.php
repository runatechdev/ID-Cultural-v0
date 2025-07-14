<?php
function conectarAuditoria() {
    $rutaDB = __DIR__ . '/../database/auditoria.sqlite';

    try {
        $conn = new PDO("sqlite:" . $rutaDB);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $conn;
    } catch (PDOException $e) {
        die("Error al conectar con auditoria.sqlite: " . $e->getMessage());
    }
}

function registrarAuditoria($conn, $usuario_id, $componente, $evento, $descripcion) {
    $ip = $_SERVER['REMOTE_ADDR'] ?? 'IP desconocida';
    $user_agent = $_SERVER['HTTP_USER_AGENT'] ?? 'Agente no disponible';

    try {
        $sql = "INSERT INTO auditoria (usuario_id, componente, evento, descripcion, ip_origen, user_agent)
                VALUES (:usuario_id, :componente, :evento, :descripcion, :ip, :user_agent)";
                
        $stmt = $conn->prepare($sql);
        $stmt->execute([
            ':usuario_id' => $usuario_id,
            ':componente' => $componente,
            ':evento'     => $evento,
            ':descripcion'=> $descripcion,
            ':ip'         => $ip,
            ':user_agent' => $user_agent
        ]);
        //echo "✅ Evento registrado con éxito.";
    } catch (PDOException $e) {
        error_log("❌ Error al guardar auditoría: " . $e->getMessage());
        //echo "❌ Error al guardar auditoría: " . $e->getMessage();
    }
}
?>



?>
