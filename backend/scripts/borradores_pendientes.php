<?php
require_once __DIR__ . '/../config/connection.php';

try {
    $sql = "
    CREATE TABLE IF NOT EXISTS borradores_pendientes (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        borrador_id INTEGER NOT NULL,
        usuario_id INTEGER NOT NULL,
        titulo TEXT NOT NULL,
        descripcion TEXT NOT NULL,
        categoria TEXT NOT NULL,
        campos_extra TEXT,
        multimedia TEXT,
        estado TEXT DEFAULT 'pendiente_validacion',
        fecha_envio TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (usuario_id) REFERENCES artistas(id) ON DELETE CASCADE
    );
    ";

    $pdo->exec($sql);
    echo "✅ Tabla 'borradores_pendientes' creada exitosamente.";
} catch (PDOException $e) {
    echo "❌ Error al crear la tabla: " . $e->getMessage();
}
